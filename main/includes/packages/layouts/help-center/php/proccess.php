<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/main/includes/php/settings.php");

  if(isset($_POST)) {
    if (!isset($_COOKIE["helpVote-".post("helpID")])) {
      if (post("helpID") !== "" && post("type") !== "") {
        setcookie("helpVote-".post("helpID"), "view");
        if (post("type") == "0") {
          $updateHelpFull = $db->prepare("UPDATE helpCenter SET useless = useless + 1 WHERE id = ?");
          $updateHelpFull->execute(array(post("helpID")));
        } else if (post("type") == "1") {
          $updateHelpFull = $db->prepare("UPDATE helpCenter SET useful = useful + 1 WHERE id = ?");
          $updateHelpFull->execute(array(post("helpID")));
        }
        die(json_encode(["status" => true, "reason" => languageVariables("alertVoteSuccess", "helpCenter", $languageType)]));
      }
    } else {
      die(json_encode(["status" => false, "reason" => languageVariables("alertVoteFailed", "helpCenter", $languageType)]));
    }
  }
?>