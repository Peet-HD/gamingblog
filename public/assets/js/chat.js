var chatLineData = [];

var lastUpdateTime = 0;

$(function()
{
    loadDbEntries(0);
    
    $('#chatInputLine').keydown(function(e)
    {
        if (e.which == 13)
            sendChatLine();
    });
});

function sendChatLine()
{
    $('#chatInputLine').prop('disabled', true);
    
    var text = $('#chatInputLine').val();
    
    // Trim whitespace to check if the string is usable
    //text = text.replace(/(^\s+|\s+$)/g, "");
    
    if (text.length > 0)
    {
        $.ajax({
            url: "/chat/sendentry",
            context: document.body,
            data: {
                'text': text
            }
        }).done(function(id) {

            if (id != -1)
            {
                appendChatTextLine(id, text, true);   
            }

            $('#chatInputLine').val("");

            $('#chatInputLine').prop('disabled', false);

            $('#chatInputLine').focus();
        });
    } else {
        $('#chatInputLine').val("");

        $('#chatInputLine').prop('disabled', false);

        $('#chatInputLine').focus();
    }
}

function appendChatTextLine(id, textVal, addUserName)
{
    console.log("check: " + id);
    if (chatLineData[id] === undefined)
    {
        chatLineData[id] = textVal;
        
        if (addUserName)
            $('#chatHistoryBlock').append("<div class='singleChatLine'>" + userName + ": " + textVal + "</div>");
        else
            $('#chatHistoryBlock').append("<div class='singleChatLine'>" + textVal + "</div>");

        // Auto-Scroll to Bottom
        $('#chatHistoryBlock').animate({
            scrollTop: $('#chatHistoryBlock').prop('scrollHeight')
        }, 200);
        
        console.log('add: ' + id);
    }
    console.log("checkdone");
}

function loadDbEntries(lastUpdateTimestamp)
{
    var date = new Date();
    var curTime = date.getTime();
        
    $.ajax({
        url: "/chat/fetchlastentries",
        context: document.body,
        data:
        {
            'lastUpdate' : lastUpdateTimestamp
        }
        
    }).done(function(res) {
        var arr = $.parseJSON(res);
        
        if (arr.length > 0)
            lastUpdateTime = curTime/1000;
        
        // Add chat-lines to the visible content
        $.each(arr, function(index, val)
        {
            appendChatTextLine(val.id, val.text, false);
        });
        setTimeout(function()
            {
                loadDbEntries(lastUpdateTime);
            }, '1000');
    });
}