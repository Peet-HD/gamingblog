<nav id="sidebar">

    <div id="chat">
        {include file='static/chat.tpl'}
    </div>
        {if !isset($hideLogin)}
            {include file='static/login_form.tpl'}
        {/if}
        {include file='static/category_roll.tpl'}
</nav>