<div class="upgrade-item">
    <div>
        <a href="game.php?page=infos&gid={tech_id}">
            <img border=0 src="{dpath}elements/{tech_id}.gif" align="top" width=120 height=120>
        </a>
    </div>
    <div>
        <a href="game.php?page=infos&gid={tech_id}">{tech_name}</a> {tech_level}<br>{tech_descr}<br>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;justify-content: left; align-items: center;" >
            <div style="display: flex; gap: 5px; flex-direction: column;">
                {tech_price}
            </div>
            {search_time}
        </div>
    </div>
    <div style="margin-top: auto; font-size: 16px;">
        {tech_link}
    </div>
</div>