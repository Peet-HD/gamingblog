<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id='main-block'>
        {foreach from=$news item=entry}
            {if $entry.blogId eq $smarty.get.blogid}
                <header class="ueberschrift">{$entry.title}</header>
        <section class="content">{$entry.text}</section>
	<footer class="lastline">
            <p>Kategorie: {$entry.categoryName}</p>
            <ul>
                <li>{include file='blog/commentary.tpl'}</li>
            </ul>
	</footer>
        {/if}
        {/foreach}
                        <ul id="comment">
            {foreach from=$comment item=hi}
                {if $hi.blogId eq $smarty.get.blogid}
                <li>
                    {$hi.text}
                </li>
                {/if}
            {/foreach}
        </ul>
        </div>


                {include file='static/sidebar.tpl'}
    </body>
</html>