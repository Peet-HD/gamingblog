var chatLineData = [];

var lastId = -1;

$(function()
{
    if ((userName !== undefined) && (userName !== null))
    {
        loadDbEntries();
    }
    
    $('#chatInputLine').keydown(function(e)
    {
        if (e.which == 13)
            sendChatLine();
    });
    
    $('.chatSendBtn').click(function()
    {
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
        }).done(function(res) {

            if (res == -1)
            {
                redirectToBaseSite();
            } else {
                appendChatTextLine(res, text, userName, isAdmin);   

                $('#chatInputLine').val("");

                $('#chatInputLine').prop('disabled', false);

                $('#chatInputLine').focus();
            }
        });
    } else {
        $('#chatInputLine').val("");

        $('#chatInputLine').prop('disabled', false);

        $('#chatInputLine').focus();
    }
}

function appendChatTextLine(id, textVal, authorName, isAdminMsg)
{
    if (chatLineData[id] === undefined)
    {
        chatLineData[id] = textVal;
        
        var textMsgHtml = "<div class='singleChatLine'>";
        
        textMsgHtml += "<span ";
        
        if (isAdminMsg == '1')
        {
            textMsgHtml += 'style="color:yellow"'
        }
        
        textMsgHtml += ">[" + authorName + "]: </span>" + textVal;
        
        textMsgHtml += "</div>";
        
        $('#chatHistoryBlock').append(textMsgHtml);

        // Auto-Scroll to Bottom
        $('#chatHistoryBlock').animate({
            scrollTop: $('#chatHistoryBlock').prop('scrollHeight')
        }, 0);
    }
}

function loadDbEntries()
{
    $.ajax({
        url: "/chat/fetchlastentries",
        context: document.body,
        data:
        {
            'lastNum' : lastId
        }
        
    }).done(function(res) {
        if (res == -1)
        {
            redirectToBaseSite();
        } else {
            var arr = $.parseJSON(res);

            // Add chat-lines to the visible content
            $.each(arr, function(index, val)
            {
                appendChatTextLine(val.id, val.text, val.author, val.adminEntry);

                lastId = val.id;
            });

            setTimeout(function()
                {
                    loadDbEntries();
                }, '1500');
        }
    });
}

function redirectToBaseSite()
{
    window.location = "http://www.gamingblog.de";
}