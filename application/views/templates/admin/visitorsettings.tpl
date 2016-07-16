<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='admin/visitorsettings'}
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
        {include file='static/topMenu.tpl' navActive='visitorsettings'}
        <div id="main-block" class="container cyan lighten-3">
             <div class="row">
                {if empty($visitorList)}
                    <div class="col s12">
                        <p>&nbsp;&nbsp;Es gibt zurzeit keine registrierten Besucher</p>
                    </div>
                {else}
                    <div class="col s10 offset-s1">
                        {if $user->authenticate() && $user->isAdmin()}
                            <table class="bordered">
                                <thead>
                                  <tr>
                                      <th>#Id</th>
                                      <th data-field="price">1x aktiviert</th>
                                      <th data-field="id">Benutzername</th>
                                      <th data-field="name">E-Mail-Adresse</th>
                                      <th data-field="price">Ist aktiv</th>
                                      <th data-field="price">Anpassen</th>
                                      <th data-field="price">Löschen</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    {foreach from=$visitorList item=userData}
                                        <tr>
                                            <td>
                                                {$userData.id}
                                            </td>
                                            <td>
                                                {if $userData.activatedOnce == 1}
                                                    <i class="material-icons small left activatedOnce">
                                                        cloud_done
                                                    </i>
                                                {else}
                                                    <i class="material-icons small left requestActivatedOnce">
                                                        cloud_upload
                                                    </i>
                                                {/if}
                                            </td>
                                            <td>
                                                {$userData.name}
                                            </td>
                                            <td>
                                                {$userData.email}
                                            </td>
                                            <td>
                                                <i class="material-icons small left">
                                                {if $userData.active == 1}
                                                    done
                                                {else}
                                                    clear
                                                {/if}
                                                </i>
                                            </td>
                                            <td>
                                                {if $userData.active == 0}
                                                    <a style="width: 180px;" class="waves-effect waves-light btn" href="/admin/visitorsettings?userId={$userData.id}&mode=activate">
                                                        Aktivieren
                                                    </a>
                                                {else}
                                                    <a style="width: 180px;"  class="waves-effect waves-light btn" href="/admin/visitorsettings?userId={$userData.id}&mode=deactivate">
                                                        Deaktivieren
                                                    </a>
                                                {/if}
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Wollen Sie den Account wirklich löschen');" href="/admin/visitorsettings?userId={$userData.id}&mode=delete">
                                                    <button class="btn waves-effect waves-light submitBtn btnSmall" type="submit" name="action">
                                                        <i class="material-icons tiny right">ic_delete_forever</i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        {/if}
                    </div>
                {/if}
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>