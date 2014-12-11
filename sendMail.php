<?php
$DEBUG=false;
//$DEBUG=true;
if ($DEBUG || isset($_GET['debug'])){
  ini_set('display_errors', 'On');
  error_reporting(E_ALL);
  $where = " AND user_id<9";
}

date_default_timezone_set("America/Los_Angeles");
$pw=$_GET["pw"];
if ($pw=="1e5d98h8ki4aslrpg"){
  require_once("../commons/setup.php");
  setup(false,"red_stake_bball");
  $action=$_GET["action"];
  if (date('w')==2){
    $nextTuesday = date('Y-m-d',strtotime('today'));
    $normalDate = date('m/d/Y', strtotime('today'));
  } else {
    $nextTuesday = date('Y-m-d', strtotime('next tuesday'));
    $normalDate = date('m/d/Y', strtotime('next tuesday'));
  }
  if ($action=="first"){
    $result = mysql_query("SELECT * FROM Users WHERE Active=1$where") or die(mysql_error());
    while($row=mysql_fetch_assoc($result)){
      var_dump($row);
      $to = $row["email"];
      $subject = "Tuesday night basketball (Please confirm below)";
      $id = $row["guid"];
      $timeStamp = date();
      $message = "<div style=\"float:left;\">Are you playing basketball this Tuesday ($normalDate) at 9pm at the LDS church in Foster City?  Please respond: </div>";
      $button = makeButton("Yes");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=1>$button</a> ";
      $button = makeButton("Maybe");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=2>$button</a> ";
      $button = makeButton("No");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=0>$button</a>";
      addUnsubscribe($message, $id);
      sendMessage($to, $subject, $message);
      echo "</br> $row[first] $row[last] $row[email]";
    }
  } else if ($action=="remind"){
    echo $nextTuesday.$normalDate;
    $query = "SELECT * FROM `Users` WHERE user_id NOT IN (SELECT user_id FROM Replies WHERE week='$nextTuesday') AND active=1$where";
    $result = mysql_query($query) or die(mysql_error());
    while ($row=mysql_fetch_assoc($result)){
      echo "</br>";
      #var_dump($row);
    	$to = $row["email"];
    	$subject = "REMINDER: Tuesday night basketball (Please confirm below)";
    	$id = $row["guid"];
    	$timeStamp = date();
	$message = "<div style=\"float:left;\">You still haven't responded for basketball this evening at 9pm at the LDS church in Foster City.  Please click below to confirm. </div>";
	$button = makeButton("Yes");
    	$message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=1>$button</a> ";
	$button = makeButton("Maybe");
    	$message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=2>$button</a> ";
	$button = makeButton("No");
    	$message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=0>$button</a>";
	addUnsubscribe($message, $id);
    	sendMessage($to, $subject, $message);
        echo "</br> $row[first] $row[last] $row[email]";
    }
  } else if ($action=="report"){
	#$subquery = "SELECT response,count(user_id) as num FROM `Replies` WHERE week='2013-10-08' GROUP BY response ORDER BY response";
	#$result = mysql_query($subquery);
	$subject = "Tuesday night basketball Attendance Report";
	$message = "Tonight we are expecting the following people:</br>";
	#$responses = Array(0,1,2);
	$yeses = Array();
	$nos = Array();
	$maybes=Array();
	$query = "SELECT Users.user_id, response, first, last, email FROM Replies INNER JOIN Users ON Replies.user_id=Users.user_id WHERE week='$nextTuesday'";
	$result = mysql_query($query) or die(mysql_error());
	while($row=mysql_fetch_assoc($result)){
		switch ($row['response']){
			case 0:
				$nos[] = "$row[first] $row[last]";
				break;
			case 1:
				$yeses[] = "$row[first] $row[last]";
				break;
			case 2:
				$maybes[] = "$row[first] $row[last]";
		}
	}
	$yesCount = count($yeses);
	$noCount = count($nos);
	$maybeCount = count($maybes);
	$message .= "<table style=\"border:1px solid black\"><tr><th>Yes ($yesCount)</th>";
	$message .= "<th>Maybe ($maybeCount)</th><th>No ($noCount)</th></tr>";
	$longestArray = max($yesCount,$noCount, $maybeCount);
	for($counter=0; $counter<$longestArray; $counter++){
		$message .= "<tr><td>";
		if ($counter < count($yeses)){
			$message .= $yeses[$counter];
		}
		$message .= "</td><td>";
		if ($counter < count($maybes)){
			$message .= $maybes[$counter];
		}
		$message .= "</td><td>";
		if ($counter < count($nos)){
			$message .= $nos[$counter];
		}
		$message .= "</td></tr>";
	}
	$message .= "</table>";
	$message .= "<pre></pre>";
        #$message = "<table><tr><th>No<th>Yes<th>Maybe<th>Unknown</tr>";
	#$message .= "<tr>";
	#$replyCount = mysql_num_rows($result);
	#$responses = Array(0,1,2);
	#$replyCount = 0;
	#foreach($responses as $response){
	#    $query = "SELECT count(user_id) as num FROM `Replies` WHERE week='$nextTuesday' AND response='".$response."'";
	#	$result = mysql_query($query);
	#	$row = mysql_fetch_assoc($result);
	#	switch($response){
	#		case 1:
	#			$message .= "Yes: $row[num] </br>";
	#			break;
	#		case 2:
	#			$message .= "Maybe: $row[num] </br>";
	#			break;
	#		case 0:
	#			$message .= "No: $row[num] </br>";
	#			break;
	#	}
	#	$replyCount += intval($row["num"]);
	#}
	$query = "SELECT * FROM Users WHERE Active=1$where";
	$result = mysql_query($query);
	$activeUserCount = mysql_num_rows($result);
	$replyCount = $yesCount + $maybeCount + $noCount;
        print "</br>Count: $activeUserCount  $replyCount</br>";
	
	#$message .= "No Response: ".($activeUserCount-$replyCount);
	while($row=mysql_fetch_assoc($result)){
	  #var_dump($row);
		$to = $row["email"];
		sendMessage($to,$subject,$message);
	}
  } else if ($action=="cancelled"){
    $result = mysql_query("SELECT * FROM Users WHERE Active=1$where") or die(mysql_error());
    while($row=mysql_fetch_assoc($result)){
      var_dump($row);
      $to = $row["email"];
      $subject = "CANCELLED -- Tuesday night basketball";
      $id = $row["guid"];
      $timeStamp = date();
      $message = "<div style=\"float:left;\">Basketball is CANCELLED this week.  There will be no basketball on Tuesday ($normalDate) at 9pm at the LDS church in Foster City.</div>";
      addUnsubscribe($message, $id);
      sendMessage($to, $subject, $message);
      echo "</br> $row[first] $row[last] $row[email]";
    }
  } else if ($action=="custom") {
    $result = mysql_query("SELECT * FROM Users WHERE Active=1$where") or die(mysql_error());
    while($row=mysql_fetch_assoc($result)){
      var_dump($row);
      $to = $row["email"];
      $subject = "BASKETBALL IS ON -- Tuesday night basketball -- UPDATE";
      $id = $row["guid"];
      $timeStamp = date();
      $message = "<div style=\"float:left;\">It was previously announced that basketball was cancelled this week.  Things have changed and we will in fact have basketball tonight ($normalDate) at 9pm at the LDS church in Foster City. Please confirm below.</div>";
      $button = makeButton("Yes");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=1>$button</a> ";
      $button = makeButton("Maybe");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=2>$button</a> ";
      $button = makeButton("No");
      $message .= "<a href=http://alanmanderson.com/cs2bball/confirm.php?user=$id&timeStamp=$timeStamp&response=0>$button</a>";
      addUnsubscribe($message, $id);
      sendMessage($to, $subject, $message);
      echo "</br> $row[first] $row[last] $row[email]";
    }
  }else {
    echo "Invalid Action";
  }
} else{
  echo "pw not set";
}

function addHtmlInfo(&$message){
  $html = "<html><head><style>
html {
    font-family: Verdana, Geneva, sans-serif;
}

.button {
    width: 150px;
    border-radius:15px;
    text-align: center;
    vertical-align: center;
    font-weight: bold;
    padding: 10px;
    margin: 10px;
    float: left;
    font-weight:800;
    font-size: 200%;
}

.yes {
    background-color: #094400;
    color: #CCFFCC;
}

.no {
    background-color: #770000;
    color: #FCC;
}

.maybe {
    background-color: #000266;
    color: #ACF;
}
</style>
</head><body>
";
  
  $footer = "</body></html>";
  $message = $html.$message.$footer;
}

function addUnsubscribe(&$message, $guid){
  $text = "<p style=\"clear:both;\"><a href=\"http://alanmanderson.com/cs2bball/unsubscribe.php?id=$guid\">Unsubscribe</a>";
  $message .= $text;
}

function sendMessage($to, $subject, $message){
  echo "</br>$message";
  #$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
  #$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
  $headers = "Reply-To: alanmanderson@gmail.com\r\n";
  $headers = "From: alanmanderson@gmail.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  addHtmlInfo($message);
  $success = mail($to, $subject, $message, $headers);
  if ($success) echo "Email Sent";
  else echo "email failed";
}

function makeButton($text){
    $button = "<div style=\"
    width: 150px;
    border-radius:15px;
    text-align: center;
    vertical-align: center;
    font-weight: bold;
    padding: 10px;
    margin: 10px;
    float: left;
    font-weight:800;
    font-size: 200%;
    ";
        if ($text=="Yes"){
        $button.=" background-color: #094400;
                   color: #CCFFCC;
                   clear:both;";
    } else if ($text == "No"){
        $button.=" background-color: #770000;
	       color: #FCC;";       
    } else if ($text == "Maybe"){
        $button.=" background-color: #000266;
    color: #ACF;";
      }
    $button.="\">$text</div>";
    return $button;
}
?>