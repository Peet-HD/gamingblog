<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
        <!-- eventuell zusatz-javascript script-->
        <link rel="stylesheet" type="text/css" href="/assets/layout/{$module}/404.css" />
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block" class="container cyan lighten-3">
             <div class="row">
                <div class="col s8 offset-s2">
                    <h1>.404</h1>
                </div>
                <div class="col s3 offset-s2">
                    <br/>
                    <img src="/assets/img/birdo.png" />
                </div>
                <div class="col s6">
                    <br/>
                    <h3>Die angeforderte Seite konnte leider nicht gefunden werden..</h3>
                    <br/>
                    <h5>Versuchs doch mal in der <a href="/blog/overview">Übersicht</a>.</h5>
                </div>
            </div>
            {include file='static/sidebar.tpl'}
        </div>
    </body>
</html>