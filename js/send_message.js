// send button
document.getElementById("send_button").onclick = send_message;
// press enter
function checkDown(e) {
    if(e.keyCode == 13) {
        send_message();
    }
}

function send_message() {
    var message_content = document.getElementById("dialog").value;
    document.getElementById("dialog").value = "";
    if(message_content.length > 250) {
        alert("What you input is fxxking too long!\nLength must < 250! Idiot!");
        return 0;
    }
    if (message_content !== "") {
        var ajaxRequest4 = new XMLHttpRequest();
        var para4 = "user_ID=" + user_ID + "&message_content=" + message_content +
         "&chatroom_ID=" + chatRoom_ID + "&chat_friend_ID=" + chat_friend_ID;
        // notice that this js will be include in index.php
        // so the path should be started from index.php
        ajaxRequest4.open("POST", "./php/send_message.php", true);
        ajaxRequest4.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest4.send(para4);
        ajaxRequest4.onreadystatechange = function() {
            if (ajaxRequest4.readyState == 4 && (ajaxRequest4.status == 200 || ajaxRequest4.status == 304)) {
                document.getElementById("chat_history").innerHTML = ajaxRequest4.responseText;
                // scroll to bottom
                document.getElementById("chat_history").scrollTop = document.getElementById("chat_history").scrollHeight;
            }
        };
    }
}
