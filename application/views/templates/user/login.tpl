<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview' jsSource="register"}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block">
            {if isset($adminLogin)}
                {include file='user/login_form.tpl' adminLogin=1}
            {else}
                {include file='user/login_form.tpl'}
            {/if}
        </div>
        {include file='static/sidebar.tpl' hideLogin=1}
    </body>
</html>