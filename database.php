<?php

$_MYSQL_DEBUG = "Yes";
$_MYSQL_USERNAME = "villagealert";
$_MYSQL_PASSWORD = "villagealert1";
$_MYSQL_DATABASE = "villagealert";

function mysqldb_connect_full()
{
    global $_MYSQL_USERNAME, $_MYSQL_PASSWORD, $_MYSQL_DATABASE;
    mysqldb_user_login($_MYSQL_USERNAME, $_MYSQL_PASSWORD);
    mysqldb_connect_to_db($_MYSQL_DATABASE);
}

mysqldb_connect_full();

function save_phone($phone)
{

}

function save_name($phone, $name)
{


}

function save_location($phone, $name)
{

}

function save_skill($phone, $skill)
{


}

function save_contact($phone, $contact)
{

}

function save_state($phone, $state, $time = 0)
{

	if($time != 0)
	{
		// update last_modified and state
	}
	else
	{
		// update just the state
	}
}

function get_phone($phone)
{
	// Get the data for the phone number

	return array(
		'name' => '',
		'location' => '',
		'skill' => '',
		'contact' => '',
		'lastupdate' => time(),
		'state' => 'No Response'
	);
}

function get_phones()
{
	return array(array('phone' => '6502674831'));
}
?>