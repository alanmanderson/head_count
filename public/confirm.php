<?php
require_once("../commons/setup.php");
setup(false,"red_stake_bball");

$id = $_GET["id"];
$user = $_GET["user"];
$response= $_GET["response"];
#$timeStamp = $_GET["timeStamp"];

$query = "SELECT user_id,first,last,email FROM Users WHERE guid='$user'";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$userID = $row['user_id'];
$now = date();
$dayOfWeek = date('w');
# 2 is Tuesday
if ($dayOfWeek==2){
  $day = date('Y-m-d', strtotime('today'));
} else {
  $day = date('Y-m-d', strtotime('next tuesday'));
}

$query = "INSERT INTO Replies( user_id, week, response ) 
          VALUES ( $userID,  '$day',  '$response' ) 
          ON DUPLICATE KEY 
          UPDATE response = VALUES ( response )";
#echo $query;
$result = mysql_query($query) or die(mysql_error());

echo "Your response has been recorded.  If you need to change it later you can go back to the email and click on the correct link.";

mail("alanmanderson@gmail.com","response from $row[email]","$row[first] $row[last] responded $response");

?>