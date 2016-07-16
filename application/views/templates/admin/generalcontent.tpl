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
                <div class="col s9 offset-s1">
                {if isset($saved) && !empty($saved)}
                    <table style="padding: 10px; background-color: green; color: white; width: 100%;">
                        <tr id="successSaved">
                            <td>Der Inhalt der "{$saved}"-page wurde gespeichert.</td>
                        </tr>
                    </table>
                {else}
                    {if isset($err) && !empty($err)}
                        <table style="padding: 10px; background-color: red; color: white; width: 100%;">
                            {if $err == 'invalidId'}
                            <tr id="errorInvalidId">
                                <td>Der Inhalt konnte nicht gespeichert werden (Ungültige Id).</td>
                            </tr>
                            {/if}
                            {if $err == 'game'}
                            <tr id="errorGameContent">
                                <td>Der Inhalt der "game"-page konnte nicht gespeichert werden.</td>
                            </tr>
                            {/if}
                            {if $err == 'company'}
                            <tr id="errorCompanyContent">
                                <td>Der Inhalt der "company"-page konnte nicht gespeichert werden.</td>
                            </tr>
                            {/if}
                            {if $err == 'about'}
                            <tr id="errorAboutContent">
                                <td>Der Inhalt der "about"-page konnte nicht gespeichert werden.</td>
                            </tr>
                            {/if}
                            {if $err == 'privacy'}
                            <tr id="errorPrivacyContent">
                                <td>Der Inhalt der "privacy"-page konnte nicht gespeichert werden.</td>
                            </tr>
                            {/if}
                        </table>
                    {/if}
                {/if}
                </div>
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
                        <textarea name="htmlText{$contentIdData.game}">{$gameHtmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.game}"/>
                    <input type="hidden" name="htmlInitial" value="{$gameHtmlContent}"></input>
                </form>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
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
                        <textarea name="htmlText{$contentIdData.company}">{$companyHtmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.company}"/>
                    <input type="hidden" name="htmlInitial" value="{$companyHtmlContent}"></input>
                </form>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
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
                        <textarea name="htmlText{$contentIdData.about}">{$aboutHtmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.about}"/>
                    <input type="hidden" name="htmlInitial" value="{$aboutHtmlContent}"></input>
                </form>
                
                <div class="col s9 offset-s1" style="margin-top:40px;">  
                    <hr />
                </div>
                
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
                        <textarea name="htmlText{$contentIdData.privacy}">{$privacyHtmlContent}</textarea>
                    </div>
                    <input type="hidden" name="pageId" value="{$contentIdData.privacy}"/>
                    <input type="hidden" name="htmlInitial" value="{$privacyHtmlContent}"></input>
                </form>
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>