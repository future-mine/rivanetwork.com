<?php if (AccountPermControl($readAccount["id"], "updates") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_updates", $languageType); ?>"><?php echo languageVariables("updates", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("update", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12">
      <div data-toggle="update-lists">
        <div class="card">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col">
                <div class="row align-items-center">
                  <div class="col-auto pr-0">
                    <span class="fas fa-search"></span>
                  </div>
                  <div class="col">
                    <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body p-5">
            <div class="table-responsive">
              <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="sr-only"><?php echo languageVariables("loading", "words", $languageType); ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>