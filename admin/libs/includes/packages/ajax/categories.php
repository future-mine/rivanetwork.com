<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }
  
  if (post("serverID") > 0) {
    $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
    $searchServer->execute(array(post("serverID")));
    if (mysqlCount($searchServer) > 0) {
      $readServer = fetch($searchServer);
      $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id DESC");
      $searchCategories->execute(array($readServer["id"]));
      if (mysqlCount($searchCategories) > 0) {
        echo "<option value=\"0\">".languageVariables("notCategory", "store", $languageType)."</option>";
        foreach ($searchCategories as $readCategory) {
          echo "<option value=\"" . $readCategory["id"] . "\">" . $readCategory["name"] . "</option>";
        }
      } else {
        echo "<option value=\"0\">".languageVariables("notCategory", "store", $languageType)."</option>";
      }
    }
  }
?>