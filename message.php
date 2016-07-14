<?php 
    session_start();
    $_SESSION["id"] = $_POST["id"];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Page</title>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- font style -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Joti+One' rel='stylesheet' type='text/css'>

    <!-- local css -->
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

    <div id="multiChoose"> 
        <div id="multi_title"><h1>Choose members</h1><hr></div>
        <div id="multi_middle">
        </div>
        <div id="multi_down">
            <hr>
            <button id="cancel_button" type="button" class="btn btn-danger" onclick="toggleChooseMultiMenu()">Cancel</button>  
            <button id="create_button" type="button" class="btn btn-default" onclick="multi_create()">Create</button>
            &nbsp;
        </div>
    </div>

    <div id="history_out">
        <div id="history_title">HISTORY</div>
        <button id="multiChat" type="button" class="btn btn-default" style="height:8%;width:35%;text-align:center;" onclick="toggleChooseMultiMenu()" title="Click this button to establish a new multiple members chatroom">New multi</button>  
        <div id="history"> </div>
    </div>
    
    <div id="chat_out">
        <div id="chat_box">
            <div id="chat_name"> </div>
            <div id="chat_history"> </div>
        </div>
        <div id="send_box">
            <div id="context">
                <textarea id="dialog" style="height:100%;width:100%;" placeholder="Enter something....." onkeyup="checkDown(event)"></textarea>
            </div>
            <div id="sendButton_box">
                <button id="send_button" type="button" class="btn btn-default" style="height:100%;width:100%;" disabled title="Click this button or press enter to send message">Enter</button>    
            </div>
        </div>
    </div>
    
    <div id="friends_out">
        <div id="friends_title">FRIENDS</div>
        <div id="friends"> </div>
    </div>
    
    <?php 
        echo "<script>var user_ID = '".$_SESSION["id"]."';</script>";
        include "./php/friend.php";
     ?>
    
    <script src="./js/send_message.js"></script>
    <script src="./js/show_dialog.js"></script>
    <script src="./js/singleChat.js"></script>
    <script src="./js/friend.js"></script>
    <script src="./js/history.js"></script>
    <script src="./js/multiChat.js"></script>
    <script src="./js/check_new_invite.js"></script>

</body>
</html>