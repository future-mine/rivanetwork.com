<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }
  
  if (post("categoryID") >= 0) {
    $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?");
    $searchCategory->execute(array(post("categoryID")));
    if (mysqlCount($searchCategory) > 0 || post("categoryID") == "0") {
      if (mysqlCount($searchCategory) > 0) {
        $readCategory = fetch($searchCategory);
        $categoryID = $readCategory["id"];
      } else {
        $categoryID = "0";
	  }
      $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? ORDER BY id DESC");
      $searchProducts->execute(array($categoryID));
      if (mysqlCount($searchProducts) > 0) {
        foreach ($searchProducts as $readProducts) {
          echo "<option value=\"" . $readProducts["id"] . "\">" . $readProducts["name"] . "</option>";
        }
      } else {
        echo "<option value=\"0\">".languageVariables("ajaxCategoryNotProductAlert", "store", $languageType)."</option>";
      }
    }
  }
?>