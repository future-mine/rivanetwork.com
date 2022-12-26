<?php
  if ($rSettings["maintanceStatus"] == "0") {
    go("/anasayfa");
  }
?>
<div class="content-grid">
  <div class="grid grid-12 mobile-prefer-content">
    <div class="err-section">
      <p class="err-section-title"><?php echo languageVariables("sectionTitle", "maintance", $languageType); ?></p>
      <p class="err-section-text"><?php echo languageVariables("sectionInfo", "maintance", $languageType); ?></p>
      <p class="err-section-text"><?php echo languageVariables("sectionText", "maintance", $languageType); ?></p>
      <a class="button medium primary w-50" href="<?php echo urlConverter("login", $languageType); ?>"><?php echo languageVariables("login", "words", $languageType); ?></a>
    </div>
  </div>
</div>