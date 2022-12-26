<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "check") {
  if (post("productID") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchChest = $db->prepare("SELECT * FROM userChest WHERE id = ? AND userID = ? AND status = ?");
      $searchChest->execute(array(post("productID"), $readAccount["id"], 0));
      if ($searchChest->rowCount() > 0) {
        $readChest = $searchChest->fetch();
        $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
        $searchProduct->execute(array($readChest["productID"]));
        if ($searchProduct->rowCount() > 0) {
          $readProduct = $searchProduct->fetch();
          $searchServerSingle = $db->prepare("SELECT * FROM serverList WHERE id = ?");
          $searchServerSingle->execute(array($readProduct["serverID"]));
          if ($searchServerSingle->rowCount() > 0) {
            $readServerSingle = $searchServerSingle->fetch();
            $searchCommandServer = json_decode($readProduct["commandServer"], true);
            $connectStatus = "__SUCCESSFULL__";
            foreach ($searchCommandServer as $readCommandServer) {
              $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
              $searchServer->execute(array($readCommandServer));
              if ($searchServer->rowCount() > 0) {
                $readServer = $searchServer->fetch();
                if ($readServer["connectType"] == "websend") {
                  require_once(__DR__."/main/includes/packages/class/websend/websend.php");
                  $serverConnect = new Websend($readServer["connectIP"], $readServer["connectPort"]);
                  $serverConnect->password = $readServer["connectPort"];
                } else if ($readServer["connectType"] == "websender") {
                  require_once(__DR__."/main/includes/packages/class/websender/websender.php");
                  $serverConnect = new Websender($readServer["connectIP"], $readServer["connectPassword"], $readServer["connectPort"]);
                } else if ($readServer["connectType"] == "rcon") {
                  require_once(__DR__."/main/includes/packages/class/rcon/rcon.php");
                  $serverConnect = new Rcon($readServer["connectIP"], $readServer["connectPort"], $readServer["connectPassword"], 3);
                } else {
                  require_once(__DR__."/main/includes/packages/class/websend/websend.php");
                  $serverConnect = new Websend($readServer["connectIP"], $readServer["connectPort"]);
                  $serverConnect->password = $readServer["connectPassword"];
                }
                if ($serverConnect->connect()) {
                  $connectStatus = "__SUCCESSFULL__";
                } else {
                  $connectStatus = "__UNSUCCESSFULL__";
                }
              } else {
                $connectStatus = "__UNSUCCESSFULL__";
              }
            }
            if ($connectStatus == "__SUCCESSFULL__") {
              $searchCommandServers = json_decode($readProduct["commandServer"], true);
              foreach ($searchCommandServers as $readCommandServer) {
                $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                $searchServer->execute(array($readCommandServer));
                if ($searchServer->rowCount() > 0) {
                  $readServer = $searchServer->fetch();
                
                  // COONNECTION RESOURCES
                  if ($readServer["connectType"] == "websend") {
                    require_once(__DR__."/main/includes/packages/class/websend/websend.php");
                    $serverConnect = new Websend($readServer["connectIP"], $readServer["connectPort"]);
                    $serverConnect->password = $readServer["connectPort"];
                  } else if ($readServer["connectType"] == "websender") {
                    require_once(__DR__."/main/includes/packages/class/websender/websender.php");
                    $serverConnect = new Websender($readServer["connectIP"], $readServer["connectPassword"], $readServer["connectPort"]);
                  } else if ($readServer["connectType"] == "rcon") {
                    require_once(__DR__."/main/includes/packages/class/rcon/rcon.php");
                    $serverConnect = new Rcon($readServer["connectIP"], $readServer["connectPort"], $readServer["connectPassword"], 3);
                  } else {
                    require_once(__DR__."/main/includes/packages/class/websend/websend.php");
                    $serverConnect = new Websend($readServer["connectIP"], $readServer["connectPort"]);
                    $serverConnect->password = $readServer["connectPassword"];
                  }
                
                  // CONNECT SERVER
                  if ($serverConnect->connect()) {
                    $productCommands = json_decode($readProduct["productCommand"], true);
                    foreach($productCommands as $commands){
                      $command = str_replace("%player%", $readAccount["username"], $commands);
                      $serverConnect->sendCommand($command);
                    }
                  }
                }
              }
              $updateChestStatus = $db->prepare("UPDATE userChest SET status = ? WHERE id = ? AND userID = ? AND status = ?");
              $updateChestStatus->execute(array(1, post("productID"), $readAccount["id"], 0));
              $insertHistory = $db->prepare("INSERT INTO chestHistory SET username = ?, type = ?, usernameTo = ?, serverName = ?, productName = ?, productPrice = ?, productID = ?, date = ?");
              $insertHistory->execute(array($readAccount["username"], 0, $readAccount["username"], $readServerSingle["name"], $readProduct["name"], $readProduct["price"], $readProduct["id"], date("d.m.Y H:i:s")));
              exit('{"code": "successyfull"}');
            } else {
              exit('{"code": "notConnect"}');
            }
          } else {
            exit('{"code": "notProduct"}');
          }
        } else {
          $deleteChest = $db->prepare("DELETE FROM userChest WHERE productID = ?");
          $deleteChest->execute(array($readChest["productID"]));
          exit('{"code": "notProduct"}');
        }
      } else {
        exit('{"code": "notProduct"}');
      }
    } else {
      exit('{"code": "notLogin"}');
    }
  } else {
    exit('{"code": "notData"}');
  }
} else if (get("action") == "gift") {
  if ($readModule["giftTransferStatus"] == "0") {
    exit('{"code": "transferDisabled"}');
  }
  if (post("productID") !== "" && post("username") !== "") {
    if (isset($_SESSION["incAccountLogin"])) {
      $searchChest = $db->prepare("SELECT * FROM userChest WHERE id = ? AND userID = ? AND status = ?");
      $searchChest->execute(array(post("productID"), $readAccount["id"], 0));
      if ($searchChest->rowCount() > 0) {
        $readChest = $searchChest->fetch();
        $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
        $searchProduct->execute(array($readChest["productID"]));
        if ($searchProduct->rowCount() > 0) {
          $readProduct = $searchProduct->fetch();
          $searchUser = $db->prepare("SELECT * FROM accounts WHERE username = ?");
          $searchUser->execute(array(post("username")));
          if ($searchUser->rowCount() > 0) {
            $readUser = $searchUser->fetch();
            if ($readChest["status"] == "0") {
              if ($readAccount["username"] !== $readUser["username"]) {
                if (inventoryItemCount($readUser["id"], 1) == true) {
                  $db->beginTransaction();
                  $deleteUserChest = $db->prepare("DELETE FROM userChest WHERE id = ? AND userID = ? AND status = ?");
                  $deleteUserChest->execute(array(post("productID"), $readAccount["id"], 0));
                  if ($deleteUserChest) {
                    $variables = "{\"productID\": \"".$readChest["productID"]."\", \"image\": \"".$readProduct["image"]."\"}";
                    $insertInventory = inventoryAddItem($readUser["id"], "2", $variables, date("d.m.Y H:i:s"));
                    if ($insertInventory) {
                      $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                      $searchServer->execute(array($readProduct["serverID"]));
                      $readServer = $searchServer->fetch();
                      $insertHistory = $db->prepare("INSERT INTO chestHistory SET username = ?, type = ?, usernameTo = ?, serverName = ?, productName = ?, productPrice = ?, productID = ?, date = ?");
                      $insertHistory->execute(array($readAccount["username"], 1, $readUser["username"], $readServer["name"], $readProduct["name"], $readProduct["price"], $readProduct["id"], date("d.m.Y H:i:s")));
                      if ($readUser["notificationStatus"] == "1") {
                        $insertNotifications = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                        $insertNotifications->execute(array($readUser["username"], $readUser["id"], languageVariables("notificationGiftYou", "chest", $languageType), '{"iconType":"item","username":"'.$readAccount["username"].'","product":"'.$readProduct["name"].'"}', "giftTransfer", date("d.m.Y H:i:s"), "unread"));
                      }
                      if ($readAccount["notificationStatus"] == "1") {
                        $insertNotification = $db->prepare("INSERT INTO accountsNotifications SET username = ?, userID = ?, text = ?, data = ?, type = ?, date = ?, status = ?");
                        $insertNotification->execute(array($readAccount["username"], $readAccount["id"], languageVariables("notificationGiftSend", "chest", $languageType), '{"iconType":"item","username":"'.$readUser["username"].'","product":"'.$readProduct["name"].'"}', "giftSender", date("d.m.Y H:i:s"), "unread"));
                      }
                      $db->commit();
                      exit('{"code": "successyfull"}');
                    } else {
                      $db->rollBack();
                      exit('{"code": "notData"}');
                    }
                  } else {
                    $db->rollBack();
                    exit('{"code": "notData"}');
                  }
                } else {
                  exit('{"code": "notSlot"}');
                }
              } else {
                exit('{"code": "sendToYourself"}');
              }
            } else {
              exit('{"code": "checkProduct"}');
            }
          } else {
            exit('{"code": "notAccount"}');
          }
        } else {
          $deleteChest = $db->prepare("DELETE FROM userChest WHERE productID = ?");
          $deleteChest->execute(array($readChest["productID"]));
          exit('{"code": "notProduct"}');
        }
      } else {
        exit('{"code": "notProduct"}');
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