<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview'}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block" class="container cyan lighten-3">
             <div class="row">
                <div class="col s4 offset-s4">
                    <br/>
                    <h5>Acccount-Anfrage registriert.</h5>
                    </br>
                    <span>Du erhälst eine Email, sobald der Account aktiviert wird.</span>
                    <br/></br>
                    <a href="{$urlHelper->url(['controller' => 'blog', 'action' => 'overview'])}">Back to the overview</>
                </div>
            </div>
        </div>
            {include file='static/sidebar.tpl'}
    </body>
</html>