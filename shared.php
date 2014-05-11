<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/db_inc.php");
include_once('credentials.php');
require "Twilio/Twilio.php";

$message = $_REQUEST['Body'];
$caller_number = $_REQUEST['From'];

function send_sms($to, $message, $xml = true)
{
    if (!$xml) {
        $client = new Services_Twilio(TWILIO_SID, AUTH_TOKEN);

        $sms = $client->account->sms_messages->create(
            TWILIO_NUMBER,
            $to,
            $message
        );
    } else {
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

function print_r_pre($r)
{
    echo "<pre>";
    print_r($r);
    echo "</pre>";
}

function htmlsafe($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}

function send_warning($message, $location)
{
    $phones = get_phones($location);

    foreach ($phones as $phone) {
        if (strstr($phone, "510") || strstr($phone, "650")) {
            send_sms($phone['phone'], $message, false);
            save_state($phone['phone'], 'No Response');
        }
    }
}

?>
