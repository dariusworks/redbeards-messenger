<?php
/**
 * 
 * Details:
 * PHP Messenger.
 * 
 * Modified: 26-Nov-2016
 * Made Date: 25-Nov-2016
 * Author: Hosvir
 * 
 * */
include(dirname(__FILE__) . "/../includes/login_auth.inc.php");

//Delete
if(isset($guid)) {
	QB::update("DELETE FROM contact_requests WHERE request_guid = ? AND user_guid = ?;", 
				array($guid, $_SESSION[USESSION]->user_guid), 
				$mysqli);
}

//Redirect
header('Location: ../existing-requests');
?>
