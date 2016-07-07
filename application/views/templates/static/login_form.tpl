{if $user->authenticate()}
    <div style="padding: 10px; background-color: rebeccapurple; margin-top: 10px; color: white">
        <span>Logged in as "{$user->getUsername()}"</span>  
        <a href="{$urlHelper->url(['controller' => 'user', 'action' => 'logout'])}" style="float: right; color: white;">Logout</a>
    </div>
{else}
    {if isset($loginErrorData) && !empty($loginErrorData)}
        <table style="padding: 10px; background-color: red; color: white; width: 100%;">
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
    {/if}
    <div class="loginform" style="background-color: rebeccapurple; padding: 10px; display: inline-block;">
        <form action="{$urlHelper->url(['controller' => 'user', 'action' => 'login'])}" method="Post">
            <input {if isset($loginUserData)}value="{$loginUserData['login']}" {/if}type="text" name="userName" placeholder="User-Name/-Mail" required="true"></input>
            <input type="password" name="password" placeholder="Password" required="true"></input>
            <button type="submit">Login</button>
            <br>

        </form>
      <a href="{$urlHelper->url(['controller' => 'user', 'action' => 'register'])}">Registrieren</a>
      <a href="{$urlHelper->url(['controller' => 'user', 'action' => 'recoverpw'])}">Passwort vergessen?</a>
    </div>
{/if}