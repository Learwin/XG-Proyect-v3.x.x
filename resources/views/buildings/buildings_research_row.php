<div style="display: flex; gap: 1rem; flex-direction: column; width: 250px; border: 1px solid #415680; padding: 1rem; background-color: #415680;">
    <div>
        <a href="game.php?page=infos&gid={tech_id}">
            <img border=0 src="{dpath}elements/{tech_id}.gif" align="top" width=120 height=120>
        </a>
    </div>
    <div>
        <a href="game.php?page=infos&gid={tech_id}">{tech_name}</a> {tech_level}<br>{tech_descr}<br>
        {tech_price}
        {search_time}
    </div>
    <div style="margin-top: auto;">
        {tech_link}
    </div>
</div>