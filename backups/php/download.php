<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require(__DR__."/admin/libs/includes/php/settings.php");
  
  if (AccountPermControl($readAccount["id"], "modules_backups") == "PERMISSION_NOT_FOUND") {
    exit(languageVariables("alertNotPermissionFail", "words", $languageType));
  }

  if (isset($_GET["path"]) && isset($_GET["apiKey"])) {
    if (get("apiKey") == $rSettings["apiKey"]) {
      if (get("type") == "1") {
        require_once("backups.php");
        foreach (json_decode($backups, true) as $readBackups) {
          if (get("path") == $readBackups["code"]) {
            $sqlFile = __DR__.$readBackups["mysqlDirectory"];
            clearstatcache();
            if(file_exists($sqlFile)) {
              header('Content-Description: File Transfer');
              header('Content-Type: application/octet-stream');
              header('Content-Disposition: attachment; filename="'.basename($sqlFile).'"');
              header('Content-Length: ' . filesize($sqlFile));
              header('Pragma: public');
              flush();
              readfile($sqlFile,true);
            }
          }
        }
      } else {
        require_once("backups.php");
        $redirectStatus = "FALSE";
        foreach (json_decode($backups, true) as $readBackups) {
          if (get("path") == $readBackups["code"]) {
            $fileDirectory = __DR__.$readBackups["fileDirectory"];
            clearstatcache();
            if(file_exists($fileDirectory)) {
              header('Content-Description: File Transfer');
              header('Content-Type: application/octet-stream');
              header('Content-Disposition: attachment; filename="'.basename($fileDirectory).'"');
              header('Content-Length: ' . filesize($fileDirectory));
              header('Pragma: public');
              flush();
              readfile($fileDirectory,true);
              $redirectStatus = "TRUE";
            }
          }
        }
      }
    } else {
      header("Location: ".urlConverter("admin_modules_backup", $languageType));
      exit;
    }
  } else {
    header("Location: ".urlConverter("admin_modules_backup", $languageType));
    exit;
  }
?>