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
        
        if (chatLineData[id] === undefined)
        {
            chatLineData[id] = text;
            appendChatTextLine(text);
        }
    
        $('#chatInputLine').val("");
        
        $('#chatInputLine').prop('disabled', false);
        
        $('#chatInputLine').focus();
    });
}

function appendChatTextLine(textVal)
{
    $('#chatHistoryBlock').append("<div class='singleChatLine'>" + textVal + "</div>");
    
    // Auto-Scroll to Bottom
    $('#chatHistoryBlock').animate({
        scrollTop: $('#chatHistoryBlock').prop('scrollHeight')
    }, 200);
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
            if (chatLineData[val.id] === undefined) {
                chatLineData[val.id] = val.text;
                
                appendChatTextLine(chatLineData[val.id]);
                console.log('add: ' + val.id);
            } 
   
        });
        setTimeout(function()
            {
                loadDbEntries(lastUpdateTime);
            }, '2000');
    });
}