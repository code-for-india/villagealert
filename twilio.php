<?php echo '<?' ?>xml version="1.0" encoding="UTF-8"?>
<?php

$twilio_number = '+';
$AccountSid = '';
$AuthToken = '';

require "../../twilioapi/Twilio.php";

file_put_contents('request.txt', json_encode($_REQUEST));

$message = $_REQUEST['Body'];
$caller_number = $_REQUEST['From'];

function send_sms($to, $message, $xml = false)
{
  if($xml)
  {
    $client = new Services_Twilio($AccountSid, $AuthToken);

    $sms = $client->account->sms_messages->create(
      $twilio_number,
      $to, 
      $message
    ); 
  }
  else
  {
?>
<Response>
    <Sms from="<?= $twilio_number ?>" to="<?= $to ?>"><?= $message ?></Sms>
</Response>
<?php    
  }
}

$caller = get_phone($caller_number);
switch($message)
{
  case empty($caller['location']):
    save_number($caller_number);
    save_name($caller_number, $message);
    send_sms($caller_number, 'Where are you?', true);
  break;
  case empty($caller['skill']):
    save_location($caller_number, $message);
    send_sms($caller_number, 'Can you provide able bodied help (yes/no)? If you have have specific skill, text that.', true);
  break;
  case empty($caller['contact'])
    save_skill($caller_number, $message);
    send_sms($caller_number, 'Emergency contact #', true);
  break;
  default:
    save_contact($caller_number, $message);
    send_sms($caller_number, 'Thanks for signing up.', true);
  break;
}
?>