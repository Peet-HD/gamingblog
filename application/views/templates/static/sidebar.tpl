<div id="sidebar" class="grey darken-4">
    <div id="chat" class="cyan darken-1">
        <h5 class="center">Besucher-Chat</h5>
        {include file='static/chat.tpl'}
    </div>
        {if !isset($hideLogin)}
            {include file='user/login_form.tpl' sidebar=1}
        {/if}
        {include file='static/category_roll.tpl'}
</div>