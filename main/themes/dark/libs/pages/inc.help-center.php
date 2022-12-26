<?php
if (!isset($_COOKIE["help"])) {
  $updateHelpView = $db->prepare("UPDATE helpCenter SET views = views + 1");
  $updateHelpView->execute();
  setcookie("help", "view");
}
?>
<section class="section page-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
          <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
            <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("helpCenter", "words", $languageType); ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <?php $searchHelpCenterOne = $db->query("SELECT * FROM helpCenter ORDER BY id ASC LIMIT 1"); ?>
    <?php $readHelpCenterOne = $searchHelpCenterOne->fetch(); ?>
    <?php $searchHelpCenter = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
    <?php $searchHelpCenter->execute(array($readHelpCenterOne["id"])); ?>
    <?php $searchHelpCenterTwo = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
    <?php $searchHelpCenterTwo->execute(array($readHelpCenterOne["id"])); ?>
    <div class="row tabsm">
      <div class="col-lg-4 col-12 py-3">
        <a href="<?php echo urlConverter("support", $languageType); ?>" class="btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary w-100">
          <i class="fas fa-life-ring fa-sm mr-2 btn-icon"></i>
          <span class="btn-text"><?php echo languageVariables("myTickets", "words", $languageType); ?></span>
        </a>
        <div id="sidebar-wrapper" class="mt-3">
          <div class="sidebar bg-dark--3 p-5 mb-4">
            <h2 class="text-white font-size-9 col-12 p-0 mb-3">
              <span class="font-800"><?php echo languageVariables("categories", "words", $languageType); ?></span>
            </h2>
            <ul class="navbar-nav sidebar-nav" id="tabs-help">
              <li href="<?php echo "#".createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="nav-item bg-dark--2 mb-1" tab-name="tabs-help">
                <div class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                  <span class="nav-link-text"><i class="fas <?php echo $readHelpCenterOne["categoryIcon"]; ?> mr-2"></i> <?php echo $readHelpCenterOne["name"]; ?> </span>
                </div>
              </li>
              <?php foreach($searchHelpCenter as $readHelpCenter) { ?>
              <li href="<?php echo "#".createSlug($readHelpCenter["name"])."-".$readHelpCenter["id"]; ?>" class="tabsm-links nav-item bg-dark--2 mb-1" tab-name="tabs-help">
                <div class="nav-link p-3 px-4 font-100 text-white d-flex align-items-center justify-content-between w-100">
                  <span class="nav-link-text"><i class="fas <?php echo $readHelpCenter["categoryIcon"]; ?> mr-2"></i> <?php echo $readHelpCenter["name"]; ?> </span>
                </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8 col-12 pt-3 pb-5">
        <div class="card py-6 px-8 flex justify-between items-center bg-dark--3" style="flex-direction: row;border-radius: 20px;padding: 2rem;">
          <div>
            <h5 class="h4 text-gray"><?php echo languageVariables("title", "helpCenter", $languageType); ?></h5>
            <p class="max-w-xl text-gray-400 mt-2 pr-3"><?php echo languageVariables("info", "helpCenter", $languageType); ?></p>
          </div>
          <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="btn btn-primary"><?php echo languageVariables("createTicket", "words", $languageType); ?></a>
        </div>
        <div class="bg-dark--3 p-5 mt-5" tab-content-name="tabs-help">
          <div id="<?php echo createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="tabsm-pane">
          <h3 class="text-secondary mb-0 font-800 font-size-8 letter-spacing-1 text-uppercase"><?php echo $readHelpCenterOne["title"]; ?></h3>
          <h3 class="text-secondary mb-0 font-100 font-size-6 letter-spacing-1"><?php echo $readHelpCenterOne["description"]; ?></h3>
            <?php $contentsOne = json_decode($readHelpCenterOne["contents"], 2); ?>
            <?php foreach($contentsOne as $readContentOne) { ?>
            <div class="blog-body text-white font-size-8 font-800 bg-dark--3 mt-4">
              <div class="block text-secondary no-margin-paragraph">
              <?php echo $readContentOne["content"]; ?>
              </div>
            </div>
            <div class="blog-header bg-dark--5 p-3 d-flex align-items-sm-end justify-content-sm-start justify-content-end flex-sm-row flex-column" style="height: max-content !important; border-radius: 0 15px 15px 15px;">
              <div class="blog-header-text">
                <div class="blog-header-title text-white row p-0 m-0">
                  <h1 class="p-0 m-0 font-size-7 col-12 p-0 m-0 d-flex font-100">
                    <span class="text-white ml-3"><?php echo $readContentOne["title"]; ?></span>
                  </h1>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterOne["id"]])) { ?>
            <div class="mt-5 text-center" helpview="<?php echo $readHelpCenterOne["id"]; ?>">
              <p><?php echo languageVariables("helpFullQuestion", "helpCenter", $languageType); ?></p>
              <div class="flex mt-4" style="justify-content: center;">
                <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="1" class="btn btn-success btn-sm"><?php echo languageVariables("yes", "words", $languageType); ?></button>
                <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="0" class="btn btn-danger btn-sm ml-2"><?php echo languageVariables("no", "words", $languageType); ?></button>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php foreach($searchHelpCenterTwo as $readHelpCenterTwo) { ?>
          <div id="<?php echo createSlug($readHelpCenterTwo["name"])."-".$readHelpCenterTwo["id"]; ?>" class="tabsm-pane" style="display: none;">
          <h3 class="text-secondary mb-0 font-800 font-size-8 letter-spacing-1 text-uppercase"><?php echo $readHelpCenterTwo["title"]; ?></h3>
          <h3 class="text-secondary mb-0 font-100 font-size-6 letter-spacing-1"><?php echo $readHelpCenterTwo["description"]; ?></h3>
            <?php $contents = json_decode($readHelpCenterTwo["contents"], 2); ?>
            <?php foreach($contents as $readContent) { ?>
            <div class="blog-body text-white font-size-8 font-800 bg-dark--3 mt-4">
              <div class="block text-secondary no-margin-paragraph">
              <?php echo $readContent["content"]; ?>
              </div>
            </div>
            <div class="blog-header bg-dark--5 p-3 d-flex align-items-sm-end justify-content-sm-start justify-content-end flex-sm-row flex-column" style="height: max-content !important; border-radius: 0 15px 15px 15px;">
              <div class="blog-header-text">
                <div class="blog-header-title text-white row p-0 m-0">
                  <h1 class="p-0 m-0 font-size-7 col-12 p-0 m-0 d-flex font-100">
                    <span class="text-white ml-3"><?php echo $readContent["title"]; ?></span>
                  </h1>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterTwo["id"]])) { ?>
            <div class="mt-5 text-center" helpview="<?php echo $readHelpCenterTwo["id"]; ?>">
              <p><?php echo languageVariables("helpFullQuestion", "helpCenter", $languageType); ?></p>
              <div class="flex mt-4" style="justify-content: center;">
                <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterTwo["id"]; ?>" status="1" class="btn btn-success btn-sm"><?php echo languageVariables("yes", "words", $languageType); ?></button>
                <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterTwo["id"]; ?>" status="0" class="btn btn-danger btn-sm ml-2"><?php echo languageVariables("no", "words", $languageType); ?></button>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>