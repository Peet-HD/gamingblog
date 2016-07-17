<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview'}
        <!-- eventuell zusatz-javascript script-->
        {if $user->authenticate() && $user->isAdmin()}
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('select').material_select();
                });
                tinymce.init({ 
                    plugins: "image",
                    selector:'textarea',
                    forced_root_block : "", 
                    force_br_newlines : true,
                    force_p_newlines : false,
                    toolbar: 'undo redo | styleselect | bold italic | image'
                });
           </script>
        {/if}
    </head>
    <body>
        {include file='static/topMenu.tpl' navActive='main'}
        <div id="main-block" class="cyan lighten-3">
            <div class="row">
                {if $user->authenticate() && $user->isAdmin()}
                    {include file='blog/adminAddEntry.tpl'}
                {/if}
                <div class="col s12">
                    {include file='blog/blog_entries.tpl'}
                </div>    
            </div>
        </div>
         {include file='static/pagination.tpl' baseLink='blog/overview'}
        {include file='static/sidebar.tpl'}
       
    </body>
</html>