<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");
?>
  <?php if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED"): ?>
    <?php $searchServers = $db->query("SELECT * FROM serverList ORDER BY id ASC"); ?>
    <?php if (mysqlCount($searchServers) > 0): ?>
      <?php foreach ($searchServers as $readServer): ?>
        <?php
          $searchCategories = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? ORDER BY id ASC");
          $searchCategories->execute(array($readServer["id"]));
        ?>
        <?php if (mysqlCount($searchCategories) > 0): ?>
          <?php foreach ($searchCategories as $readCategory): ?>
            <?php echo "<optgroup label=\"".$readServer["name"]." - ".$readCategory["name"]."\">"; ?>
            <?php
              $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE (categoryID = ? OR categoryID = ?) ORDER BY id ASC");
              $searchProducts->execute(array($readCategory["id"], 0));
            ?>
            <?php if (mysqlCount($searchProducts) > 0): ?>
              <?php foreach ($searchProducts as $readProduct): ?>
                <?php echo "<option value=\"".$readProduct["id"]."\">".$readProduct["name"]."</option>"; ?>
              <?php endforeach; ?>
            <?php endif; ?>
            <?php echo "</optgroup>"; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <?php echo "<option value=\"0\">".languageVariables("ajaxNotServerAlert", "modules", $languageType)."</option>"; ?>
    <?php endif; ?>
  <?php endif; ?>