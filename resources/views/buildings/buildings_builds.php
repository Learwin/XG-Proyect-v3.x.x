
<link rel="stylesheet" href="../../../public/css/newStyles.css">
<br />
<div id="content">
    {BuildListScript}
    <div class="upgrade-item">
        {BuildList}
    </div>
    <div class="upgrade-container" style="margin-top: 1rem;">
        {list_of_buildings}
        <div class="upgrade-item">
            <div class="l" width="80" height="80">
                <a href="game.php?page=infos&gid={i}">
                    <img border="0" src="{dpath}elements/{i}.gif" align="top" width="80" height="80">
                </a>
            </div>
            <a href="game.php?page=infos&gid={i}">{n}</a>{nivel}

            <div style="display: flex; flex-direction: column; gap: 0.5rem;justify-content: left; align-items: center;" >
                <br>
                <div style="display: flex; gap: 5px;">
                    {price}
                </div>
                {time}
            </div>
            <div class="k" style="margin-top: auto; font-size: 16px;">{click}</div>
        </div>
        {/list_of_buildings}
    </div>
</div>