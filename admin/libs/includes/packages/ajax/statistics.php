<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }
  
  $totalEarning = $db->prepare("SELECT SUM(amount) AS earning FROM creditHistory WHERE type = ?");
  $totalEarning->execute(array(0));
  $readTotalEarning = $totalEarning->fetch();
  if ($readTotalEarning["earning"] == null) {
    $readTotalEarning["earning"] = 0;
  }
  $searchSales = $db->query("SELECT id FROM storeHistory");
  $totalSales = $searchSales->rowCount();
  $searchRegister = $db->query("SELECT id FROM accounts");
  $totalRegister = $searchRegister->rowCount();
  exit('{"earning":"'.floor($readTotalEarning["earning"]).'","sales":"'.$totalSales.'","register":"'.$totalRegister.'"}');
?>