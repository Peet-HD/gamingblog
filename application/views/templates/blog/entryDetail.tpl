<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id='main-block' class="row cyan darken-2">
            <div class="col s12">
                <header class="ueberschrift left">{$entryDetails.title}</header>
                <h6 class="right">&nbsp;Kategorie: {$entryDetails.categoryName}</h6>
            </div>
            <div class="col s12">
                <section class="content">{$entryDetails.text}</section>
            </div>
            <div class="col s12">
                <ul id="comment" class="cyan lighten-2">
                    <li>
                        <h5>Kommentare:</h5>
                    </li>
                    {if !empty($comment)}
                        {foreach from=$comment item=element}
                            <li>
                                [{$element.timestamp}] - {$element.userName}: {$element.text}
                            </li>
                        {/foreach}
                    {else}
                        <li>
                            >> Es gibt bisher keine Kommentare zum Beitrag <<
                        </li>
                    {/if}
                </ul>
            </div>
            <div class="col s12">
                <footer class="lastline">
                    {if $user->authenticate() && !$user->isAdmin()}
                        {include file='blog/commentary.tpl' blogId=$entryDetails.blogId user=$user}</li>
                    {/if}
                </footer>
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>