<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if (!empty($_POST['email'])) {
    $user_email=$_POST['email'];
}else{
    $user_email="";
}

if (!empty($_POST['source'])) {
    $source=$_POST['source'];
}else{
    $source='';
}

$body_template = file_get_contents('../templates/setup1.html');
include '../mandrill.php';


$twitter_search = str_replace('http://twitter.com/','%20OR%20from%3A',$source);

$to = "gary@ozcontent.com";
//$to = "gary@ozcontent.com, daniel@ozcontent.com, matt@ozcontent.com";

$message = $user_email . ' want to set this list up.<br><br>'. $source . '<br><br>https://twitter.com/search?q=from%3A' . $twitter_search;
$subject = 'New Oz Source List Setup';
$headers = "From: " . strip_tags("gary@ozcontent.com") . "\r\n";
$headers .= "Reply-To: ". strip_tags("gary@ozcontent.com") . "\r\n";
// $headers .= "CC: susan@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

echo $source;
// mail($to, $subject, $message, $headers);

?>