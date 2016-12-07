<?php
/**
 * 
 * Details:
 * PHP Messenger.
 * 
 * Modified: 07-Dec-2016
 * Made Date: 06-Dec-2016
 * Author: Hosvir
 * 
 * */
namespace Messenger\Models;

use Messenger\Core\Functions;
use Messenger\Core\Database;

class Conversation
{
    public $conversation_guid = null;
    public $contact_guid = null;
    public $username = null;
    public $alias = null;
    public $made_date = null;

    public function __construct($conversation_guid = null, $contact_guid = null, $username = null, $alias = null, $made_date = null)
    {
        $this->conversation_guid = $conversation_guid;
        $this->contact_guid = $contact_guid;
        $this->username = $username;
        $this->alias = $alias;
        $this->made_date = $made_date;
    }

    public function getMadeDate()
    {
        return Functions::convertTime($this->made_date, true);
    }

    /**
     * 
     * Get conversations.
     * 
     * Details:
     * Get all conversations for the current session user.
     * 
     * @param: $made_date   - Made date grater than this
     * 
     * @returns: Conversations array
     * 
     * */
    public function getAll($made_date = null)
    {
        //Get conversations
        if ($made_date == null) {
            $conversations = Database::select(
                "SELECT conversation_guid, contact_guid,
                    (SELECT username FROM users WHERE user_guid = contact_guid) AS username,
                    (SELECT contact_alias FROM contacts WHERE contact_guid = conversations.contact_guid AND user_guid = conversations.user_guid) AS contact_alias,
                    (SELECT made_date FROM messages WHERE conversation_guid = conversations.conversation_guid AND (user1_guid = ? OR user2_guid = ?) ORDER BY made_date DESC LIMIT 1) AS made_date
                    FROM conversations WHERE user_guid = ?
                    ORDER BY made_date DESC;",
                [
                    $_SESSION[USESSION]->user_guid,
                    $_SESSION[USESSION]->user_guid,
                    $_SESSION[USESSION]->user_guid
                ]
            );
        } else {
            $conversations = Database::select(
                "SELECT conversation_guid, contact_guid,
                    (SELECT username FROM users WHERE user_guid = contact_guid) AS username,
                    (SELECT contact_alias FROM contacts WHERE contact_guid = conversations.contact_guid AND user_guid = conversations.user_guid) AS contact_alias,
                    (SELECT made_date FROM messages WHERE conversation_guid = conversations.conversation_guid AND (user1_guid = ? OR user2_guid = ?) ORDER BY made_date DESC LIMIT 1) AS made_date
                    FROM conversations
                    WHERE user_guid = ?
                    AND made_date > ?
                    ORDER BY made_date DESC;",
                [
                    $_SESSION[USESSION]->user_guid,
                    $_SESSION[USESSION]->user_guid,
                    $_SESSION[USESSION]->user_guid,
                    $made_date
                ]
            );
        }

        //Return conversation array
        return $conversations;
    }

    /**
     *
     * Get new conversation.
     *
     * */
    public function getNew($guid)
    {
        return Database::select(
            "SELECT contact_guid, made_date, 
                (SELECT username FROM users WHERE user_guid = contact_guid) AS username 
                FROM contacts 
                WHERE contact_guid = ? 
                AND user_guid = ?;",
            [
                $guid,
                $_SESSION[USESSION]->user_guid
            ]
        );
    }

    /**
     *
     * Delete conversation by guid.
     * 
     * */
    public function delete($guid)
    {
        //Delete messages
        Database::update(
            "DELETE FROM messages WHERE conversation_guid = ? AND (user1_guid = ? OR user2_guid = ?);",
            [
                $guid,
                $_SESSION[USESSION]->user_guid,
                $_SESSION[USESSION]->user_guid
            ]
        );

        //Delete conversations
        return Database::update(
            "DELETE FROM conversations WHERE conversation_guid = ? AND (user_guid = ? OR contact_guid = ?);",
            [
                $guid,
                $_SESSION[USESSION]->user_guid,
                $_SESSION[USESSION]->user_guid
            ]
        );
    }

    /**
     *
     * Get conversations.
     *
     * */
    public function getConversations($made_date = null)
    {
        $conversations = [];
        $conversation_data = $this->getAll($made_date);

        foreach ($conversation_data as $conversation) {
            array_push(
                $conversations,
                new Conversation(
                    $conversation['conversation_guid'],
                    $conversation['contact_guid'],
                    htmlspecialchars($conversation['username']),
                    htmlspecialchars($conversation['contact_alias']),
                    $conversation['made_date']
                )
            );
        }

        return $conversations;
    }
}