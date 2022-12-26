<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if ($_POST) {
  if (post("cardID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchCard = $db->prepare("SELECT * FROM cardGame WHERE id = ?");
      $searchCard->execute(array(post("cardID")));
      if ($searchCard->rowCount() > 0) {
        $readCard = $searchCard->fetch();
        if ($readCard["type"] == "0") {
          $beforeHours = time()-($readCard['hours']*3600);
          $searchCardGameHistory = $db->prepare("SELECT * FROM cardGameHistory WHERE cardID = ? AND userID = ? AND timeStamp > ?");
          $searchCardGameHistory->execute(array($readCard["id"], $readAccount['id'], $beforeHours));
          if ($searchCardGameHistory->rowCount() == 0) {
            if (inventoryItemCount($readAccount["id"], 1) == true) {
              $randomNumber = rand(1,100);
              $chance = 0;
              $searchCardItem = $db->prepare("SELECT * FROM cardGameItem WHERE cardID = ?");
              $searchCardItem->execute(array($readCard["id"]));
              foreach ($searchCardItem as $readCardItem) {
                if (!isset($winnerReward)) {
                  $chance = $chance+$readCardItem["chance"];
                  if ($chance > $randomNumber) {
                    $winnerReward = $readCardItem;
                  }
                }
              }
              if ($winnerReward["type"] == "1") {
                $variables = "{\"credit\": \"".$winnerReward["reward"]."\", \"image\": \"".$winnerReward["image"]."\"}";
                inventoryAddItem($readAccount["id"], "1", $variables, date("d.m.Y H:i:s"));
                $rewardType = "winner";
              } else if ($winnerReward["type"] == "2") {
                $variables = "{\"productID\": \"".$winnerReward["reward"]."\", \"image\": \"".$winnerReward["image"]."\"}";
                inventoryAddItem($readAccount["id"], "2", $variables, date("d.m.Y H:i:s"));
                $rewardType = "winner";
              } else {
                $rewardType = "loser";
              }
              $insertCardGameHistory = $db->prepare("INSERT INTO cardGameHistory SET userID = ?, username = ?, cardID = ?, reward = ?, rewardType = ?, date = ?, timeStamp = ?");
              $insertCardGameHistory->execute(array($readAccount["id"], $readAccount["username"], $readCard["id"], $winnerReward["name"], $rewardType, date("d.m.Y H:i:s"), time()));
              exit('{ "code":"successyfull", "name": "'.$winnerReward["name"].'", "image": "'.$winnerReward["image"].'", "type": "'.$rewardType.'", "credit": "'.$readAccount["credit"].'", "cardType": "'.$readCard["type"].'"}');
            } else {
              exit('{ "code":"inventorySlot"}');
            }
          } else {
            $readCardGameHistory = $searchCardGameHistory->fetch();
            $passingTime = (time()-$readCardGameHistory['timeStamp']);
            $totalRemainingTime = $readCard['hours']*3600-$passingTime;
            $hoursRemaining = floor($totalRemainingTime/3600);
            $minutesRemaining = floor(($totalRemainingTime-$hoursRemaining*3600)/60);
            $variableTime = $hoursRemaining." ".languageVariables("hours", "date", $languageType)." ".$minutesRemaining." ".languageVariables("minute", "date", $languageType);
            exit('{ "code":"notHours", "after": "'.$variableTime.'"}');
          }
        } else if ($readCard["type"] == "1") {
          if ($readAccount["credit"] >= $readCard["price"]) {
            if (inventoryItemCount($readAccount["id"], 1) == true) {
              $userNewCredit = $readAccount["credit"]-$readCard["price"];
              $readAccount["credit"] = $userNewCredit;
              $updateAccount = $db->prepare("UPDATE accounts SET credit = ? WHERE id = ?");
              $updateAccount->execute(array($userNewCredit, $readAccount["id"]));
              if ($updateAccount) {
                $randomNumber = rand(1,100);
                $chance = 0;
                $searchCardItem = $db->prepare("SELECT * FROM cardGameItem WHERE cardID = ?");
                $searchCardItem->execute(array($readCard["id"]));
                foreach ($searchCardItem as $readCardItem) {
                  if (!isset($winnerReward)) {
                    $chance = $chance+$readCardItem["chance"];
                    if ($chance > $randomNumber) {
                      $winnerReward = $readCardItem;
                    }
                  }
                }
                if ($winnerReward["type"] == "1") {
                  $variables = "{\"credit\": \"".$winnerReward["reward"]."\", \"image\": \"".$winnerReward["image"]."\"}";
                  inventoryAddItem($readAccount["id"], "1", $variables, date("d.m.Y H:i:s"));
                  $rewardType = "winner";
                } else if ($winnerReward["type"] == "2") {
                  $variables = "{\"productID\": \"".$winnerReward["reward"]."\", \"image\": \"".$winnerReward["image"]."\"}";
                  inventoryAddItem($readAccount["id"], "2", $variables, date("d.m.Y H:i:s"));
                  $rewardType = "winner";
                } else {
                  $rewardType = "loser";
                }
                $insertCardGameHistory = $db->prepare("INSERT INTO cardGameHistory SET userID = ?, username = ?, cardID = ?, reward = ?, rewardType = ?, date = ?, timeStamp = ?");
                $insertCardGameHistory->execute(array($readAccount["id"], $readAccount["username"], $readCard["id"], $winnerReward["name"], $rewardType, date("d.m.Y H:i:s"), time()));
                exit('{ "code":"successyfull", "name": "'.$winnerReward["name"].'", "image": "'.$winnerReward["image"].'", "type": "'.$rewardType.'", "credit": "'.$readAccount["credit"].'", "cardType": "'.$readCard["type"].'"}');
              } else {
                exit('{ "code":"systemError"}');
              }
            } else {
              exit('{ "code":"inventorySlot"}');
            }
          } else {
            exit('{ "code":"insufficientCredit"}');
          }
        } else {
          exit('{ "code":"dataError"}');
        }
      } else {
        exit('{ "code":"dataError"}');
      }
    } else {
      exit('{ "code":"notLogin"}');
    }
  } else {
    exit('{ "code":"dataError"}');
  }
} else {
  exit('{ "code":"dataError"}');
}
?>