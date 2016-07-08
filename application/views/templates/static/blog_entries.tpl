{foreach from=$news_entries item=entry}
    <div class="blogeintraege">
	<header class="ueberschrift">{$entry.title}</header>
	<section class="content">{$entry.content}</section>
	<footer class="lastline">
            <ul>
		<li><a href="">Likes</a></li>
                <li><a href="">Kommentare</a></li>
            </ul>
	</footer>
    </div>
{/foreach}