<ul class="collapsible" data-collapsible="accordion">
    {counter start=$page|default:0*$elementsPerPage|default:0 print=false}
    {foreach from=$news_entries item=entry}
        <li>
            {if $user->isAdmin()}
            <div class="collapsible-header"><i class="material-icons">none</i>#{counter}&nbsp;&nbsp;-&nbsp;&nbsp;{$entry.title}</div>
            <div class="collapsible-body">
            {/if}
                <div class="blogeintraege row">
                    {if $user->authenticate() && $user->isAdmin()}
                        <form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
                            <div class="col s1 center">
                                <h6 style="font-size: 1.3rem;">Titel:</h6>
                            </div>
                            <div class="col s8">
                                <input type='text' name='title' value="{$entry.title}"></input>
                            </div>
                            <div class="col s3">
                                <select name='categoryId'>
                                    {foreach from=$category item=entry}
                                        <option value={$entry.categoryId}>
                                            {$entry.categoryName}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                            <input hidden='true' name='blogId' value='{$entry.blogId}'></input>
                            <div class="col s12" style="padding-top:12px;">
                                <textarea class='' name='text'>
                                    {$entry.text}
                                </textarea>
                            </div>
                            <div class="col s12" style="padding-top:12px;">
                                <form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
                                    <input hidden='true' name='blogId' value='{$entry.blogId}'></input>
                                    <button style='background-color:#e53935; margin-right: 10px;' name="delete" value="1" class='btn waves-effect waves-teal right' type='submit'>Löschen</button>
                                </form>
                                <button class='btn waves-effect waves-teal  right' type="submit">Ändern</button>
                            </div>
                        </form>
                        <div class="col s12" style="">
                            <hr/>
                        </div>
                    {else}
                        <div class="col s12">
                            <header class="ueberschrift left">{$entry.title}</header>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <div class="col s12">
                            <section class="content">{$entry.text|truncate:3000:'...'}</section>
                        </div>

                        <div class="col s12">
                            <footer class="lastline">
                                <p>&nbsp;Kategorie: {$entry.categoryName}</p>
                                
                                <a class="waves-effect waves-light btn" href="{$urlHelper->url(["controller" => "blog", "action" => "entrydetail"])}?blogid={$entry.blogId}">
                                    Mehr
                                </a>
                                <a class="waves-effect waves-light btn" href="">
                                    Kommentare
                                </a>
                            </footer>
                        </div>
                    {/if}
                </div>
            {if $user->isAdmin()}
            </div>
                    {/if}
        </li>
    {/foreach}
</ul>
{include file='static/pagination.tpl' baseLink='/blog/overview'}