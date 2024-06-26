<?php

declare(strict_types=1);

namespace App\Http\Controllers\Adm;

use App\Core\BaseController;
use App\Helpers\UrlHelper;
use App\Libraries\Adm\AdministrationLib as Administration;
use App\Libraries\Functions;
use App\Models\Adm\Server;
use DateTime;
use DateTimeZone;

class ServerController extends BaseController
{
    private $game_config = [];
    private Server $serverModel;

    public function __construct()
    {
        parent::__construct();

        // check if session is active
        Administration::checkSession();

        // load Language
        parent::loadLang(['adm/global', 'adm/server']);

        $this->serverModel = new Server();
    }

    public function index(): void
    {
        // check if the user is allowed to access
        if (!Administration::authorization(__CLASS__, (int) $this->user['user_authlevel'])) {
            die(Administration::noAccessMessage($this->langs->line('no_permissions')));
        }

        // time to do something
        //$this->runAction();

        // build the page
        $this->buildPage();
    }

    /**
     * Run an action
     *
     * @return void
     */
    private function runAction(): void
    {
        /*
         * SERVER SETTINGS
         */

        // NAME
        if (isset($_POST['game_logo']) && $_POST['game_logo'] != '') {
            $this->game_config['game_logo'] = $_POST['game_logo'];
        }

        // LOGO
        if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
            $this->game_config['game_name'] = $_POST['game_name'];
        }

        // LANGUAGE
        if (isset($_POST['language'])) {
            $this->game_config['lang'] = $_POST['language'];
        } else {
            $this->game_config['lang'];
        }

        // GENERAL RATE
        if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
            $this->game_config['game_speed'] = (2500 * $_POST['game_speed']);
        }

        // SPEED OF FLEET

        if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
            $this->game_config['fleet_speed'] = (2500 * $_POST['fleet_speed']);
        }

        // SPEED OF PRODUCTION
        if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
            $this->game_config['resource_multiplier'] = $_POST['resource_multiplier'];
        }

        // ADMIN EMAIL CONTACT
        if (isset($_POST['admin_email']) && $_POST['admin_email'] != '' && Functions::validEmail($_POST['admin_email'])) {
            $this->game_config['admin_email'] = $_POST['admin_email'];
        }

        // FORUM LINK
        if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
            $this->game_config['forum_url'] = UrlHelper::prepUrl($_POST['forum_url']);
        }

        // ACTIVATE SERVER
        if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
            $this->game_config['game_enable'] = 1;
        } else {
            $this->game_config['game_enable'] = 0;
        }

        // OFF-LINE MESSAGE
        if (isset($_POST['close_reason']) && $_POST['close_reason'] != '') {
            $this->game_config['close_reason'] = addslashes($_POST['close_reason']);
        }

        /*
         * DATE AND TIME PARAMETERS
         */
        // SHORT DATE
        if (isset($_POST['date_time_zone']) && $_POST['date_time_zone'] != '') {
            $this->game_config['date_time_zone'] = $_POST['date_time_zone'];
        }

        if (isset($_POST['date_format']) && $_POST['date_format'] != '') {
            $this->game_config['date_format'] = $_POST['date_format'];
        }

        // EXTENDED DATE
        if (isset($_POST['date_format_extended']) && $_POST['date_format_extended'] != '') {
            $this->game_config['date_format_extended'] = $_POST['date_format_extended'];
        }

        /*
         * SEVERAL PARAMETERS
         */

        // PROTECTION
        if (isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on') {
            $this->game_config['adm_attack'] = 1;
        } else {
            $this->game_config['adm_attack'] = 0;
        }

        // SHIPS TO DEBRIS
        if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
            if ($_POST['Fleet_Cdr'] < 0) {
                $this->game_config['fleet_cdr'] = 0;
                $Number2 = 0;
            } else {
                $this->game_config['fleet_cdr'] = $_POST['Fleet_Cdr'];
                $Number2 = $_POST['Fleet_Cdr'];
            }
        }

        // DEFENSES TO DEBRIS
        if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
            if ($_POST['Defs_Cdr'] < 0) {
                $this->game_config['defs_cdr'] = 0;
                $Number = 0;
            } else {
                $this->game_config['defs_cdr'] = $_POST['Defs_Cdr'];
                $Number = $_POST['Defs_Cdr'];
            }
        }

        // PROTECTION FOR NOVICES
        if (isset($_POST['noobprotection']) && $_POST['noobprotection'] == 'on') {
            $this->game_config['noobprotection'] = 1;
        } else {
            $this->game_config['noobprotection'] = 0;
        }

        // PROTECTION N. POINTS
        if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
            $this->game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
        }

        // PROTECCION N. LIMIT POINTS
        if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti'])) {
            $this->game_config['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
        }
		
		// Catch-Up mechanic
        if (isset($_POST['catchup']) && $_POST['catchup'] == 'on') {
            $this->game_config['st_resource_multiplier'] = 1;
        } else {
            $this->game_config['st_resource_multiplier'] = 0;
        }
		
		// factor below 100%
		if (isset($_POST['catchup100']) && is_numeric($_POST['catchup100'])) {
            $this->game_config['st_resource_multi_100'] = $_POST['catchup100'];
        }
		
		// factor below 80%
		if (isset($_POST['catchup80']) && is_numeric($_POST['catchup80'])) {
            $this->game_config['st_resource_multi_80'] = $_POST['catchup80'];
        }
		
		// factor below 60%
		if (isset($_POST['catchup60']) && is_numeric($_POST['catchup60'])) {
            $this->game_config['st_resource_multi_60'] = $_POST['catchup60'];
        }
		
		// factor below 40%
		if (isset($_POST['catchup40']) && is_numeric($_POST['catchup40'])) {
            $this->game_config['st_resource_multi_40'] = $_POST['catchup40'];
        }
		
		// factor below 20%
		if (isset($_POST['catchup20']) && is_numeric($_POST['catchup20'])) {
            $this->game_config['st_resource_multi_20'] = $_POST['catchup20'];
        }
    }

    private function buildPage(): void
    {
        $this->game_config = $this->serverModel->readAllConfigs();
        $parse = $this->langs->language;
        $parse['alert'] = '';

        if (isset($_POST['opt_save']) && $_POST['opt_save'] == '1') {
            // CHECK BEFORE SAVE
            $this->runAction();

            // update all the settings
            $this->serverModel->updateConfigs($this->game_config);

            $parse['alert'] = Administration::saveMessage('ok', $this->langs->line('se_all_ok_message'));
        }

        $parse['game_name'] = $this->game_config['game_name'];
        $parse['game_logo'] = $this->game_config['game_logo'];
        $parse['language_settings'] = Functions::getLanguages($this->game_config['lang']);
        $parse['game_speed'] = $this->game_config['game_speed'] / 2500;
        $parse['fleet_speed'] = $this->game_config['fleet_speed'] / 2500;
        $parse['resource_multiplier'] = $this->game_config['resource_multiplier'];
        $parse['admin_email'] = $this->game_config['admin_email'];
        $parse['forum_url'] = $this->game_config['forum_url'];
        $parse['closed'] = $this->game_config['game_enable'] == 1 ? " checked = 'checked' " : '';
        $parse['close_reason'] = stripslashes($this->game_config['close_reason']);
        $parse['date_time_zone'] = $this->timeZonePicker();
        $parse['date_format'] = $this->game_config['date_format'];
        $parse['date_format_extended'] = $this->game_config['date_format_extended'];
        $parse['adm_attack'] = $this->game_config['adm_attack'] == 1 ? " checked = 'checked' " : '';
        $parse['ships'] = $this->percentagePicker($this->game_config['fleet_cdr']);
        $parse['defenses'] = $this->percentagePicker($this->game_config['defs_cdr']);
        $parse['noobprot'] = $this->game_config['noobprotection'] == 1 ? " checked = 'checked' " : '';
        $parse['noobprot2'] = $this->game_config['noobprotectiontime'];
        $parse['noobprot3'] = $this->game_config['noobprotectionmulti'];
		$parse['catchup'] = $this->game_config['st_resource_multiplier'] == 1 ? " checked = 'checked' " : '';
		$parse['catchup100'] = $this->game_config['st_resource_multi_100'];
		$parse['catchup80'] = $this->game_config['st_resource_multi_80'];
		$parse['catchup60'] = $this->game_config['st_resource_multi_60'];
		$parse['catchup40'] = $this->game_config['st_resource_multi_40'];
		$parse['catchup20'] = $this->game_config['st_resource_multi_20'];

        $this->page->displayAdmin(
            $this->template->set('adm/server_view', $parse)
        );
    }

    /**
     * method timeZonePicker
     * param
     * return return the select options
     */
    private function timeZonePicker()
    {
        $utc = new DateTimeZone('UTC');
        $dt = new DateTime('now', $utc);
        $time_zones = '';
        $current_time_zone = $this->serverModel->readConfig('date_time_zone');

        // Get the data
        foreach (DateTimeZone::listIdentifiers() as $tz) {
            $current_tz = new DateTimeZone($tz);
            $offset = $current_tz->getOffset($dt);
            $transition = $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());

            foreach ($transition as $element => $data) {
                $time_zones_data[$data['offset']][] = $tz;
            }
        }

        // Sort by key
        ksort($time_zones_data);

        // Build the combo
        foreach ($time_zones_data as $offset => $tz) {
            $time_zones .= '<optgroup label="GMT' . $this->formatOffset($offset) . '">';

            foreach ($tz as $key => $zone) {
                $time_zones .= '<option value="' . $zone . '" ' . ($current_time_zone == $zone ? ' selected' : '') . ' >' . $zone . '</option>';
            }

            $time_zones .= '</optgroup>';
        }

        // Return data
        return $time_zones;
    }

    /**
     * method formatOffset
     * param
     * return return the format offset
     */
    private function formatOffset($offset)
    {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);

        if ($hour == 0 && $minutes == 0) {
            $sign = ' ';
        }

        return $sign . str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string) $minutes, 2, '0');
    }

    /**
     * Percentage picker
     *
     * @param string $current_percentage Current percentage for the field
     *
     * @return string
     */
    private function percentagePicker($current_percentage)
    {
        $options = '';

        for ($i = 0; $i <= 10; $i++) {
            $selected = '';

            if ($i * 10 == $current_percentage) {
                $selected = ' selected = selected ';
            }

            $options .= '<option value="' . $i * 10 . '"' . $selected . '>' . $i * 10 . '%</option>';
        }

        return $options;
    }
}
