{foreach from=$news_entries item=entry}
    <div class="blogeintraege">
	<header class="ueberschrift">{$entry.title}</header>
	<section class="content">{$entry.text|truncate:1200:'...'}</section>
	<footer class="lastline">
            <p>Kategorie: {$entry.categoryName}</p>
            <ul>
		<li><a href="">Likes</a></li>
                <li><a href="">Kommentare</a></li>
            </ul>
	</footer>
    </div>
{/foreach}