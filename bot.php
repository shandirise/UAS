<?php

// Set up logging
ini_set('log_errors', 1);
ini_set('error_log', 'bot.log');
error_reporting(E_ALL);

// Replace 'YOUR_API_TOKEN' with your actual bot API token
$TOKEN = '7479492333:AAGnmTK6ux7mZh9A_hAVUgnzx9QyOxYJWus';

// Initialize the Telegram API
$api = new TelegramApi($TOKEN);

// Dictionary to store user nicknames
$user_nicks = array();

// Dictionary to store user chat IDs
$user_chats = array();

// Define a function to handle the /nick command
function handle_nick($update)
{
    $user_id = $update['message']['from']['id'];
    if (isset($user_nicks[$user_id])) {
        $api->sendMessage($update['message']['chat']['id'], "Your current nick is: " . $user_nicks[$user_id]);
    } else {
        $api->sendMessage($update['message']['chat']['id'], "You don't have a nick set. Please reply with your new nick.");
    }
    return NICK_STATE;
}

// Define a function to handle messages after /nick command
function handle_nick_message($update)
{
    $user_id = $update['message']['from']['id'];
    $new_nick = $update['message']['text'];
    $old_nick = isset($user_nicks[$user_id]) ? $user_nicks[$user_id] : null;
    $user_nicks[$user_id] = $new_nick;
    if ($old_nick) {
        foreach ($user_chats as $user_id => $chat_id) {
            if ($chat_id != $update['message']['chat']['id']) {
                $api->sendMessage($chat_id, "$old_nick has changed their nick to $new_nick!");
            }
        }
    } else {
        $api->sendMessage($update['message']['chat']['id'], "Your nick has been set to: $new_nick");
    }
    return ConversationHandler::END;
}

// Define a function to handle the /join command
function handle_join($update)
{
    $user_id = $update['message']['from']['id'];
    if (!isset($user_nicks[$user_id])) {
        $api->sendMessage($update['message']['chat']['id'], "You should set your nick first with /nick");
        return;
    }
    if (!isset($user_chats[$user_id])) {
        $chat_id = $update['message']['chat']['id'];
        $user_chats[$user_id] = $chat_id;
        $nick = $user_nicks[$user_id];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $update['message']['chat']['id']) {
                $api->sendMessage($chat_id_in_group, "$nick joined the group chat!");
            }
        }
        $api->sendMessage($update['message']['chat']['id'], "Joined the group chat! Chat ID: $chat_id");
    } else {
        $api->sendMessage($update['message']['chat']['id'], "You're already in the group chat!");
    }
}

// Define a function to handle the /leave command
function handle_leave($update)
{
    $user_id = $update['message']['from']['id'];
    if (isset($user_chats[$user_id])) {
        $chat_id = $update['message']['chat']['id'];
        unset($user_chats[$user_id]);
        $nick = $user_nicks[$user_id];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group == $chat_id) {
                $api->sendMessage($chat_id_in_group, "$nick left the group chat!");
            }
        }
        $api->sendMessage($update['message']['chat']['id'], "Left the group chat!");
    } else {
        $api->sendMessage($update['message']['chat']['id'], "You're not in the group chat!");
    }
}

// Define a function to handle the /list command
function handle_list($update)
{
    $chat_id = $update['message']['chat']['id'];
    $nicks = array();
    foreach ($user_chats as $user_id => $chat_id_in_group) {
        if ($chat_id_in_group == $chat_id) {
            $nicks[] = $user_nicks[$user_id];
        }
    }
    $api->sendMessage($update['message']['chat']['id'], "Users in the group chat:\n" . implode("\n", $nicks));
}

// Define a function to handle messages in the group chat
function handle_group_message($update)
{
    $user_id = $update['message']['from']['id'];
    $nick = $user_nicks[$user_id];
    $chat_id = $update['message']['chat']['id'];

    if (isset($update['message']['text'])) {
        $message = $update['message']['text'];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendMessage($chat_id_in_group, "$nick: $message");
            }
        }
    }

    if (isset($update['message']['sticker'])) {
        $sticker = $update['message']['sticker'];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendSticker($chat_id_in_group, $sticker['file_id']);
            }
        }
    }

    if (isset($update['message']['photo'])) {
        $photo = $update['message']['photo'][count($update['message']['photo']) - 1]; // Get the highest resolution photo
        $caption = "$nick: "; // Add the nickname to the caption
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendPhoto($chat_id_in_group, $photo['file_id'], $caption);
            }
        }
    }

    if (isset($update['message']['document'])) {
        $document = $update['message']['document'];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendDocument($chat_id_in_group, $document['file_id']);
            }
        }
    }

    if (isset($update['message']['video'])) {
        $video = $update['message']['video'];
        $caption = "$nick: "; // Add the nickname to the caption
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendVideo($chat_id_in_group, $video['file_id'], $caption);
            }
        }
    }

    if (isset($update['message']['audio'])) {
        $audio = $update['message']['audio'];
        foreach ($user_chats as $user_id => $chat_id_in_group) {
            if ($chat_id_in_group != $chat_id) {
                $api->sendAudio($chat_id_in_group, $audio['file_id']);
            }
        }
    }
}

// Define a function to handle the /start command
function handle_start($update)
{
    $api->sendMessage($update['message']['chat']['id'], "Available commands:\n"
        . "/nick - Set or change your nickname\n"
        . "/join - Join the group chat\n"
        . "/leave - Leave the group chat\n"
        . "/list - List users in the group chat\n");
}

// Telegram API class
class TelegramApi
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function sendMessage($chat_id, $text)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendMessage";
        $data = array('chat_id' => $chat_id, 'text' => $text);
        $this->sendRequest($url, $data);
    }

    public function sendSticker($chat_id, $sticker_id)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendSticker";
        $data = array('chat_id' => $chat_id, 'ticker' => $sticker_id);
        $this->sendRequest($url, $data);
    }

    public function sendPhoto($chat_id, $photo_id, $caption)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendPhoto";
        $data = array('chat_id' => $chat_id, 'photo' => $photo_id, 'caption' => $caption);
        $this->sendRequest($url, $data);
    }

    public function sendDocument($chat_id, $document_id)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendDocument";
        $data = array('chat_id' => $chat_id, 'document' => $document_id);
        $this->sendRequest($url, $data);
    }

    public function sendVideo($chat_id, $video_id, $caption)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendVideo";
        $data = array('chat_id' => $chat_id, 'video' => $video_id, 'caption' => $caption);
        $this->sendRequest($url, $data);
    }

    public function sendAudio($chat_id, $audio_id)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendAudio";
        $data = array('chat_id' => $chat_id, 'audio' => $audio_id);
        $this->sendRequest($url, $data);
    }

    private function sendRequest($url, $data)
    {
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }
        return $result;
    }
}

// Add command handlers
$api->addCommandHandler('/start', 'handle_start');
$api->addCommandHandler('/nick', 'handle_nick');
$api->addCommandHandler('/join', 'handle_join');
$api->addCommandHandler('/leave', 'handle_leave');
$api->addCommandHandler('/list', 'handle_list');

// Add message handlers
$api->addMessageHandler(TelegramFilters::text(), 'handle_group_message');
$api->addMessageHandler(TelegramFilters::photo(), 'handle_group_message');
$api->addMessageHandler(TelegramFilters::video(), 'handle_group_message');
$api->addMessageHandler(TelegramFilters::audio(), 'handle_group_message');

// Start the bot
$api->start();

?>