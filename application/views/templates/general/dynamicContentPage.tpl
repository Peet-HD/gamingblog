<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
    </head>
    <body>
        {include file='static/topMenu.tpl' navActive=$navName|default:''}
        <div id="main-block" class="container cyan lighten-3" style="padding: 10px 20px;">
             {$pageContent}
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>