<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }
  
  if (get("action") == "connect") {
    if (post("connectIP") !== "" && post("connectType") !== "" && post("connectPort") !== "" && post("connectPassword") !== "") {
      $connectIP = post("connectIP");
      $connectType = post("connectType");
      $connectPort = post("connectPort");
      $connectPassword = post("connectPassword");
      $connectTimeout = 3;
      
      if ($connectType == "websend") {
        require_once(__DR__."/main/includes/packages/class/websend/websend.php");
        $connect = new Websend($connectIP, $connectPort);
        $connect->password = $connectPassword;
      } else if ($connectType == "websender") {
        require_once(__DR__."/main/includes/packages/class/websender/websender.php");
        $connect = new Websender($connectIP, $connectPassword, $connectPort);
      } else if ($connectType == "rcon") {
        require_once(__DR__."/main/includes/packages/class/rcon/rcon.php");
        $connect = new Rcon($connectIP, $connectPort, $connectPassword, $connectTimeout);
      } else {
        require_once(__DR__."/main/includes/packages/class/websend/websend.php");
        $connect = new Websend($connectIP, $connectPort);
        $connect->password = $connectPassword;
      }
      if (@$connect->connect()) {
        $connect->disconnect();
		exit('{"code": "__SUCCESSYFULL__"}');
      } else {
        exit('{"code": "__UNSUCCESSYFULL__", "reason": "Bağlantı başarısız"}');
      }
    } else {
      exit('{"code": "__UNSUCCESSYFULL__", "reason": "Eksik veri"}');
    }
  } else {
    exit('{"code": "__UNSUCCESSYFULL__", "reason": "Eksik veri"}');
  }
?>