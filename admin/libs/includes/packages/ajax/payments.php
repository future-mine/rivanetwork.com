<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }
  
  $totalEarning = $db->prepare("SELECT variables FROM paymentTransactions WHERE status = ?");
  $totalEarning->execute(array(1));
  $totalEarningValue = 0;
  foreach ($totalEarning as $readTotalEarning) {
    $readTotalEarningData = json_decode($readTotalEarning["variables"], true);
    if (isset($readTotalEarningData["vat"]) && $readTotalEarningData["vat"] > 0) {
      $readTotalEarningData["amount"] = $readTotalEarningData["amount"]+($readTotalEarningData["amount"]*($readTotalEarningData["vat"]/100));
    }
    $totalEarningValue = $totalEarningValue+$readTotalEarningData["amount"];
  }

  $thisYearEarning = $db->prepare("SELECT variables FROM paymentTransactions WHERE status = ? AND date LIKE ?");
  $thisYearEarning->execute(array(1, "%".date("Y")."%"));
  $yearEarningValue = 0;
  foreach ($thisYearEarning as $readYearEarning) {
    $readYearEarningData = json_decode($readYearEarning["variables"], true);
    if (isset($readYearEarningData["vat"]) && $readYearEarningData["vat"] > 0) {
      $readYearEarningData["amount"] = $readYearEarningData["amount"]+($readYearEarningData["amount"]*($readYearEarningData["vat"]/100));
    }
    $yearEarningValue = $yearEarningValue+$readYearEarningData["amount"];
  }

  $thisMonthEarning = $db->prepare("SELECT variables FROM paymentTransactions WHERE status = ? AND date LIKE ?");
  $thisMonthEarning->execute(array(1, "%".date("m.Y")."%"));
  $monthEarningValue = 0;
  foreach ($thisMonthEarning as $readMonthEarning) {
    $readMonthEarningData = json_decode($readMonthEarning["variables"], true);
    if (isset($readMonthEarningData["vat"]) && $readMonthEarningData["vat"] > 0) {
      $readMonthEarningData["amount"] = $readMonthEarningData["amount"]+($readMonthEarningData["amount"]*($readMonthEarningData["vat"]/100));
    }
    $monthEarningValue = $monthEarningValue+$readMonthEarningData["amount"];
  }

  $thisTodayEarning = $db->prepare("SELECT variables FROM paymentTransactions WHERE status = ? AND date LIKE ?");
  $thisTodayEarning->execute(array(1, "%".date("d.m.Y")."%"));
  $todayEarningValue = 0;
  foreach ($thisTodayEarning as $readTodayEarning) {
    $readTodayEarningData = json_decode($readTodayEarning["variables"], true);
    if (isset($readTodayEarningData["vat"]) && $readTodayEarningData["vat"] > 0) {
      $readTodayEarningData["amount"] = $readTodayEarningData["amount"]+($readTodayEarningData["amount"]*($readTodayEarningData["vat"]/100));
    }
    $todayEarningValue = $todayEarningValue+$readTodayEarningData["amount"];
  }

  exit('{"allEarn":"'.number_format($totalEarningValue, 2).'", "yearEarn":"'.number_format($yearEarningValue, 2).'", "monthEarn":"'.number_format($monthEarningValue, 2).'", "todayEarn":"'.number_format($todayEarningValue, 2).'"}');
?>