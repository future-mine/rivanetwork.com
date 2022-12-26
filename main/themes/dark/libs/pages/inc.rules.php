<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
		      <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("rules", "words", $languageType); ?></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-12 col-12 pb-5 pt-3">
            <div class="products bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <strong><?php echo languageVariables("rules", "words", $languageType); ?></strong>
              </h3>
              <?php echo str_replace(["[serverName]"],[$rSettings["serverName"]],$rSettings["pageRules"]); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>