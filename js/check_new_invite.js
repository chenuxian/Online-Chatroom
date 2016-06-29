document.getElementById("invite").style.display = "none";

function toggle_invite() {
    if(document.getElementById("invite").style.display == "none") {
        document.getElementById("invite").style.display = "block";
        show_invite();
    } else {
        document.getElementById("invite").style.display = "none";
    }
    return false;
}

function show_invite() {
    var ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open("POST", "./php/checkNewInvite.php", true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4 && (ajaxRequest.status == 200 || ajaxRequest.status == 304)) {
            document.getElementById("invite_middle").innerHTML = ajaxRequest.responseText;
            if(ajaxRequest.responseText == "Nobody wants to be your friend.....QQ") {
                document.getElementById("invite_heart").style.color = "black";
            } else {
                document.getElementById("invite_heart").style.color = "red";
            }
        }
    };
}

setInterval(show_invite, 1500);