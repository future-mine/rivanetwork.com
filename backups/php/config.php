<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require(__DR__."/admin/libs/includes/php/settings.php");

  if ($rSettings["apiKey"] == get("apiKey") && get("action") == "backup") {
    $backups = '[]';
    require_once(__DR__."/backups/php/backups.php");
    require_once(__DR__."/main/includes/packages/class/functions/backup.class.php");
    $backups = json_decode($backups, true);
    $dateTime = time();
    $code = rand(1,1000000);
    mkdir(__DR__."/backups/files/".$dateTime."-".$code);
    $filebackupDirectory = __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip";
    $mysqlbackupDirectory = __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-MYSQL-".$code.".sql";
    mysqlTableBackup($db, array(), __DR__."/backups/files/".$dateTime."-".$code."/", "BACKUP-MYSQL-".$code.".sql");
    $fileBackup = new FolderBackup();
    $folderBackup = $fileBackup->folder([
      'dir' => "../../",
      'file' => __DR__."/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip",
      'exclude' => ['backups']
    ]);
    array_unshift($backups, array(
      "time" => $dateTime,
      "code" => $code,
      "date" => date("d.m.Y H:i:s"),
      "directory" => "/backups/files/".$dateTime."-".$code,
      "fileDirectory" => "/backups/files/".$dateTime."-".$code."/BACKUP-FILE-".$code.".zip",
      "mysqlDirectory" => "/backups/files/".$dateTime."-".$code."/BACKUP-MYSQL-".$code.".sql",
      "creator" => $readAccount["username"]
    ));
    $write = '<?php $backups = \''.json_encode($backups).'\'; ?>';
    
    file_put_contents(__DR__."/backups/php/backups.php", $write);
  }
?>