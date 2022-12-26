<?php
if (!isset($_COOKIE["help"])) {
  $updateHelpView = $db->prepare("UPDATE helpCenter SET views = views + 1");
  $updateHelpView->execute();
  setcookie("help", "view");
}
?>
<section class="container mx-auto pt-20 pb-32 px-4 md:px-0">
  <nav class="card flex" aria-label="Breadcrumb">
    <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
      <li class="flex">
        <div class="flex items-center">
          <a href="/" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-home"></i>
            <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
          </a>
        </div>
      </li>
      <li class="flex">
        <div class="flex items-center py-1">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
          </svg>
          <a href="<?php echo urlConverter("support", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("support", "words", $languageType); ?></a>
        </div>
      </li>
      <li class="flex">
        <div class="flex items-center py-1">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
          </svg>
          <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("helpCenter", "words", $languageType); ?></a>
        </div>
      </li>
    </ol>
  </nav>
  <?php $searchHelpCenterOne = $db->query("SELECT * FROM helpCenter ORDER BY id ASC LIMIT 1"); ?>
  <?php $readHelpCenterOne = $searchHelpCenterOne->fetch(); ?>
  <?php $searchHelpCenter = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
  <?php $searchHelpCenter->execute(array($readHelpCenterOne["id"])); ?>
  <?php $searchHelpCenterTwo = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
  <?php $searchHelpCenterTwo->execute(array($readHelpCenterOne["id"])); ?>
  <div class="tabs lg:grid grid-cols-10 space-y-12 lg:space-y-0 gap-12 !bg-transparent border-none mt-20" id="tabs">
    <div class="tabs-head col-span-3 !block">
      <div class="h-fit">
        <a href="<?php echo urlConverter("support", $languageType); ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
          <span><?php echo languageVariables("myTickets", "words", $languageType); ?></span>
          <i class="fas fa-arrow-right group-hover:ml-3 transition-all"></i>
        </a>
      </div>
      <div class="mt-6 overflow-hidden card !grid divide-y divide-gray-200/25 pb-8" id="tabs-help">
        <div class="py-5 px-7">
          <h4 class="h4"><?php echo languageVariables("categories", "words", $languageType); ?></h4>
        </div>
        <div href="<?php echo "#".createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="tabs-links flex items-center py-4 px-8 gap-3 fw-medium text-dark transition hover:bg-gray-100 help-center active" tab-name="tabs-help">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-indigo-400/25" style="background-color: <?php echo $readHelpCenterOne["iconBackgroundColor"]; ?>;">
            <i class="fas <?php echo $readHelpCenterOne["categoryIcon"]; ?> text-primary" style="color: <?php echo $readHelpCenterOne["iconColor"]; ?>;"></i>
          </div>
          <?php echo $readHelpCenterOne["name"]; ?>
        </div>
        <?php foreach($searchHelpCenter as $readHelpCenter) { ?>
        <div href="<?php echo "#".createSlug($readHelpCenter["name"])."-".$readHelpCenter["id"]; ?>" class="tabs-links flex items-center py-4 px-8 gap-3 fw-medium text-dark transition hover:bg-gray-100 help-center" tab-name="tabs-help">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-indigo-400/25" style="background-color: <?php echo $readHelpCenter["iconBackgroundColor"]; ?>;">
            <i class="fas <?php echo $readHelpCenter["categoryIcon"]; ?> text-primary" style="color: <?php echo $readHelpCenter["iconColor"]; ?>;"></i>
          </div>
          <?php echo $readHelpCenter["name"]; ?>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="col-span-7">
      <div class="card py-6 px-8 flex justify-between items-center">
        <div>
          <h5 class="h4 text-dark"><?php echo languageVariables("title", "helpCenter", $languageType); ?></h5>
          <p class="max-w-xl text-gray-400 mt-2"><?php echo languageVariables("info", "helpCenter", $languageType); ?></p>
        </div>
        <a href="<?php echo urlConverter("support_create", $languageType); ?>" class="btn btn-primary"><?php echo languageVariables("createTicket", "words", $languageType); ?></a>
      </div>
      <div class="mt-6 card p-6 tabs-content" tab-content-name="tabs-help">
        <div id="<?php echo createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="tabs-pane show px-4 py-3">
          <h3 class="h3 !fs-4 text-dark"><?php echo $readHelpCenterOne["title"]; ?></h3>
          <p class="text-gray-400 mt-2"><?php echo $readHelpCenterOne["description"]; ?></p>
          <div class="px-3 py-5">
          <?php $contentsOne = json_decode($readHelpCenterOne["contents"], 2); ?>
          <?php foreach($contentsOne as $readContentOne) { ?>
            <div class="mt-10">
              <h4 class="text-gray-700 fw-bold fs-6 flex items-center">
                <span class="rounded bg-primary inline-block w-3 h-3 mr-2"></span>
                <?php echo $readContentOne["title"]; ?>
              </h4>
              <div class="w-fit text-gray-500 mt-2 bg-gray-100/75 py-2 px-4 rounded-tl-none rounded-xl"><?php echo $readContentOne["content"]; ?></div>
            </div>
          <?php } ?>
          </div>
          <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterOne["id"]])) { ?>
          <div class="mt-10 text-center" helpview="<?php echo $readHelpCenterOne["id"]; ?>">
            <p><?php echo languageVariables("helpFullQuestion", "helpCenter", $languageType); ?></p>
            <div class="flex mt-4" style="justify-content: center;">
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="1" class="btn btn-success btn-sm"><?php echo languageVariables("yes", "words", $languageType); ?></button>
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="0" class="btn btn-danger btn-sm ml-2"><?php echo languageVariables("no", "words", $languageType); ?></button>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php foreach($searchHelpCenterTwo as $readHelpCenterTwo) { ?>
        <div id="<?php echo createSlug($readHelpCenterTwo["name"])."-".$readHelpCenterTwo["id"]; ?>" class="tabs-pane px-4 py-3">
          <h3 class="h3 !fs-4 text-dark"><?php echo $readHelpCenterTwo["title"]; ?></h3>
          <p class="text-gray-400 mt-2"><?php echo $readHelpCenterTwo["description"]; ?></p>
          <div class="px-3 py-5">
          <?php $contents = json_decode($readHelpCenterTwo["contents"], 2); ?>
          <?php foreach($contents as $readContent) { ?>
            <div class="mt-10">
              <h4 class="text-gray-700 fw-bold fs-6 flex items-center">
                <span class="rounded bg-primary inline-block w-3 h-3 mr-2"></span>
                <?php echo $readContent["title"]; ?>
              </h4>
              <div class="w-fit text-gray-500 mt-2 bg-gray-100/75 py-2 px-4 rounded-tl-none rounded-xl"><?php echo $readContent["content"]; ?></div>
            </div>
          <?php } ?>
          </div>
          <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterTwo["id"]])) { ?>
          <div class="mt-10 text-center" helpview="<?php echo $readHelpCenterTwo["id"]; ?>">
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
</section>