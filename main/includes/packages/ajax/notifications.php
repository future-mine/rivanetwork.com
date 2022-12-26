<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");
if (get("action") == "read") {
  $readNotifications = $db->prepare("UPDATE accountsNotifications SET status = ? WHERE userID = ?");
  $readNotifications->execute(array("read", $readAccount["id"]));
  die("OK");
}
?>