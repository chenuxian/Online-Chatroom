// user_ID, user_name
// friend_name(array), friend_ID(array)

var chatRoom_ID;
var chat_friend_ID;

// show friends
for (var i = 0; i < friend_name.length; i++) {
    // create DIV
    var node = document.createElement("DIV");
    var textnode = document.createTextNode(friend_name[i]);
    node.appendChild(textnode);
    document.getElementById("friends").appendChild(node);
    // set id: friend_(friend_ID)
    var childNode_ID = "friend_" + friend_ID[i];
    // childNodes[0] is itself
    // use appenchild, so it does not has end tag, so index increament by 1
    document.getElementById("friends").childNodes[i + 1].id = childNode_ID;
    // set onclick function, args is friend_ID
    document.getElementById(childNode_ID).setAttribute("onclick", "singleChat(" + friend_ID[i] + ")");
}