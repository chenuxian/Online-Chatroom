// get friend's name and show on chat_name(dialog)
function getChatMemberName() {
    var ajaxRequest2 = new XMLHttpRequest();
    var para2 = "friend_ID=" + chat_friend_ID;
    // notice that this js will be include in index.php
    // so the path should be started from index.php
    ajaxRequest2.open("POST", "./php/getChatMemberName.php", true);
    ajaxRequest2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest2.send(para2);
    ajaxRequest2.onreadystatechange = function() {
        if (ajaxRequest2.readyState == 4 && (ajaxRequest2.status == 200 || ajaxRequest2.status == 304)) {
            var receiver_name = ajaxRequest2.responseText;
            document.getElementById("chat_name").innerHTML = "&nbsp" + receiver_name;
        }
    };
}

// get chat dialog content
function getChatContent(update) {
    var ajaxRequest3 = new XMLHttpRequest();
    var para3 = "user_ID=" + user_ID + "&chatroom_ID=" + chatRoom_ID;
    // notice that this js will be include in index.php
    // so the path should be started from index.php
    ajaxRequest3.open("POST", "./php/getChatContent.php", true);
    ajaxRequest3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest3.send(para3);
    ajaxRequest3.onreadystatechange = function() {
        if (ajaxRequest3.readyState == 4 && (ajaxRequest3.status == 200 || ajaxRequest3.status == 304)) {
            // document.getElementById("dialog").value = "";
            document.getElementById("chat_history").innerHTML = ajaxRequest3.responseText;
            // scroll to bottom
            if(update !== "update") {
                document.getElementById("chat_history").scrollTop = document.getElementById("chat_history").scrollHeight;
            }
        }
    };
}