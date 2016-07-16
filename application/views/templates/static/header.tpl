<title>GamingBlog</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<!--link rel="stylesheet" type="text/css" href="/assets/layout/cupertino/jquery-ui-1.8.18.custom.css" /-->
{if isset($jQuery)}
    <script type="text/javascript" src="/assets/js/jquery/jquery-3.0.0.min.js"></script>
{/if}
    <script type="text/javascript" src="/assets/js/chat.js"></script>
    
{if isset($jsSource)}
    <script type="text/javascript" src="/assets/js/{$jsSource}.js"></script>
{/if}

<!-- Materialize -->
<link rel="stylesheet" href="/assets/layout/thirdparty/materialize/css/materialize.css">
<script src="/assets/layout/thirdparty/materialize/js/materialize.js"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
<link rel="stylesheet" type="text/css" href="/assets/layout/default.css" />
<link rel="stylesheet" type="text/css" href="/assets/layout/chat.css" />

{if isset($cssSource)}
    <link rel="stylesheet" type="text/css" href="/assets/layout/{$cssSource}/default.css" />
{/if}

<script type="text/javascript">
    {if $user->authenticate()}
        var userName = "{$user->getUserName()}";
    {else}  
        var userName = undefined;
    {/if}
        
    var isAdmin = "{$user->isAdmin()}";
</script>