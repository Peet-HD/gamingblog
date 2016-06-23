<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        {*How to include another template in the current template*}
        {include file='includeTemplate.tpl'}
        
        {*How to transfer a variable from the current template to the included template *}
        {include file='includeTemplate.tpl' variableName=$var}
    </head>
    <body>
        <div id="main-block">
            {*How to loop over a data-array*}
            {foreach from=$dataArray item=itemNameInTheLoop}
                Data: {$itemNameInTheLoop.data1}<br>
                Data: {$itemNameInTheLoop.data2}<br>
            {/foreach}
            
            {*How to restrict output to the content of a given variable*}
            {if $variable eq 'showContent'}
                <p> Only visible if the variable has the correct value</p>
            {else}
                <p> Only visible if the variable has "not" the correct value</p>
            {/if}
            
            {*assigns a value to a new variable inside the template*}
            {assign var="name" value="Bob"}
            {*short form*}
            {assign "name" "Bob"}
            {*now the variable can be output*}
            <span>{$name}</span>

            <p>
                {*How to create a redirection-link (can be hard-coded as well, e.g.: /index/next)*}
              <a href="{$this->url(['controller' => 'index', 'action' => 'next'])}">home</a>
            </p>
            
            {*Outputs the variable if available. Otherwise it outputs the given default-text*}
            <span>{$text|default:'Kein Text vorhanden'}</span>
            
            {*Output the text-variable as uppercase*}
            <span>{$text|upper}</span>
            
            {*Truncate the text-variable to 40 characters and sets "..." at the end if it contains more*}
            <span>{$text|truncate:40:'...'}</span>
            
            {*Output the current date formated by the format-string*}
            <span>{$smarty.now|date_format:"%Y/%m/%d"}</span>
            
            {*Output the array-count (element-count)*}
            <span>{$array|@count}</span>
            
            {*Output the text-character-count (length)*}
            <span>{$text|count_characters}</span>
            
            {*Output the text-character-count including whitespace*}
            <span>{$text|count_characters:true}</span>
            
            {*Outputs each word capitalized*}
            <span>{$text|capitalize}</span>
            
            {*|cat appends like strcat another string to the output*}
            <span>{$array|count|cat:' Elemente.'}</span>
        </div>
    </body>
</html>