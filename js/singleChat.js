// click the friend, then do single chat
function singleChat(temp_chat_friend_ID) {
    chat_friend_ID = temp_chat_friend_ID;
    var ajaxRequest = new XMLHttpRequest();
    var para = "user_ID=" + user_ID + "&friend_ID=" + chat_friend_ID;
    // notice that this js will be include in index.php
    // so the path should be started from index.php
    ajaxRequest.open("POST", "./php/initSingleChat.php", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send(para);
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4 && (ajaxRequest.status == 200 || ajaxRequest.status == 304)) {
            chatRoom_ID = ajaxRequest.responseText;
            getChatMemberName();
            getChatContent();
            // enable button
            document.getElementById("send_button").disabled = false;
        }
    };
}