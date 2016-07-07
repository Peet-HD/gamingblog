<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview' jsSource="register"}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block">
            <div class="loginform">
                {if isset($errorData) && !empty($errorData)}
                    <table style="padding: 10px; background-color: red; color: white; width: 100%;">
                        {if isset($errorData['missingName'])}
                        <tr id="errorMissingName">
                            <td>The user-name is missing</td>
                        </tr>
                        {/if}
                        {if isset($errorData['missingMail'])}
                        <tr id="errorMissingMail">
                            <td>The user-mail is missing</td>
                        </tr>
                        {else if isset($errorData['invalidMail'])}
                        <tr id="errorInvalidMail">
                            <td>The user-mail is invalid. Please check.</td>
                        </tr>
                        {/if}
                        {if isset($errorData['missingPassword'])}
                        <tr id="errorMissingPassword">
                            <td>The user-password is missing</td>
                        </tr>
                        {else if isset($errorData['missingPasswordLength'])}
                        <tr id="errorPasswordLength">
                            <td>The user-password-length is to short (at least 8 characters)</td>
                        </tr>
                        {else if isset($errorData['unsafePassword'])}
                        <tr id="errorUnsafePassword">
                            <td>The user-password is unsafe (at least one letter, one number and one special char of the following: "!,@,$,%,&,*,-,_")</td>
                        </tr>
                        {/if}
                        {if isset($errorData['userExists'])}
                            <tr id="errorUserExists">
                                <td>Te given username {$inputData['name']} is already registered. Try another.</td>
                            </tr>
                        {/if}
                    </table>userExists
                {/if}
                <form action="{$urlHelper->url(['controller' => 'user', 'action' => 'register'])}" method="POST">
                    <input {if isset($inputData) && isset($inputData['name'])}value="{$inputData['name']}"{/if} name="userName" type="text" placeholder="User-Name" required="true" {if isset($errorData) && isset($errorData['missingName'])}style="background-color: red;"{/if}></input><br/><br/>
                    
                    <input {if isset($inputData) && isset($inputData['email'])}value="{$inputData['email']}"{/if} name="email" type="email" placeholder="Email" required="true" {if isset($errorData) && (isset($errorData['missingMail']) || isset($errorData['invalidMail']))}style="background-color: red;"{/if}></input><br/><br/>
                    
                    <input {if isset($inputData) && isset($inputData['password'])}value="{$inputData['password']}"{/if} name="password" type="password" {literal}pattern=".{8,}"{/literal} title="Mindestens 8 Zeichen" placeholder="Password" required="true"
                           {if isset($errorData) && (isset($errorData['missingPassword']) || isset($errorData['missingPasswordLength']) || isset($errorData['unsafePassword']))}style="background-color: red;"{/if}></input><br/><br/>

                    <button type="submit">Register</button>
                    <input type="hidden" name="register" value="1"></input>
                    <br>

                </form>
            </div>
        </div>
            {include file='static/sidebar.tpl'}
    </body>
</html>