<div id="chatHistoryBlock">
    {if !isset($user) || !$user->authenticate()}
        <div class='singleChatLine' style="text-align: center;"><br/><br/><br/><br/><br/><br/>Login to chat<br/><br/><br/><br/><br/><br/></div>
    {/if}
</div>
{if isset($user) && $user->authenticate()}
    <input id="chatInputLine" type="text" placeholder="Hier schreiben zum chatten.."/>
{/if}