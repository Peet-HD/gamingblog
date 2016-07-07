<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview'}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block">
            <span>Your account-registration has been registered. You will receive an email, when it has been activated.</span>
            <br/></br>
            <a href="{$urlHelper->url(['controller' => 'blog', 'action' => 'overview'])}">Back to the overview</>
        </div>
            {include file='static/sidebar.tpl'}
    </body>
</html>