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
    
    $.ajax({
        url: "/chat/sendentry",
        context: document.body,
        data: {
            'text': text
        }
    }).done(function(id) {
        
        if (id !== -1)
        {
            appendChatTextLine(id, text);   
        }
    
        $('#chatInputLine').val("");
        
        $('#chatInputLine').prop('disabled', false);
        
        $('#chatInputLine').focus();
    });
}

function appendChatTextLine(id, textVal)
{
    console.log("check: " + id);
    if (chatLineData[id] === undefined)
    {
        chatLineData[id] = textVal;
        
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
            appendChatTextLine(val.id, val.text);
        });
        setTimeout(function()
            {
                loadDbEntries(lastUpdateTime);
            }, '5000');
    });
}