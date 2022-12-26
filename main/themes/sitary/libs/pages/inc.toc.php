<div class="content-grid">
    <div class="grid grid-12 mobile-prefer-content">
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("salesAgreement", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <?php echo str_replace(["[serverName]"],[$rSettings["serverName"]],$rSettings["salesAgreement"]); ?>
          </div>
        </div>
      </div>
    </div>
</div>