<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/db_inc.php");

function redirect($page)
{
    header("Location: " . $page);
    die();
}