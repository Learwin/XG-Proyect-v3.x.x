<?php

declare(strict_types=1);

namespace App\Http\Controllers\Game;

use App\Core\BaseController;
use App\Helpers\UrlHelper;
use App\Libraries\DevelopmentsLib;
use App\Libraries\FormatLib;
use App\Libraries\Functions;
use App\Libraries\Users;
use App\Models\Game\Empire;
use Exception;

class EmpireController extends BaseController
{
    public const MODULE_ID = 2;

    private Empire $empireModel;

    public function __construct()
    {
        parent::__construct();

        // check if session is active
        Users::checkSession();

        // load Language
        parent::loadLang(['game/global', 'game/constructions', 'game/defenses', 'game/technologies', 'game/ships', 'game/empire']);

        $this->empireModel = new Empire();
    }

    public function index(): void
    {
        // Check module access
        Functions::moduleMessage(Functions::isModuleAccesible(self::MODULE_ID));

        // build the page
        $this->buildPage();
    }

    private function buildPage(): void
    {
        $this->page->display(
            $this->template->set(
                'game/empire_view',
                array_merge(
                    $this->langs->language,
                    $this->buildBlocks()
                )
            )
        );
    }

    /**
     * Build all the different blocks
     *
     * @return array
     */
    private function buildBlocks(): array
    {
        $empire_data = $this->empireModel->getAllPlayerData((int) $this->user['user_id']);

		foreach (['metal', 'crystal', 'deuterium'] as $element) {
			$empire[$element . '_current_sum_np'] = 0;
			$empire[$element . '_production_sum_np'] = 0;
		}
        foreach ($empire_data as $planet) {
            // general data
            foreach (['image', 'name', 'coords', 'fields'] as $element) {
                $empire[$element][] = $this->{'set' . ucfirst($element)}($planet);
            }

            // resources data
            foreach (['metal', 'crystal', 'deuterium', 'energy'] as $element) {
                $empire[$element . '_row'][] = $this->setResources($planet, $element);
				if ($element != 'energy'){
					$empire[$element . '_current_sum_np'] = $empire[$element . '_current_sum_np'] + $planet['planet_' . $element];
					$empire[$element . '_production_sum_np'] = $empire[$element . '_production_sum_np'] + $planet['planet_' . $element . '_perhour'] + Functions::readConfig($element . '_basic_income');
				}
			}
			foreach (['metal', 'crystal', 'deuterium'] as $element) {
				$empire[$element . '_current_sum'] = FormatLib::prettyNumber($empire[$element . '_current_sum_np']);
				$empire[$element . '_production_sum'] = FormatLib::prettyNumber($empire[$element . '_production_sum_np']);
			}

            // structures and technologies data
            foreach (['resources', 'facilities', 'fleet', 'defenses', 'missiles', 'tech'] as $element) {
                $source = $planet;

                if ($element == 'tech') {
                    $source = $this->user;
                }

                foreach ($this->objects->getObjectsList($element) as $element_id) {
                    if (!isset($empire[$element][$this->objects->getObjects($element_id)])) {
                        $empire[$element][$this->objects->getObjects($element_id)]['value'] = '<th width="75px">' . (string) $this->langs->line($this->objects->getObjects($element_id)) . '</th>';
                    }

                    $empire[$element][$this->objects->getObjects($element_id)]['value'] .= '<th width="75px">' . $this->setStructureData($planet, $source, $element, $element_id) . '</th>';
                }
            }
        }

        return array_merge(
            [
                'amount_of_planets' => count($empire_data) + 1,
            ],
            $empire
        );
    }

    /**
     * Set the planet image
     *
     * @param array $planet
     * @return array
     */
    private function setImage(array $planet): array
    {
        return [
            'planet_id' => $planet['planet_id'],
            'planet_image' => $planet['planet_image'],
            'dpath' => DPATH,
        ];
    }

    /**
     * Set the planet image
     *
     * @param array $planet
     * @return string
     */
    private function setName(array $planet): array
    {
        return [
            'planet_name' => $planet['planet_name'],
        ];
    }

    /**
     * Set the planet coordinates
     *
     * @param array $planet
     * @return array
     */
    private function setCoords(array $planet): array
    {
        return [
            'planet_coords' => FormatLib::prettyCoords((int) $planet['planet_galaxy'], (int) $planet['planet_system'], (int) $planet['planet_planet']),
            'planet_galaxy' => $planet['planet_galaxy'],
            'planet_system' => $planet['planet_system'],
        ];
    }

    /**
     * Set the planet fields
     *
     * @param array $planet
     * @return array
     */
    private function setFields(array $planet): array
    {
        return [
            'planet_field_current' => $planet['planet_field_current'],
            'planet_field_max' => $planet['planet_field_max'],
        ];
    }

    /**
     * Set the planet resources
     *
     * @param array $planet
     * @param string $resource
     * @return array
     */
    private function setResources(array $planet, string $resource): array
    {
        if ($resource == 'energy') {
            return [
                'used_energy' => (FormatLib::prettyNumber($planet['planet_energy_max'] + $planet['planet_energy_used'])),
                'max_energy' => FormatLib::prettyNumber($planet['planet_energy_max']),
            ];
        }

        return [
            'planet_id' => $planet['planet_id'],
            'planet_type' => $planet['planet_type'],
            'planet_current_amount' => FormatLib::prettyNumber($planet['planet_' . $resource]),
            'planet_production' => (
                FormatLib::prettyNumber($planet['planet_' . $resource . '_perhour'] + Functions::readConfig($resource . '_basic_income'))
            ),
			'current_amount' => $planet['planet_' . $resource],
			'production' => $planet['planet_' . $resource . '_perhour'] + Functions::readConfig($resource . '_basic_income'),
        ];
    }

    /**
     * Sets the structure data
     *
     * @param array $planet
     * @param array $source
     * @param string $element
     * @param integer $element_id
     * @return string
     */
    private function setStructureData(array $planet, array $source, string $element, int $element_id): string
    {
        switch ($element) {
            case 'resources':
            case 'facilities':
                $page = DevelopmentsLib::setBuildingPage($element_id);
                break;
            case 'tech':
                $page = 'research';
                break;
            case 'fleet':
                $page = 'shipyard';
                break;
            case 'defenses':
            case 'missiles':
                $page = 'defense';
                break;
            default:
                throw new Exception('Undefined element type "' . $element . '". Only possible: build, tech, fleet, defenses and missiles.');
                break;
        }

        $url = 'game.php?page=' . $page . '&cp=' . $planet['planet_id'] . '&re=0&planettype=' . $planet['planet_type'];

        return UrlHelper::setUrl(
            $url,
            $source[$this->objects->getObjects($element_id)]
        );
    }
}
