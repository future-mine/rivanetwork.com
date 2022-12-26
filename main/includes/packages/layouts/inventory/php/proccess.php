<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "info") {
  if ($_POST) {
    if (post("inventID") !== "") {
      $searchInventory = $db->prepare("SELECT * FROM accountsInventory WHERE id = ? AND userID = ?");
      $searchInventory->execute(array(post("inventID"), $readAccount["id"]));
      if ($searchInventory->rowCount() > 0) {
        $readInventory = $searchInventory->fetch();
        $inventoryData = json_decode($readInventory["variables"], true);
        if ($readInventory["type"] == "1") {
          exit('{"code": "successyfull", "name": "'.$inventoryData["credit"].' Kredi", "type": "'.$readInventory["type"].'"}');
        } else if ($readInventory["type"] == "2") {
          $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
          $searchProduct->execute(array($inventoryData["productID"]));
          if ($searchProduct->rowCount() > 0) {
            $readProduct = $searchProduct->fetch();
            $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
            $searchServer->execute(array($readProduct["serverID"]));
            if ($searchServer->rowCount() > 0) {
              $readServer = $searchServer->fetch();
              exit('{"code": "successyfull", "serverName": "'.$readServer["name"].'", "name": "'.$readProduct["name"].'", "type": "'.$readInventory["type"].'"}');
            } else {
              exit('{"code": "notData"}');
            }
          } else {
            exit('{"code": "notData"}');
          }
        }
      } else {
        exit('{"code": "notData"}');
      }
    } else {
      exit('{"code": "notData"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else if (get("action") == "buy") {
  if ($_POST) {
    if (post("buySlot") !== "") {
      if (isset($_SESSION["incAccountLogin"])) {
        if (post("buySlot") == "6") {
          $price = "24";
        } else if (post("buySlot") == "12") {
          $price = "42";
        } else if (post("buySlot") == "18") {
          $price = "70";
        }
        if ($readAccount["credit"] >= $price) {
          if ($readAccount !== "30") {
            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit - ?, inventorySlot = inventorySlot + ? WHERE id = ?");
            $updateAccount->execute(array($price, post("buySlot"), $readAccount["id"]));
            exit('{"code": "successyfull"}');
          } else {
            exit('{"code": "fullSlot"}');
          }
        } else {
          exit('{"code": "notCredit"}');
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
} else if (get("action") == "check") {
  if ($_POST) {
    if (post("inventIDCheck") !== "") {
      $searchInventory = $db->prepare("SELECT * FROM accountsInventory WHERE id = ? AND userID = ?");
      $searchInventory->execute(array(post("inventIDCheck"), $readAccount["id"]));
      if ($searchInventory->rowCount() > 0) {
        $readInventory = $searchInventory->fetch();
        $inventoryData = json_decode($readInventory["variables"], true);
        if ($readInventory["type"] == "1") {
          $updateAccount = $db->prepare("UPDATE accounts SET credit = credit + ? WHERE id = ?");
          $updateAccount->execute(array($inventoryData["credit"], $readAccount["id"]));
          $deleteInventory = $db->prepare("DELETE FROM accountsInventory WHERE id = ?");
          $deleteInventory->execute(array($readInventory["id"]));
        } else if ($readInventory["type"] == "2") {
          $insertChest = $db->prepare("INSERT INTO userChest SET userID = ?, productID = ?,  status = ?, date = ?");
          $insertChest->execute(array($readAccount["id"], $inventoryData["productID"], 0, date("d.m.Y H:i:s")));
          $deleteInventory = $db->prepare("DELETE FROM accountsInventory WHERE id = ?");
          $deleteInventory->execute(array($readInventory["id"]));
        }
        exit('{"code": "successyfull", "inventType": "'.$readInventory["type"].'"}');
      } else {
        exit('{"code": "notData"}');
      }
    } else {
      exit('{"code": "notData"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else if (get("action") == "checkAll") {
  if ($_POST) {
    if (post("proccess") == "checkAll") {
      $searchInventory = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?");
      $searchInventory->execute(array($readAccount["id"]));
      if ($searchInventory->rowCount() > 0) {
        foreach ($searchInventory as $readInventory) {
          $inventoryData = json_decode($readInventory["variables"], true);
          if ($readInventory["type"] == "1") {
            $updateAccount = $db->prepare("UPDATE accounts SET credit = credit + ? WHERE id = ?");
            $updateAccount->execute(array($inventoryData["credit"], $readAccount["id"]));
            $deleteInventory = $db->prepare("DELETE FROM accountsInventory WHERE id = ?");
            $deleteInventory->execute(array($readInventory["id"]));
          } else if ($readInventory["type"] == "2") {
            $insertChest = $db->prepare("INSERT INTO userChest SET userID = ?, productID = ?,  status = ?, date = ?");
            $insertChest->execute(array($readAccount["id"], $inventoryData["productID"], 0, date("d.m.Y H:i:s")));
            $deleteInventory = $db->prepare("DELETE FROM accountsInventory WHERE id = ?");
            $deleteInventory->execute(array($readInventory["id"]));
          }
        }
        exit('{"code": "successyfull"}');
      } else {
        exit('{"code": "notItem"}');
      }
    } else {
      exit('{"code": "notData"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else if (get("action") == "gift") {
  if ($readModule["giftTransferStatus"] == "0") {
    exit('{"code": "transferDisabled"}');
  }
  if ($_POST) {
    if (post("inventIDGift") !== "" && post("username") !== "") {
      $searchInventory = $db->prepare("SELECT * FROM accountsInventory WHERE id = ? AND userID = ?");
      $searchInventory->execute(array(post("inventIDGift"), $readAccount["id"]));
      if ($searchInventory->rowCount() > 0) {
        $searchPlayer = $db->prepare("SELECT * FROM accounts WHERE username = ?");
        $searchPlayer->execute(array(post("username")));
        if ($searchPlayer->rowCount() > 0) {
          $readPlayer = $searchPlayer->fetch();
          if (inventoryItemCount($readPlayer["id"], 1) == true) {
            if ($readAccount["id"] !== $readPlayer["id"]) {
              $readInventory = $searchInventory->fetch();
              $inventoryData = json_decode($readInventory["variables"], true);
              $variables = $readInventory["variables"];
              inventoryAddItem($readPlayer["id"], $readInventory["type"], $variables, date("d.m.Y H:i:s"));
              $deleteInventory = $db->prepare("DELETE FROM accountsInventory WHERE id = ? AND userID = ?");
              $deleteInventory->execute(array($readInventory["id"], $readAccount["id"]));
              if ($readInventory["type"] == "1") {
                if ($readPlayer["notificationStatus"] == "1") {
                  $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                  $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("notificationGiftYou", "inventory", $languageType), '{"iconType":"item","username":"'.$readAccount["username"].'", "product": "'.$inventoryData["credit"].' Kredi"}', "giftTransferInventory", date("d.m.Y H:i:s"), "unread"));
                }
                if ($readAccount["notificationStatus"] == "1") {
                  $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                  $insertNotifications->execute(array($readAccount["username"], $readAccount["id"], languageVariables("notificationGiftSend", "inventory", $languageType), '{"iconType":"item","username":"'.$readPlayer["username"].'", "product": "'.$inventoryData["credit"].' Kredi"}', "giftSenderInventory", date("d.m.Y H:i:s"), "unread"));
                }
              } else if ($readInventory["type"] == "2") {
                $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                $searchProduct->execute(array($inventoryData["productID"]));
                $readProduct = $searchProduct->fetch();
                if ($readPlayer["notificationStatus"] == "1") {
                  $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                  $insertNotifications->execute(array($readPlayer["username"], $readPlayer["id"], languageVariables("notificationGiftYou", "inventory", $languageType), '{"iconType":"item","username":"'.$readAccount["username"].'", "product": "'.$readProduct["name"].'"}', "giftTransferInventory", date("d.m.Y H:i:s"), "unread"));
                }
                if ($readAccount["notificationStatus"] == "1") {
                  $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                  $insertNotifications->execute(array($readAccount["username"], $readAccount["id"], languageVariables("notificationGiftSend", "inventory", $languageType), '{"iconType":"item","username":"'.$readPlayer["username"].'", "product": "'.$readProduct["name"].'"}', "giftSenderInventory", date("d.m.Y H:i:s"), "unread"));
                }
              }
              exit('{"code": "successyfull"}');
            } else {
              exit('{"code": "notGiftSelf"}');
            }
          } else {
            exit('{"code": "notInventory"}');
          }
        } else {
          exit('{"code": "notPlayer"}');
        }
      } else {
        exit('{"code": "notData"}');
      }
    } else {
      exit('{"code": "notData"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
}
?>