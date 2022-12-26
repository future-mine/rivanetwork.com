<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "close") {
  if (post("supportID") !== "") {
    $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ? AND username = ?");
    $searchSupport->execute(array(post("supportID"), $readAccount["username"]));
    if ($searchSupport->rowCount() > 0) {
      $readSupport = $searchSupport->fetch();
      $updateSupport = $db->prepare("UPDATE supportList SET status = ?, lastUpdate = ? WHERE id = ?");
      $updateSupport->execute(array(2, date("d.m.Y H:i:s"), $readSupport["id"]));
      exit('{"code": "successyfull"}');
    } else {
      exit('{"code": "notData"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else {
  exit('{"code": "notData"}');
}
?>