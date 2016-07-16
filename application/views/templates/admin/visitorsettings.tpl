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
                                      <th>#</th>
                                      <th data-field="price">Neue Anfrage</th>
                                      <th data-field="id">Benutzername</th>
                                      <th data-field="name">E-Mail-Adresse</th>
                                      <th data-field="price">Aktiv</th>
                                      <th data-field="price">Anpassen</th>
                                      <th data-field="price">Löschen</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    {counter start=$page|default:0*$elementsPerPage print=false}
                                    {foreach from=$visitorList item=userData}
                                        <tr>
                                            <td>
                                                {counter}
                                            </td>
                                            <td>
                                                {if $userData.activatedOnce == 0}
                                                    <i class="material-icons small left iconBlock requestActivatedOnce">
                                                        live_help
                                                    </i>
                                                {else}
                                                    -
                                                {/if}
                                            </td>
                                            <td>
                                                {$userData.name}
                                            </td>
                                            <td>
                                                {$userData.email}
                                            </td>
                                            <td>
                                                {if $userData.active == 1}
                                                    <i class="material-icons small left iconBlock activated">
                                                        done
                                                    </i>
                                                {else}
                                                    <i class="material-icons small left iconBlock deactivated">
                                                        clear
                                                    </i>
                                                {/if}
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
                <div class="col s12 center" id="pagination">
                    <span>Seitenauswahl</span>
                </div>
                <div class="col s4 offset-s4 center" id="pagination">
                    <div style="display: inline-block;">
                        {if $maxPage <= 4}
                            {for $countVar = 0 to $maxPage}
                                {if $countVar == $page}
                                    <a class="waves-effect waves-light btn pageBtn red pageElement" onclick="return false;">
                                        {$countVar + 1}
                                    </a>
                                {else}
                                    <a class="waves-effect waves-light btn pageBtn" href="/admin/visitorsettings?page={$countVar}">
                                        {$countVar + 1}
                                    </a>
                                {/if}
                            {/for}
                        {else}
                            {if (($maxPage > 1) && ($page > 1))}
                                <a class="waves-effect waves-light btn pageBtn" href="/admin/visitorsettings?page=0">
                                    1
                                </a>
                                {if ($page > 2)}
                                    <a class="waves-effect waves-light btn pageBtn disabled" onclick="return false;">
                                        ..
                                    </a>
                                {/if}
                            {/if}
                            {if ($page > 0)}
                                <a class="waves-effect waves-light btn pageBtn" href="/admin/visitorsettings?page={$page - 1}">
                                    {$page}
                                </a>
                            {/if}

                            <a class="waves-effect waves-light btn pageBtn red pageElement" onclick="return false;">
                                {$page + 1}
                            </a>

                            {if ($page < $maxPage)}
                                <a class="waves-effect waves-light btn pageBtn" href="/admin/visitorsettings?page={$page + 1}">
                                    {$page + 2}
                                </a>
                            {/if}
                            {if ((($maxPage - $page) >= 2) && ($page != $maxPage))}
                                {if ($page < ($maxPage - 2))}
                                    <a class="waves-effect waves-light btn pageBtn disabled" onclick="return false;">
                                        ..
                                    </a>
                                {/if}
                                <a class="waves-effect waves-light btn pageBtn" href="/admin/visitorsettings?page={$maxPage}">
                                    {$maxPage + 1}
                                </a>
                            {/if}
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        {include file='static/sidebar.tpl'}
    </body>
</html>