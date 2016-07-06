<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview'}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block">
            {$hello}
            {foreach from=$news_entries item=entry}
                Title: {$entry.title}<br>
                Content: {$entry.content}<br>
            {/foreach}  

        </div>
            {include file='static/login_form.tpl'}
            <nav id="sidebar">

                <div id="chat">
                    {include file='static/chat.tpl'}
                </div>
                    {include file='static/category_roll.tpl'}

            </nav>
    </body>
</html>