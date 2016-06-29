// user_ID, user_name
// friend_name(array), friend_ID(array)
// chatRoom_ID, chat_friend_ID; (may be empty, if not choose chatroom)

var toggle = 0;

function toggleChooseMultiMenu() {
    toggle ^= 1;
    if (toggle == 1) {
        document.getElementById("multiChoose").style.display = "block";

        // remove original node
        document.getElementById("multi_middle").innerHTML = "";

        // create checkbox
        for (var i = 0; i < friend_name.length; i++) {
            // alert(friend_ID[i] + friend_name[i]);
            var checkbox = document.createElement('input');
            checkbox.type = "checkbox";
            checkbox.name = friend_ID[i];
            checkbox.value = friend_ID[i];
            checkbox.id = "checkbox_" + friend_ID[i];

            var label = document.createElement('label');
            label.appendChild(document.createTextNode(friend_name[i]));

            document.getElementById("multi_middle").appendChild(checkbox);
            var textnode = document.createTextNode(" ");
            document.getElementById("multi_middle").appendChild(textnode);
            document.getElementById("multi_middle").appendChild(label);
            document.getElementById("multi_middle").appendChild(document.createElement("br"));
        }

    } else {
        document.getElementById("multiChoose").style.display = "none";
    }
}

function multi_create() {
    var check_box = document.getElementsByTagName("INPUT");
    var multi_friend_ID = [];

    for (var i = 0; i < check_box.length; i++) {
        if (check_box[i].checked) {
            multi_friend_ID.push(check_box[i].value);
            check_box[i].checked = false;
        }
    }

    if (multi_friend_ID.length < 2) {
        alert("WTF? This is MULTIPLE CHATROOM! Chooese at least 2 members.")
    } else {
        var ajaxRequest = new XMLHttpRequest();
        var para = "user_ID=" + user_ID + "&multi_friend_ID=" + multi_friend_ID;
        chat_friend_ID = multi_friend_ID;
        // notice that this js will be include in index.php
        // so the path should be started from index.php
        ajaxRequest.open("POST", "./php/initMultiChat.php", true);
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
        toggleChooseMultiMenu();
    }
}
