<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/main/includes/php/settings.php");

  if (get("action") == "topicRemove") {
    if ($_POST) {
      if (post("topicID") !== "") {
        if (isset($_SESSION["incAccountLogin"])) {
          $searchTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ? AND (status = ? OR status = ? OR status = ?)");
          $searchTopic->execute(array(post("topicID"), 0, 1, 2));
          if ($searchTopic->rowCount() > 0) {
            $readTopic = $searchTopic->fetch();
            if ($readTopic["author"] == $readAccount["username"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") {
              $updateTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
              $updateTopic->execute(array(3, $readTopic["id"]));
              exit('{"code":"successyfull"}');
            } else {
              exit('{"code":"notIsTopic"}');
            }
          } else {
            exit('{"code":"notMessage"}');
          }
        } else {
          exit('{"code":"notLogin"}');
        }
      } else {
        exit('{"code":"dataError"}');
      }
    } else {
      exit('{"code":"dataError"}');
    }
  } else if (get("action") == "messageRemove") {
    if ($_POST) {
      if (post("messageID") !== "") {
        if (isset($_SESSION["incAccountLogin"])) {
          $searchMessage = $db->prepare("SELECT * FROM forumMessage WHERE id = ? AND status = ?");
          $searchMessage->execute(array(post("messageID"), 0));
          if ($searchMessage->rowCount() > 0) {
            $readMessage = $searchMessage->fetch();
            if ($readMessage["author"] == $readAccount["username"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") {
              $updateMessage = $db->prepare("UPDATE forumMessage SET status = ? WHERE id = ?");
              $updateMessage->execute(array(3, $readMessage["id"]));
              exit('{"code":"successyfull"}');
            } else {
              exit('{"code":"notIsTopic"}');
            }
          } else {
            exit('{"code":"notMessage"}');
          }
        } else {
          exit('{"code":"notLogin"}');
        }
      } else {
        exit('{"code":"dataError"}');
      }
    } else {
      exit('{"code":"dataError"}');
    }
  } else if (get("action") == "report") {
    if ($_POST) {
      if (post("type") !== "" && post("reportID") !== "" && post("message") !== "") {
        if (isset($_SESSION["incAccountLogin"])) {
          $searchReport = $db->prepare("SELECT * FROM forumReport WHERE messageID = ? AND reportType = ? AND status = ? AND reporter = ?");
          $searchReport->execute(array(post("reportID"), post("type"), 0, $readAccount["username"]));
          if ($searchReport->rowCount() == 0) {
            if (post("type") == "topic") {
              $searchReportMessage = $db->prepare("SELECT * FROM forumTopic WHERE id = ?");
              $searchReportMessage->execute(array(post("reportID")));
            } else if (post("type") == "message") {
              $searchReportMessage = $db->prepare("SELECT * FROM forumMessage WHERE id = ?");
              $searchReportMessage->execute(array(post("reportID")));
            }
            if ($searchReportMessage->rowCount() > 0) {
              $readReportMessage = $searchReportMessage->fetch();
              $insertReport = $db->prepare("INSERT INTO forumReport (`reportType`, `status`, `messageID`, `reporter`, `message`, `date`) VALUES (?, ?, ?, ?, ?, ?)");
              $insertReport->execute(array(post("type"), 0, post("reportID"), $readAccount["username"], post("message"),date("d.m.Y H:i:s")));
              exit('{"code":"successyfull"}');
            } else {
              exit('{"code":"notReportMessage"}');
            }
          } else {
            exit('{"code":"alreadyReport"}');
          }
        } else {
          exit('{"code":"notLogin"}');
        }
      } else {
        exit('{"code":"dataError"}');
      }
    } else {
      exit('{"code":"dataError"}');
    }
  } else if (get("action") == "activeUsers") {
    $searchActiveAccountsID = $db->query("SELECT id,accountID FROM accountLoginSessions ORDER BY id DESC");
    if ($searchActiveAccountsID->rowCount() > 0) {
      $activeAccountNumber = 0;
      foreach ($searchActiveAccountsID as $readActiveAccountsID) {
        $activeAccountNumber += 1;
        $searchActiveAccounts = $db->prepare("SELECT id,username,permission FROM accounts WHERE id = ?");
        $searchActiveAccounts->execute(array($readActiveAccountsID["accountID"]));
        if ($searchActiveAccounts->rowCount() > 0) {
          $readActiveAccounts = $searchActiveAccounts->fetch();
          $searchPlayerPermission = $db->prepare("SELECT id,permColorBG FROM accountsPermission WHERE id = ?");
          $searchPlayerPermission->execute(array($readActiveAccounts["permission"]));
          $readPlayerPermission = $searchPlayerPermission->fetch();
          echo (($activeAccountNumber == 1) ? "" : ", ").'<a href="'.urlConverter("player", $languageType).'/'.$readActiveAccounts["username"].'" style="color: '.$readPlayerPermission["permColorBG"].'">'.$readActiveAccounts["username"].'</a>';
        } 
      }
    }
  }
?>