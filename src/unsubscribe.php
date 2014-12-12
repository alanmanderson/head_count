<?php
require_once("../commons/setup.php");
setup(false,"red_stake_bball");

$id = htmlentities($_GET["id"]);

$query = "UPDATE Users SET active = NOT active WHERE guid='$id'";
$result = mysql_query($query) or die(mysql_error());

$query = "SELECT user_id,first,last,email,active,guid FROM Users WHERE guid='$id'";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($result);
if ($row['active']==1){
  $subscribed=true;
  echo "<p>You are now subscribed to the mailing list.  If you wish to unsubscribe return to this url and you will be unsubscribed.";
} else {
  $subscribed=false;
  echo "<p>You have been unsubscribed from the mailing list.  If you wish to resubscribe return to this url and you will be resubscribed.";
}
$subscribed = $subscribed ? "subscribed" : "unsubscribed";
mail("alanmanderson@gmail.com","BBall Unsubscribe Response from $row[first] $row[last]","$row[first] $row[last] is now $subscribed");