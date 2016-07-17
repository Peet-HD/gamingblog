{if $user->authenticate()}
    <div style="padding: 10px; background-color: black; margin-top: 10px; color: white; border-radius: 8px;">
        <span>Eingeloggt als: "{$user->getUsername()}"</span>  
        <a href="{$urlHelper->url(['controller' => 'user', 'action' => 'logout'])}" style="float: right; color: white;">Logout</a>
    </div>
{else}
    <br/><br/>
    {if isset($adminLogin)}
        <h5>&nbsp;&nbsp;Admin-Login</h5>
    {else}
        <h5>&nbsp;&nbsp;User-Login</h5>
    {/if}
    {if isset($sidebar)}
        <hr />
    {else}
        <br/>
    {/if}
    
    {if isset($loginErrorData) && !empty($loginErrorData)}
        <table style="padding: 10px; background-color: red; color: white; width: 100%; border-radius: 8px;">
            {if isset($loginErrorData['missingLogin'])}
            <tr id="errorMissingLogin">
                <td>The Login is missing</td>
            </tr>
            {/if}
            {if isset($loginErrorData['missingPassword'])}
            <tr id="errorMissingPassword">
                <td>The Password is missing</td>
            </tr>
            {/if}
            {if isset($loginErrorData['invalidLogin'])}
            <tr id="errorLogin">
                <td>Invalid Login !!!</td>
            </tr>
            {/if}
        </table>
        <br/>
    {/if}
    <div class="loginform violet" style="background-color: black; padding: 10px; border-radius: 8px;">
        {if isset($adminLogin)}
        <form action="{$urlHelper->url(['controller' => 'admin', 'action' => 'login'])}" method="Post">
            <input {if isset($loginUserData)}value="{$loginUserData['login']}" {/if}type="text" name="userName" placeholder="Admin-Name" required="true"></input>
        {else}
        <form action="{$urlHelper->url(['controller' => 'user', 'action' => 'login'])}" method="Post">
            <input {if isset($loginUserData)}value="{$loginUserData['login']}" {/if}type="text" name="userName" placeholder="User-Name" required="true"></input>
        {/if}
            <input type="password" name="password" placeholder="Password" required="true"></input>
            <input type="hidden" name="submit" value="1"></input>
            <button class="btn waves-effect waves-light submitBtn" type="submit" name="action">Login
                <i class="material-icons tiny right">vpn_key</i>
            </button>
            <br>

        </form>
        {if !isset($adminLogin)}
            <br>
             <div class="row">
                <div class="col s6">
                    <a class="left" href="{$urlHelper->url(['controller' => 'user', 'action' => 'register'])}">Registrieren</a>
                </div>
             </div>
            
        {/if}
    </div>
{/if}