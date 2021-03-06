<?php echo '<?' ?>xml version="1.0" encoding="UTF-8"?>
<?php

include_once('database.php');
include_once('shared.php');

$caller = get_phone($caller_number);
switch(true)
{
  case stripos($message, 'disaster') !== false:
      $phones = get_phones();

      foreach($phones as $phone)
      {
        send_sms($phone['phone'], 'Are you okay?', false);  
        save_state($phone['phone'], 'No Response');          
      }
  break;
  case stripos($message, 'rescue') !== false:
    send_sms($caller_number, 'Authorities have been notified. Where are you?', true);   
  break;
  case $caller['state'] == 'No Response':
    save_state($caller_number, $message);
  break;
  case stripos($message, 'check') !== false:
    list($command, $phone_number) = preg_split('/ /', $message);

    $user = get_phone("+1".$phone_number);

    if(!empty($user))
    {
      send_sms($caller_number, $user['name'].' last checked in from '.$user['location'].' at '.date('m/d/Y h:i a', $user['lastcheckin']), true);
    }
    else
    {
       send_sms($caller_number, 'Unable to find phone number in registry.', true);   
    }
  break;
  case empty($caller['name']):
    save_phone($caller_number);
    save_name($caller_number, $message);
    send_sms($caller_number, 'Where are you?', false);
  break;
  case empty($caller['location']) && !empty($caller['name']):
    save_location($caller_number, $message);
    send_sms($caller_number, 'Can you provide able bodied help (yes/no)? If you have have specific skill, text that.', true);
  break;
  case empty($caller['skill']) && !empty($caller['location']):
    save_skill($caller_number, $message);
    send_sms($caller_number, 'Emergency contact #', true);
  break;
  default:
    save_contact($caller_number, $message);
    send_sms($caller_number, 'Thanks for signing up.', true);
  break;
}
?>