// user_ID, user_name
// friend_name(array), friend_ID(array)
// chatRoom_ID, chat_friend_ID; (may be empty, if not choose chatroom)

var if_newData = [];

function updateHistory() {
    var update_ajaxRequest = new XMLHttpRequest();
    var update_para = "user_ID=" + user_ID + "&now_chatroom_ID=" + chatRoom_ID;
    update_ajaxRequest.open("POST", "./php/history.php", true);
    update_ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    update_ajaxRequest.send(update_para);
    update_ajaxRequest.onreadystatechange = function() {
        if (update_ajaxRequest.readyState == 4 && (update_ajaxRequest.status == 200 || update_ajaxRequest.status == 304)) {
            if(document.getElementById("history").innerHTML !== update_ajaxRequest.responseText) {
                document.getElementById("history").innerHTML = update_ajaxRequest.responseText;
                getChatContent(true);
            }
        }
    };
}

// setInterval
setInterval(function() {
    updateHistory();
}, 1000);

function showHistory(chatroom_ID, temp_chat_friend_ID) {
    chatRoom_ID = chatroom_ID;
    getChatContent();
    chat_friend_ID = temp_chat_friend_ID;
    // alert(chat_friend_ID);
    getChatMemberName();
    document.getElementById("send_button").disabled = false;

    // set newData to 0
    var update_ajaxRequest3 = new XMLHttpRequest();
    var update_para3 = "user_ID=" + user_ID + "&chatroom_ID=" + chatroom_ID;
    update_ajaxRequest3.open("POST", "./php/clickHistory.php", true);
    update_ajaxRequest3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    update_ajaxRequest3.send(update_para3);
}