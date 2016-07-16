<div class="col s12 center" id="pagination">
    <span>Seitenauswahl</span>
</div>
<div class="col s4 offset-s4 center" id="pagination">
    <div id="pagination" style="display: inline-block;">
        {if $maxPage <= 4}
            {for $countVar = 0 to $maxPage}
                {if $countVar == $page}
                    <a class="waves-effect waves-light btn pageBtn red pageElement" onclick="return false;">
                        {$countVar + 1}
                    </a>
                {else}
                    <a class="waves-effect waves-light btn pageBtn" href="{$baseLink}?page={$countVar}">
                        {$countVar + 1}
                    </a>
                {/if}
            {/for}
        {else}
            {if (($maxPage > 1) && ($page > 1))}
                <a class="waves-effect waves-light btn pageBtn" href="{$baseLink}?page=0">
                    1
                </a>
                {if ($page > 2)}
                    <a class="waves-effect waves-light btn pageBtn disabled" onclick="return false;">
                        ..
                    </a>
                {/if}
            {/if}
            {if ($page > 0)}
                <a class="waves-effect waves-light btn pageBtn" href="{$baseLink}?page={$page - 1}">
                    {$page}
                </a>
            {/if}

            <a class="waves-effect waves-light btn pageBtn red pageElement" onclick="return false;">
                {$page + 1}
            </a>

            {if ($page < $maxPage)}
                <a class="waves-effect waves-light btn pageBtn" href="{$baseLink}?page={$page + 1}">
                    {$page + 2}
                </a>
            {/if}
            {if ((($maxPage - $page) >= 2) && ($page != $maxPage))}
                {if ($page < ($maxPage - 2))}
                    <a class="waves-effect waves-light btn pageBtn disabled" onclick="return false;">
                        ..
                    </a>
                {/if}
                <a class="waves-effect waves-light btn pageBtn" href="{$baseLink}?page={$maxPage}">
                    {$maxPage + 1}
                </a>
            {/if}
        {/if}
    </div>
</div>