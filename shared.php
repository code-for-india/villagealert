<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/db_inc.php");
include_once('credentials.php');
require "Twilio/Twilio.php";

$message = $_REQUEST['Body'];
$caller_number = $_REQUEST['From'];

function send_sms($to, $message, $xml = true)
{
  if(!$xml)
  {
    $client = new Services_Twilio(TWILIO_SID, AUTH_TOKEN);

    $sms = $client->account->sms_messages->create(
      TWILIO_NUMBER,
      $to, 
      $message
    ); 
  }
  else
  {
?>
<Response>
    <Sms from="<?= TWILIO_NUMBER ?>" to="<?= $to ?>"><?= $message ?></Sms>
</Response>
<?php    
  }
}

function redirect($page)
{
    header("Location: " . $page);
    die();
}
?>