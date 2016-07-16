<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1'}
        <!-- eventuell zusatz-javascript script-->
        {if $user->authenticate() && $user->isAdmin()}
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>
                tinymce.init({ 
                    selector:'textarea',
                    toolbar: 'undo redo | styleselect | bold italic | link image'
                });
           </script>
        {/if}
    </head>
    <body>
        {include file='static/topMenu.tpl' navActive='generalcontent'}
        <div id="main-block" class="container cyan lighten-3">
             <div class="row">
                 <form action="/admin/savecontent" method="post">
                    <div class="col s7 offset-s1" style="margin-top:40px;">  
                        <h5>Content [Game]</h5>
                    </div>
                    <div class="col s2" style="margin-top:40px;">  
                        <button class="btn waves-effect waves-light right" type="submit" name="action">Speichern
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div class="col s9 offset-s1" style="margin-top:10px;">  
                        <textarea name="htmlText">{$gameHtmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.game}"/>
                </form>
                
                
                <div class="col s7 offset-s1" style="margin-top:40px;">  
                    <h5>Content [Company]</h5>
                </div>
                <div class="col s2" style="margin-top:40px;">  
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Speichern
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <textarea name="text">{$companyHtmlContent}</textarea>
                </div>
                
                
                <div class="col s7 offset-s1" style="margin-top:40px;">  
                    <h5>Content [About]</h5>
                </div>
                <div class="col s2" style="margin-top:40px;">  
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Speichern
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <textarea name="text">{$aboutHtmlContent}</textarea>
                </div>
                
                
                <div class="col s7 offset-s1" style="margin-top:40px;">  
                    <h5>Content [Privacy]</h5>
                </div>
                <div class="col s2" style="margin-top:40px;">  
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Speichern
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <textarea name="text">{$privacyHtmlContent}</textarea>
                </div>
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>