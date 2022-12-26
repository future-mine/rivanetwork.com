<?php
if (!isset($_COOKIE["help"])) {
  $updateHelpView = $db->prepare("UPDATE helpCenter SET views = views + 1");
  $updateHelpView->execute();
  setcookie("help", "view");
}
?>
<div class="content-grid">
  <div class="grid grid-4-8 mobile-prefer-content">
    <div class="grid-column">
      <a href="<?php echo urlConverter("support", $languageType); ?>" class="button danger"><?php echo languageVariables("myTickets", "words", $languageType); ?></a>
      <div class="widget-box tabs" style="padding: 0 !important;">
        <p class="widget-box-title" style="padding: 32px 28px 0 28px !important;"><?php echo languageVariables("categories", "words", $languageType); ?></p>
        <?php $searchHelpCenterOne = $db->query("SELECT * FROM helpCenter ORDER BY id ASC LIMIT 1"); ?>
        <?php $readHelpCenterOne = $searchHelpCenterOne->fetch(); ?>
        <?php $searchHelpCenter = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
        <?php $searchHelpCenter->execute(array($readHelpCenterOne["id"])); ?>
        <?php $searchHelpCenterTwo = $db->prepare("SELECT * FROM helpCenter WHERE id != ? ORDER BY id ASC"); ?>
        <?php $searchHelpCenterTwo->execute(array($readHelpCenterOne["id"])); ?>
        <div class="help-center" id="tabs-help">
          <div href="<?php echo "#".createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="tabs-links help-center-category active" tab-name="tabs-help"><i class="fas <?php echo $readHelpCenterOne["categoryIcon"]; ?> mr-3" style="background-color: <?php echo $readHelpCenterOne["iconBackgroundColor"]; ?>; color: <?php echo $readHelpCenterOne["iconColor"]; ?>;"></i><p><?php echo $readHelpCenterOne["name"]; ?></p></div>
          <?php foreach($searchHelpCenter as $readHelpCenter) { ?>
          <div href="<?php echo "#".createSlug($readHelpCenter["name"])."-".$readHelpCenter["id"]; ?>" class="tabs-links help-center-category" tab-name="tabs-help"><i class="fas <?php echo $readHelpCenter["categoryIcon"]; ?> mr-3" style="background-color: <?php echo $readHelpCenter["iconBackgroundColor"]; ?>; color: <?php echo $readHelpCenter["iconColor"]; ?>;"></i><p><?php echo $readHelpCenter["name"]; ?></p></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="grid-column">
      <div class="achievement-box primary">
        <div class="achievement-box-info-wrap">
          <img class="achievement-box-image" src="<?php echo $headerBoxImage; ?>" alt="<?php echo $headerBoxTitle; ?>">
          <div class="achievement-box-info">
            <p class="achievement-box-title"><?php echo languageVariables("title", "helpCenter", $languageType); ?></p>
            <p class="achievement-box-text pr-3"><?php echo languageVariables("info", "helpCenter", $languageType); ?></p>
          </div>
        </div>
        <a class="button white-solid" href="<?php echo urlConverter("support_create", $languageType); ?>" style="width: 180px;"><?php echo languageVariables("createTicket", "words", $languageType); ?></a>
      </div>
      <div class="widget-box tabs-content" tab-content-name="tabs-help">
        <div id="<?php echo createSlug($readHelpCenterOne["name"])."-".$readHelpCenterOne["id"]; ?>" class="tabs-pane show">
          <p class="widget-box-title"><?php echo $readHelpCenterOne["title"]; ?></p>
          <p class="widget-box-title mt-2" style="font-size: 14px !important; font-weight: 400;"><?php echo $readHelpCenterOne["description"]; ?></p>
          <div class="widget-box-content">
          <?php $contentsOne = json_decode($readHelpCenterOne["contents"], 2); ?>
          <?php foreach($contentsOne as $readContentOne) { ?>
            <p style="margin-top: 1rem; font-size: 18px !important; font-weight: 500;"><span style="background: var(--danger); width: 1.3rem; height: 1.3rem; margin-right: .6rem; display: inline-block; border-radius: 5px;"></span><?php echo $readContentOne["title"]; ?></p>
            <div class="chat-widget-speaker-message mt-3 ml-4"><?php echo $readContentOne["content"]; ?></div>
          <?php } ?>
          <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterOne["id"]])) { ?>
          <div class="text-center" style="margin-top: 3rem;" helpview="<?php echo $readHelpCenterOne["id"]; ?>">
            <p><?php echo languageVariables("helpFullQuestion", "helpCenter", $languageType); ?></p>
            <div class="mt-4" style="display: flex; flex-direction: row; justify-content: center;">
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="1" class="button success btn-sm"><?php echo languageVariables("yes", "words", $languageType); ?></button>
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterOne["id"]; ?>" status="0" class="button danger btn-sm ml-2"><?php echo languageVariables("no", "words", $languageType); ?></button>
            </div>
          </div>
          <?php } ?>
          </div>
        </div>
        <?php foreach($searchHelpCenterTwo as $readHelpCenterTwo) { ?>
        <div id="<?php echo createSlug($readHelpCenterTwo["name"])."-".$readHelpCenterTwo["id"]; ?>" class="tabs-pane" style="display: none;">
          <p class="widget-box-title"><?php echo $readHelpCenterTwo["title"]; ?></p>
          <p class="widget-box-title mt-2" style="font-size: 14px !important; font-weight: 400;"><?php echo $readHelpCenterTwo["description"]; ?></p>
          <div class="widget-box-content">
          <?php $contents = json_decode($readHelpCenterTwo["contents"], 2); ?>
          <?php foreach($contents as $readContent) { ?>
            <p style="margin-top: 1rem; font-size: 18px !important; font-weight: 500;"><span style="background: var(--danger); width: 1.3rem; height: 1.3rem; margin-right: .6rem; display: inline-block; border-radius: 5px;"></span><?php echo $readContent["title"]; ?></p>
            <div class="chat-widget-speaker-message mt-3 ml-4"><?php echo $readContent["content"]; ?></div>
          <?php } ?>
          <?php if (!isset($_COOKIE["helpVote-".$readHelpCenterTwo["id"]])) { ?>
          <div class="text-center" style="margin-top: 3rem;" helpview="<?php echo $readHelpCenterTwo["id"]; ?>">
            <p><?php echo languageVariables("helpFullQuestion", "helpCenter", $languageType); ?></p>
            <div class="mt-4" style="display: flex; flex-direction: row; justify-content: center;">
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterTwo["id"]; ?>" status="1" class="button success"><?php echo languageVariables("yes", "words", $languageType); ?></button>
              <button type="button" data-toggle="help-center" helpID="<?php echo $readHelpCenterTwo["id"]; ?>" status="0" class="button danger ml-2"><?php echo languageVariables("no", "words", $languageType); ?></button>
            </div>
          </div>
          <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>