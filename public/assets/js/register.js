$(function()
{
    $userNameInput = $('input[name="userName"]');
    registerInputColorUpdate($userNameInput);
    
    $userMailInput = $('input[name="email"]');
    registerInputColorUpdate($userMailInput);
    
    $passwordInput = $('input[name="password"]');
    registerInputColorUpdate($passwordInput);
});

function registerInputColorUpdate($element)
{
    if ($element)
    {
        $element.keyup(function()
        {
            if ($element.val().length == 0) {
                $element.css('background-color', 'red');
            } else {
                $element.css('background-color', 'transparent');
            }
        });
    }
}