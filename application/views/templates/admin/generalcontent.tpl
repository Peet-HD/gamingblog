<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' jsSource='generalcontent'}
        
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
                <a name="game"></a>
                {if ($saved == 'game') || ($err == 'game')}
                    {include file='admin/info.tpl' saved=$saved err=$err}
                {/if}
                 <form action="/admin/savecontent" method="post">
                    <div class="col s7 offset-s1" style="margin-top:40px;">
                        <h5>Content [Game]</h5>
                    </div>
                    <div class="col s2" style="margin-top:40px;">  
                        <button class="btn waves-effect waves-light right submitBtn" value="{$contentIdData.game}" type="submit" name="action">Speichern
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div id="textParent" class="col s9 offset-s1" style="margin-top:10px;">  
                        <textarea name="htmlText{$contentIdData.game}">{$gameHtmlContent.htmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.game}"/>
                    <input type="hidden" name="htmlInitial" value='{$gameHtmlContent.htmlContent}'></input>
                </form>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <span class="right">Letzte Änderung: {$gameHtmlContent.lastChange}</span>
                </div>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
                <a name="company"></a>
                {if ($saved == 'company') || ($err == 'company')}
                    {include file='admin/info.tpl' saved=$saved err=$err}
                {/if}
                <form action="/admin/savecontent" method="post">
                    <div class="col s7 offset-s1" style="margin-top:40px;">  
                        <h5>Content [Company]</h5>
                    </div>
                    <div class="col s2" style="margin-top:40px;">  
                        <button class="btn waves-effect waves-light right submitBtn" type="submit" value="{$contentIdData.company}" name="action">Speichern
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div class="col s9 offset-s1" style="margin-top:10px;">  
                        <textarea name="htmlText{$contentIdData.company}">{$companyHtmlContent.htmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.company}"/>
                    <input type="hidden" name="htmlInitial" value='{$companyHtmlContent.htmlContent}'></input>
                </form>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <span class="right">Letzte Änderung: {$companyHtmlContent.lastChange}</span>
                </div>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
                <a name="about"></a>
                {if ($saved == 'about') || ($err == 'about')}
                    {include file='admin/info.tpl' saved=$saved err=$err}
                {/if}
                 <form action="/admin/savecontent" method="post">
                    <div class="col s7 offset-s1" style="margin-top:40px;">  
                        <h5>Content [About]</h5>
                    </div>
                    <div class="col s2" style="margin-top:40px;">  
                        <button class="btn waves-effect waves-light right submitBtn" type="submit" value="{$contentIdData.about}" name="action">Speichern
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div class="col s9 offset-s1" style="margin-top:10px;">  
                        <textarea name="htmlText{$contentIdData.about}">{$aboutHtmlContent.htmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.about}"/>
                    <input type="hidden" name="htmlInitial" value='{$aboutHtmlContent.htmlContent}'></input>
                </form>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <span class="right">Letzte Änderung: {$aboutHtmlContent.lastChange}</span>
                </div>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
                <a name="privacy"></a>
                {if ($saved == 'privacy') || ($err == 'privacy')}
                    {include file='admin/info.tpl' saved=$saved err=$err}
                {/if}
                 <form action="/admin/savecontent" method="post">
                    <div class="col s7 offset-s1" style="margin-top:40px;">  
                        <h5>Content [Privacy]</h5>
                    </div>
                    <div class="col s2" style="margin-top:40px;">  
                        <button class="btn waves-effect waves-light right submitBtn" type="submit" value="{$contentIdData.privacy}" name="action">Speichern
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <div class="col s9 offset-s1" style="margin-top:10px;">  
                        <textarea name="htmlText{$contentIdData.privacy}">{$privacyHtmlContent.htmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.privacy}"/>
                    <input type="hidden" name="htmlInitial" value='{$privacyHtmlContent.htmlContent}'></input>
                </form>
                <div class="col s9 offset-s1" style="margin-top:10px;">  
                    <span class="right">Letzte Änderung: {$privacyHtmlContent.lastChange}</span>
                </div>
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>