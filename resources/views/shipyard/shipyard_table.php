<br />
<div id="content">
    {message}
    <form action="" method="post" style="width: 100%;">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; width: 100%;">
            {list_of_items}
            <div style="display: flex; gap: 0.5rem; flex-direction: column; width: 250px; border: 1px solid #415680; padding: 0.5rem; background-color: #41568073;">
                <div class="l">
                    <a href="game.php?page=infos&gid={element}">
                        <img border="0" src="{dpath}elements/{element}.gif" align="top" width="120" height="120" />
                    </a>
                </div>
                <div class="l">
                    <a href=game.php?page=infos&gid={element}>{element_name}</a> {element_nbre}<br>
                    {element_description}<br>
                    {element_price}
                    {building_time}
                </div>
                <div style="margin-top: auto; width: 100%">
                    {add_element}
                </div>
            </div>
            {/list_of_items}
        </div>
        <div style="width: 100%; margin-top: 10px;">
            {build_button}
        </div>
    </form>
    {building_list}
</div>