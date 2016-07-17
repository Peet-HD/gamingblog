<div id="chatHistoryBlock" class="{if $user->authenticate()}active{/if}">
    {if !isset($user) || !$user->authenticate()}
        <div class='singleChatLine' style="text-align: center;">
            <br/>
            { Login to chat }
            <br/><br/></div>
    {/if}
</div>
{if isset($user) && $user->authenticate()}
    <div class="row">
        <div class="col s11">
            <input id="chatInputLine" type="text" placeholder="Hier schreiben zum chatten.."/>
        </div>
        <div class="col s1">
            <i class="material-icons tiny right chatSendBtn">send</i>
        </div>
    </div>
{/if}