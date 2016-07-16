$(function()
{
    $('.submitBtn').click(function()
    {
        var idVal = $(this).val();
        
        var $parentDiv = $(this).parent();
        var $parentForm = $parentDiv.parent();
        var $initialTextElement = $parentForm.children('input[name="htmlInitial"]');
        
        var id = idVal;
        var textVal = $initialTextElement.val();
        
        for (i=0; i < tinyMCE.editors.length; i++){

            if (tinyMCE.editors[i].id == ('htmlText' + id))
            {
                var content = tinyMCE.editors[i].getContent();
                
                if (content == textVal)
                {
                    alert("Keine Änderungen zum Speichern vorhanden");
                    return false;
                }
            }
        }
        
        return true;
    })
});