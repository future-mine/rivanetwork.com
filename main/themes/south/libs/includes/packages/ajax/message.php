<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

function chatHistoryRemove()
{
  global $db;
  $searchMessage = $db->query("SELECT * FROM generalChat ORDER BY id DESC");
  $searchMessageLastID = $db->query("SELECT * FROM generalChat ORDER BY id DESC LIMIT 1");
  if ($searchMessage->rowCount() > 250) {
    $readMessage = $searchMessageLastID->fetch();
    $deletedMessageID = $readMessage["id"]-250;
    $deleteMessage = $db->prepare("DELETE FROM generalChat WHERE id <= ?");
    $deleteMessage->execute(array($deletedMessageID));
  }
  return true;
}

if (get("action") == "messageBoxUpdate") {
  $searchMessageID = $db->query("SELECT * FROM generalChat ORDER BY id DESC");
  $searchMessageLastID = $db->query("SELECT * FROM generalChat ORDER BY id DESC LIMIT 1");
  if ($searchMessageID->rowCount() > 50) {
    $readMessageLastID = $searchMessageLastID->fetch();
    $messageLastID = $readMessageLastID["id"]-50;
  } else {
    $messageLastID = "0";
  }
  chatHistoryRemove();
  $searchMessage = $db->prepare("SELECT * FROM generalChat WHERE id > ? ORDER BY id ASC");
  $searchMessage->execute(array($messageLastID));
  if ($searchMessage->rowCount() > 0) {
    foreach ($searchMessage as $readMessage) {
      if ($readMessage["username"] == $readAccount["username"] || $readMessage["messageAuthorIP"] == GetIP()) {
        echo "<div class=\"chat-widget-speaker right\"><p class=\"chat-widget-speaker-message\">" . $readMessage["message"] . "</p><p class=\"chat-widget-speaker-timestamp\">" . checkTime($readMessage["date"]) . "</p></div>";
      } else {
        echo "<div class=\"chat-widget-speaker left\"><div class=\"chat-widget-speaker-avatar\"><div class=\"user-avatar tiny no-border\"><a class=\"user-avatar-content\" href=\"/oyuncu/" . $readMessage["username"] . "\"><img src=\"https://minotar.net/bust/" . $readMessage["username"] . "/100.png\" width=\"30\" height=\"30\"></a></div></div><p class=\"chat-widget-speaker-message\">" . $readMessage["message"] . "</p><p class=\"chat-widget-speaker-timestamp\">" . checkTime($readMessage["date"]) . " ".str_replace("&username", "<a href=\"/oyuncu/" . $readMessage["username"] . "\" target=\"_blank\">" . $readMessage["username"] . "</a>", languageVariables("messageBy", "words", $languageType))."</p></div>";
      }
    }
    $_SESSION["messageRefresh"] = date("d.m.Y H:i:s");
  } else { 
    exit('false');
  }
} else if (get("action") == "info") {
  $messageUpdateTime = date("d.m.Y H:i:s",strtotime($_SESSION["messageRefresh"]." +15 seconds"));
  if (date("d.m.Y H:i:s") >= $messageUpdateTime) {
    exit('true');
  } else {
    exit('false');
  }
} else if (get("action") == "messageSend") {
  if (post("message") != null) {
    if (isset($_SESSION["incAccountLogin"])) {
      $messageAuthorUsername = $readAccount["username"];
    } else {
      $messageAuthorUsername = "anonim";
    }
    $insertMessage = $db->prepare("INSERT INTO generalChat SET username = ?, message = ?, messageAuthorIP = ?, date = ?");
    $insertMessage->execute(array($messageAuthorUsername, arghMessage(post("message")), GetIP(), date("d.m.Y H:i:s")));
    exit(post("message"));
  }
} else { 
  exit('false'); 
} 
?>