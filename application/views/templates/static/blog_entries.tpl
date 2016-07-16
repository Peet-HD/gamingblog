{foreach from=$news_entries item=entry}
    <div class="blogeintraege">
	<header class="ueberschrift">{$entry.title}</header>
        <h5></h5>
        <section class="content">{$entry.text|truncate:1200:false}</section>
	<footer class="lastline">
            <p>Kategorie: {$entry.categoryName}</p>
            <ul>  
                <li>{$entry.blogId}</li>
                <li><a href='{$urlHelper->url(["controller" => "blog", "action" => "entrydetail"])}?blogid={$entry.blogId}'>mehr</a></li>
		<li><a href="">Likes</a></li>
                <li><a href="">Kommentare</a></li>
            </ul>
	</footer>
    </div>
{/foreach}