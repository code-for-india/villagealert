<?php echo '<?' ?>xml version="1.0" encoding="UTF-8"?>
<?php

include_once('database.php');
require "../../twilioapi/Twilio.php";

define('TWILIO_NUMBER', '+');
define('TWILIO_SID', '');
define('AUTH_TOKEN', '');



//file_put_contents('request.txt', json_encode($_REQUEST));

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

if(substr($message, 0, 5) == 'check')
{
  list($command, $phone_number) = preg_split('/ /', $message);

  //$caller = get_phone($phone_number);

  $user = array(
    'name' => 'Johnny',
    'location' => '',
    'skill' => '',
    'econtact' => '',
    'last_modified' => time()
  );

  if(!empty($user))
  {
    send_sms($caller_number, $user['name'].' last checked in at '.date('m/d/Y H:i', $user['last_modified']), true);
  }
  else
  {
     send_sms($caller_number, 'Unable to find phone number in registry.', true);   
  }
}
exit;
$caller = get_phone($caller_number);
switch(true)
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
  case empty($caller['econtact']):
    save_skill($caller_number, $message);
    send_sms($caller_number, 'Emergency contact #', true);
  break;
  default:
    save_contact($caller_number, $message);
    send_sms($caller_number, 'Thanks for signing up.', true);
  break;
}
?>