<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  AccountLoginControl(false);
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED") {
    if (get("action") == "change") {
      if (post("themeID") !== "") {
        $searchChangeTheme = $db->prepare("SELECT * FROM themes WHERE id = ?");
        $searchChangeTheme->execute(array(post("themeID")));
        if (mysqlCount($searchChangeTheme) > 0) {
          $readChangeTheme = fetch($searchChangeTheme);
          $updateThemes = $db->prepare("UPDATE themes SET status = ? WHERE status = ?");
          $updateThemes->execute(array(0, 1));
          $saveChanges = $db->prepare("UPDATE themes SET status = ? WHERE id = ?");
          $saveChanges->execute(array(1, $readChangeTheme["id"]));
          exit('{"code": "__SUCCESSYFULL__"}');
        } else {
          exit('{"code": "__UNSUCCESSYFULL__"}');
        }
      } else {
        exit('{"code": "__UNSUCCESSYFULL__"}');
      }
    } else {
      exit('{"code": "__UNSUCCESSYFULL__"}');
    }
  } else {
    exit('{"code": "__UNSUCCESSYFULL__"}');
  } 
?>