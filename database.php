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

function mysqldb_user_login($user, $password)
{
    if ($dbh = mysql_connect("villagealert.org:3400", $user, $password)) {
    } else {
        die("Error logging into database.<br>");
        error_log("MYSQL :: User $user not logged in to MYSQL system because: " . mysql_error() . " < br>");
    }
}

function mysqldb_connect_to_db($db)
{
    if (mysql_select_db($db)) {
    } else {
        die("Error connecting to database .<br > ");
        error_log("MYSQL :: Failed to connect to MYSQl DB $db .<br > ");
    }
}

mysqldb_connect_full();

function save_phone($phone)
{
	mysql_query("INSERT INTO user (phone) VALUES (\"".$phone."\")");
}

function save_name($phone, $name)
{
	mysql_query("UPDATE user SET name = \"".$name."\" WHERE phone = \"".$phone."\"");
}

function save_location($phone, $location)
{
	mysql_query("UPDATE user SET location = \"".$location."\" WHERE phone = \"".$phone."\"");
}

function save_skill($phone, $skill)
{
	mysql_query("UPDATE user SET skill = \"".$skill."\" WHERE phone = \"".$phone."\"");
}

function save_contact($phone, $contact)
{
	mysql_query("UPDATE user SET econtact = \"".$contact."\", lastcheckin = \"".time()."\" WHERE phone = \"".$phone."\"");
}

function save_state($phone, $state, $time = 0)
{

	if($time != 0)
	{
		mysql_query('UPDATE user SET state = "'.$state.'", lastcheckin = "'.$time.'" WHERE phone = "'.$phone.'"');
	}
	else
	{
		mysql_query('UPDATE user SET state = "'.$state.'" WHERE phone = "'.$phone.'"');
	}
}

function get_phone($phone)
{
	// Get the data for the phone number
	$result = mysql_query("SELECT * FROM user WHERE phone = \"".$phone."\" LIMIT 1");

	if(mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_assoc($result))
		{
			return $row;
		}
	}
}

function get_phones($location = '')
{
	if(!empty($location))	
	{
		// Get the data for the phone number
		$result = mysql_query('SELECT * FROM user WHERE reglocation LIKE "%'.$location.'%" OR location LIKE "%'.$location.'%"');
	}
	else
	{
		$result = mysql_query('SELECT * FROM user');
	}

	$return = array();
	if(mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_assoc($result))
		{
			array_push($return,$row);
		}
	}

	return $return;
}
?>