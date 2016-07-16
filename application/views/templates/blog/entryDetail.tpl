<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id='main-block'>
            <header class="ueberschrift">{$entryDetails.title}</header>
            <section class="content">{$entryDetails.text}</section>
            <footer class="lastline">
                <p>Kategorie: {$entryDetails.categoryName}</p>
                {if $user->authenticate() && !$user->isAdmin()}
                    <ul>
                        <li>{include file='blog/commentary.tpl' blogId=$entryDetails.blogId user=$user}</li>
                    </ul>
                {/if}
            </footer>
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