<?php
/**
 * 
 * Details:
 * PHP Messenger.
 * 
 * Modified: 03-Dec-2016
 * Made Date: 27-Nov-2016
 * Author: Hosvir
 * 
 * */
include(dirname(__FILE__) . "/../includes/loginauth.php");

//Delete messages
if (isset($guid)) {
    if (QueryBuilder::update(
        "DELETE FROM messages WHERE conversation_guid = ? AND (user1_guid = ? OR user2_guid = ?);",
        array(
            $guid,
            $_SESSION[USESSION]->user_guid,
            $_SESSION[USESSION]->user_guid
        )
    )) {

        //Delete conversations
        QueryBuilder::update(
            "DELETE FROM conversations WHERE conversation_guid = ? AND (user_guid = ? OR contact_guid = ?);",
            array(
                $guid,
                $_SESSION[USESSION]->user_guid,
                $_SESSION[USESSION]->user_guid
            )
        );
    }
}

//Redirect
header('Location: ../conversations');
?>
