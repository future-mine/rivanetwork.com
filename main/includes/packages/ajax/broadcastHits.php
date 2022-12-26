<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");
if (get("action") == "hits") {
  if (isset($_GET["broadcast"])) {
    $searchBroadcast = $db->prepare("SELECT * FROM broadcast WHERE id = ?");
    $searchBroadcast->execute(array(get("broadcast")));
    if ($searchBroadcast->rowCount() > 0) {
      $readBroadcast = $searchBroadcast->fetch();
      $newHits = $readBroadcast["hits"]+1;
      $updateBroadcastHits = $db->prepare("UPDATE broadcast SET hits = ? WHERE id = ?");
      $updateBroadcastHits->execute(array($newHits, $readBroadcast["id"]));
      die($readBroadcast["url"]);
    } else {
      die("error");
    }
  } else {
    die("error");
  }
} else {
  die("error");
}
?>