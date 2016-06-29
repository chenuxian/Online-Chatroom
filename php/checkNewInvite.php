<?php 
    session_start();
    $host="140.116.245.148";
    $db_username="f74026048";  
    $password="john06697";
    $database="f74026048";

    $link = mysql_connect($host,$db_username,$password);
    mysql_select_db($database)or die( "Unable to select database");
    
    $user_ID = $_SESSION['id'];
    $query = "SELECT receive_invite FROM friend WHERE user_ID='$user_ID'";
    $result = mysql_query($query);
    $result2 = mysql_fetch_row($result);
    // result2[0] is newData
    if($result2[0] == "") {
        echo "Nobody wants to be your friend.....QQ";
        exit;
    }
    $each_newInvite = explode(",", $result2[0]);
    $count = count($each_newInvite);
    $return = "";
    for ($i = 0; $i < $count; $i++) {
        $query2 = "SELECT name, email FROM self_info WHERE id='$each_newInvite[$i]'";
        $result3 = mysql_query($query2);
        $result4 = mysql_fetch_row($result3);
        // result4[0] is name, result4[1] is email
        $return = $return."<a target='_blank' style='font-size:25px;text-decoration:none;' href='../self_info/info_search.php?inputEmail=".$result4[1]."'> ".$result4[0]."</a><br>";
    }
    echo $return;
 ?>