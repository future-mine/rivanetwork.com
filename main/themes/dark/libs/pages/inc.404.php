<style type="text/css">
.container-responsive {
  align-items: center; 
  padding: 200px;
}
@media (max-width: 900px) {
  .container-responsive {
    align-items: center; 
    padding: 50px;
  }
}
</style>
<div class="container container-responsive">
  <div class="grid grid-3-6-3 mobile-prefer-content">
    <div class="error-section">
	  <div class="error-section-info"><center>
        <center><strong><p style="font-size:31px;"><?php echo languageVariables("sectionTitle", "404", $languageType); ?></p></strong></center>
        <p class="error-section-text"><?php echo languageVariables("sectionInfo", "404", $languageType); ?></p>
        <p class="error-section-text"><?php echo languageVariables("sectionText", "404", $languageType); ?></p>
        <a class="h-100 w-25 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6" href="<?php echo urlConverter("home", $languageType); ?>"><?php echo languageVariables("back", "words", $languageType); ?></a>
	  </center></div>
    </div>
  </div>
</div>