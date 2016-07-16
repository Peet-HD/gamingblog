<div id="sidebar" class="black">

    <div id="chat">
        {include file='static/chat.tpl'}
    </div>
        {if !isset($hideLogin)}
            {include file='user/login_form.tpl'}
        {/if}
        {include file='static/category_roll.tpl'}
</div>