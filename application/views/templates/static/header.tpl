<title>GamingBlog</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/assets/layout/default.css" />
<link rel="stylesheet" type="text/css" href="/assets/layout/chat.css" />

{if isset($cssSource)}
    <link rel="stylesheet" type="text/css" href="/assets/layout/{$cssSource}/default.css" />
{else}
    <link rel="stylesheet" type="text/css" href="/assets/layout/{$module}/default.css" />
{/if}
<!--link rel="stylesheet" type="text/css" href="/assets/layout/cupertino/jquery-ui-1.8.18.custom.css" /-->
{if isset($jQuery)}
    <script type="text/javascript" src="/assets/js/jquery/jquery-3.0.0.min.js"></script>
{/if}
    <script type="text/javascript" src="/assets/js/chat.js"></script>
    
{if isset($jsSource)}
    <script type="text/javascript" src="/assets/js/{$jsSource}.js"></script>
{/if}

{if $user->authenticate()}
    <script type="text/javascript">
        var userName = "{$user->getUserName()}";
    </script>
{/if}