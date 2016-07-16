<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {include file='static/header.tpl' jQuery='1' cssSource='blog/overview' jsSource="register"}
        <!-- eventuell zusatz-javascript script-->
    </head>
    <body>
        {include file='static/topMenu.tpl'}
        <div id="main-block" class="container cyan lighten-3">
             <div class="row">
                <div class="col s6 offset-s3">
                    <br/>
                    <h5>&nbsp;&nbsp;Besucher-Account anfordern</h5>
                    <div class="loginform" style="padding: 10px; background-color: black; margin-top: 10px; color: white; border-radius: 8px; margin-top: 20px;">
                        {if isset($errorData) && !empty($errorData)}
                            <table style="padding: 10px; background-color: red; color: white; width: 100%;">
                                {if isset($errorData['missingName'])}
                                <tr id="errorMissingName">
                                    <td><span>The user-name is missing</span></td>
                                </tr>
                                {/if}
                                {if isset($errorData['missingMail'])}
                                <tr id="errorMissingMail">
                                    <td><span>The user-mail is missing</span></td>
                                </tr>
                                {else if isset($errorData['invalidMail'])}
                                <tr id="errorInvalidMail">
                                    <td><span>The user-mail is invalid. Please check.</span></td>
                                </tr>
                                {/if}
                                {if isset($errorData['missingPassword'])}
                                <tr id="errorMissingPassword">
                                    <td><span>The user-password is missing</span></td>
                                </tr>
                                {else if isset($errorData['missingPasswordLength'])}
                                <tr id="errorPasswordLength">
                                    <td><span>The user-password-length is to short (at least 8 characters)</span></td>
                                </tr>
                                {else if isset($errorData['unsafePassword'])}
                                <tr id="errorUnsafePassword">
                                    <td><span>The user-password is unsafe (at least one letter, one number and one special char of the following: "!,@,$,%,&,*,-,_")</span></td>
                                </tr>
                                {/if}
                                {if isset($errorData['userNameExists'])}
                                    <tr id="errorUserNameExists">
                                        <td><span>The given username "{$inputData['name']}" is already registered. Try another.</span></td>
                                    </tr>
                                {/if}
                                {if isset($errorData['userMailExists'])}
                                    <tr id="errorUserMailExists">
                                        <td><span>The given usermail "{$inputData['email']}" is already connected. Try another or contact us.</span></td>
                                    </tr>
                                {/if}
                            </table>
                        {/if}
                        <form action="{$urlHelper->url(['controller' => 'user', 'action' => 'register'])}" method="POST">
                            <input {if isset($inputData) && isset($inputData['name'])}value="{$inputData['name']}"{/if} name="userName" type="text" placeholder="User-Name" required="true" {if isset($errorData) && isset($errorData['missingName'])}style="background-color: red;"{/if}></input><br/><br/>

                            <input {if isset($inputData) && isset($inputData['email'])}value="{$inputData['email']}"{/if} name="email" type="email" placeholder="Email" required="true" {if isset($errorData) && (isset($errorData['missingMail']) || isset($errorData['invalidMail']))}style="background-color: red;"{/if}></input><br/><br/>

                            <input {if isset($inputData) && isset($inputData['password'])}value="{$inputData['password']}"{/if} name="password" type="password" {literal}pattern=".{8,}"{/literal} title="Mindestens 8 Zeichen" placeholder="Password" required="true"
                                   {if isset($errorData) && (isset($errorData['missingPassword']) || isset($errorData['missingPasswordLength']) || isset($errorData['unsafePassword']))}style="background-color: red;"{/if}></input><br/><br/>

                            <button class="btn waves-effect waves-light submitBtn" type="submit" name="action">Registrieren
                                <i class="material-icons tiny right">send</i>
                            </button>
                            <input type="hidden" name="register" value="1"></input>
                            <br>

                        </form>
                    </div>
                </div>
            </div>
        </div>
            {include file='static/sidebar.tpl'}
    </body>
</html>