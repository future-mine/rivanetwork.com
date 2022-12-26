<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-12 mobile-prefer-content">
      <!-- PRIVACY -->
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo $rSettings["serverName"]; ?> <?php echo languageVariables("privacy", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <?php echo str_replace(["[serverName]"],[$rSettings["serverName"]],$rSettings["pagePrivacy"]); ?>
          </div>
        </div>
      </div>
      <!-- /PRIVACY -->
    </div>
</div>