<br />
<div id="content">
    {message}
    <form action="" method="post" style="width: 100%;">
        <div class="upgrade-container">
            {list_of_items}
            <div class="upgrade-item">
                <div class="l">
                    <a href="game.php?page=infos&gid={element}">
                        <img border="0" src="{dpath}elements/{element}.gif" align="top" width="120" height="120" />
                    </a>
                </div>
                <div class="l">
                    <a href=game.php?page=infos&gid={element}>{element_name}</a> {element_nbre}<br>
                    {element_description}<br>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;justify-content: left; align-items: center;" >
                        <div style="display: flex; gap: 5px; flex-direction: column;">
                            {element_price}
                        </div>
                        {building_time}
                    </div>
                </div>
                <div style="margin-top: auto; width: 100%">
                    {add_element}
                </div>
            </div>
            {/list_of_items}
        </div>
        <div style="width: 100%; margin-top: 10px; font-size: 16px;">
            {build_button}
        </div>
    </form>
    {building_list}
</div>