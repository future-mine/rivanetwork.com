<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/main/includes/php/settings.php");
  
  $searchAccountPaymentInformation = $db->prepare("SELECT * FROM accountPaymentInformation WHERE accountID = ?");
  $searchAccountPaymentInformation->execute(array($readAccount["id"]));
  if ($searchAccountPaymentInformation->rowCount() > 0) {
    $readAccountPaymentInformation = $searchAccountPaymentInformation->fetch();
    $paymentInformationStatus = true;
  } else {
    $paymentInformationStatus = false;
  }

  if(isset($_POST)) {
    $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
    $readPayments = $searchPayments->fetch();
    $readPaymentVariables = json_decode($readPayments["variables"], true);
    if ($rSettings["salesAgreementType"] == "0" || post("salesAgreement") == "yes") {
      if (post("amount") !== "" && post("firstName") !== "" && post("surName") !== "" && post("phoneNumber") !== "") {
        if (post("amount") >= $rSettings["minimumLoadCredit"]) {
          if ($readAccount["email"] !== "" && $readAccount["email"] !== "your@example.com") {
            if ($paymentInformationStatus == true) {
              $paymentInformationStatus = true;
            } else {
              if (post("firstName") !== "" && post("surName") !== "" && post("phoneNumber") !== "") {
                $insertAccountPaymentInformation = $db->prepare("INSERT INTO accountPaymentInformation (`accountID`, `firstName`, `surName`, `phoneNumber`, `date`) VALUES (?, ?, ?, ?, ?)");
                $insertAccountPaymentInformation->execute(array($readAccount["id"], post("firstName"), post("surName"), post("phoneNumber"), date("d.m.Y H:i:s")));
                $paymentInformationStatus = true;
              } else {
                $paymentInformationStatus = false;
              }
            }
            if ($paymentInformationStatus == true) {
              $updateAccountPaymentInformation = $db->prepare("UPDATE accountPaymentInformation SET firstName = ?, surName = ?, phoneNumber = ? WHERE accountID = ?");
              $updateAccountPaymentInformation->execute(array(post("firstName"), post("surName"), post("phoneNumber"), $readAccount["id"]));
              die(json_encode(["status" => true, "type" => "alert", "reason" => languageVariables("alertControl", "credit", $languageType), "amount" => post("amount"), "userID" => $readAccount["id"],]));
            } else {
              die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("alertInformation", "credit", $languageType)]));
            }
          } else {
            die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("alertEmail", "credit", $languageType)]));
          }
        } else {
          die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("alertMinUpload", "credit", $languageType)." ".$rSettings["minimumLoadCredit"]]));
        }
      } else {
        die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("alertNone", "credit", $languageType)]));
      }
    } else {
      die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("alertSalesAgreement", "credit", $languageType)]));
    }
  } else {
    die(json_encode(["status" => false, "type" => "alert", "reason" => languageVariables("systemError", "payments", $languageType)]));
  }
?>