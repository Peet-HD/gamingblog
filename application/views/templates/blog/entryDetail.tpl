<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id='main-block'>
              {if $user->authenticate() && $user->isAdmin()}
                {include file='blog/adminAddEntry.tpl'}
            {/if}
        {foreach from=$news item=entry}
            {if $entry.blogId eq $smarty.get.blogid}
                <header class="ueberschrift">{$entry.title}</header>
        <section class="content">{$entry.text}</section>
	<footer class="lastline">
            <p>Kategorie: {$entry.categoryName}</p>
            <ul>
                <li></li>
		<li><a href="">Likes</a></li>
                <li><a href="">Kommentare</a></li>
            </ul>
	</footer>
        {/if}
        {/foreach}
        </div>
                {include file='static/sidebar.tpl'}
    </body>
</html>