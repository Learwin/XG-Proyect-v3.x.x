<br />
<div id="content">
    {BuildListScript}
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; width: 100%;">
        {BuildList}
        {list_of_buildings}
        <div style="display: flex; gap: 0.5rem; flex-direction: column; width: 250px; border: 1px solid #415680; padding: 0.5rem; background-color: #41568073;">
            <div class="l" width="80" height="80">
                <a href="game.php?page=infos&gid={i}">
                    <img border="0" src="{dpath}elements/{i}.gif" align="top" width="80" height="80">
                </a>
            </div>
            <div class="l" >
                <a href="game.php?page=infos&gid={i}">{n}</a>{nivel}<br>
                {descriptions}<br>
                {price}
                {time}
            </div>
            <div class="k" style="margin-top: auto;">{click}</div>
        </div>
        {/list_of_buildings}
    </div>
</div>