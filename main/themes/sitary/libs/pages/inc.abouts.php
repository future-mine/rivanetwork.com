<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-12 mobile-prefer-content">
      <!-- ABOUT US -->
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("abouts", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <?php echo str_replace(["[serverName]"],[$rSettings["serverName"]],$rSettings["pageAbouts"]); ?>
          </div>
        </div>
      </div>
      <!-- /ABOUT US -->
    </div>
</div>