<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "ticketPurchase") {
  if (post("count") > 0) {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchLottery = $db->prepare("SELECT * FROM lotterySettings WHERE status = ? AND ? > starterDate AND endDate > ? ORDER BY id DESC LIMIT 1");
      $searchLottery->execute(array(1, date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));
      if ($searchLottery->rowCount() > 0) {
        $readLottery = $searchLottery->fetch();
        $ticketPaid = $readLottery["ticketPrice"]*post("count");
        if ($readAccount["credit"] >= $ticketPaid) {
          $searchPlayerTickets = $db->prepare("SELECT * FROM lotteryJoins WHERE userID = ? AND lotteryPass = ?");
          $searchPlayerTickets->execute(array($readAccount["id"], $readLottery["lotteryPass"]));
          if ($searchPlayerTickets->rowCount() > 0) {
            $readPlayerTickets = $searchPlayerTickets->fetch();
            $ticketProccess = $db->prepare("UPDATE lotteryJoins SET tickets = ? WHERE id = ?");
            $ticketProccess->execute(array($readPlayerTickets["tickets"]+post("count"), $readPlayerTickets["id"]));
          } else {
            $ticketProccess = $db->prepare("INSERT INTO lotteryJoins (`userID`, `username`, `tickets`, `lotteryPass`, `date`) VALUES (?, ?, ?, ?, ?)");
            $ticketProccess->execute(array($readAccount["id"], $readAccount["username"], post("count"), $readLottery["lotteryPass"], date("d.m.Y H:i:s")));
          }
          if ($ticketProccess) {
            $updateAccount = $db->prepare("UPDATE accounts SET credit = ? WHERE id = ?");
            $updateAccount->execute(array($readAccount["credit"]-$ticketPaid, $readAccount["id"]));
            exit('{"code": "successyfull"}');
          } else {
            exit('{"code": "notData"}');
          }
        } else {
          exit('{"code": "notCredit"}');
        }
      } else {
        exit('{"code": "notData"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else {
  exit('{"code": "notData"}');
}
?>