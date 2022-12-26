<?php
AccountLoginControl(false);
$searchUserChest = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
$searchUserChest->execute(array($readAccount["id"], 0));
?>
<div class="content-grid">
  <?php include(__DR__."/main/themes/sitary/libs/content/header-box.php"); ?>
    <div class="grid grid-half mobile-prefer-content">
      <!-- CHEST -->
      <div class="grid-column">
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("buyProductTitle", "chest", $languageType); ?> (<?php echo $searchUserChest->rowCount(); ?>)</p>
          <div class="widget-box-content">
          <?php if ($searchUserChest->rowCount() > 0) { ?>
          <div class="grid grid-half mobile-prefer-content">
          <?php
            foreach ($searchUserChest as $readChest) {
              $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
              $searchProduct->execute(array($readChest["productID"]));
              if ($searchProduct->rowCount() > 0) {
                $readProduct = $searchProduct->fetch();
                $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                $searchServer->execute(array($readProduct["serverID"]));
                if ($searchServer->rowCount() > 0) {
                  $readServer = $searchServer->fetch();
          ?>
            <div class="user-preview small fixed-height-medium">
              <figure class="user-preview-cover liquid">
                <img src="<?php echo $readServer["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readServer["name"]; ?>">
              </figure>
              <div class="user-preview-info">
                <div class="user-short-description small">
                  <a class="user-short-description-avatar user-avatar no-stats">
                    <div class="user-avatar-border">
                      <div class="hexagon-100-108"></div>
                    </div>
                    <div class="user-avatar-content">
                      <div class="hexagon-image-84-92" data-src="<?php echo $readProduct["image"]; ?>"></div>
                    </div>
                  </a>
                  <p class="user-short-description-title" style="margin: 0;">
                    <a><?php echo $readProduct["name"]; ?></a>
                  </p>
                  <p class="user-short-description-text"><?php echo $readServer["name"]; ?></p>
                </div>
                <div class="user-preview-actions">
                  <p class="button primary small text-tooltip-tft" data-title="<?php echo languageVariables("check", "words", $languageType); ?>" onclick="proccessChest('<?php echo $readChest["id"]; ?>');">
                    <svg class="button-icon icon-plus">
                      <use xlink:href="#svg-plus"></use>
                    </svg>
                  </p>
                  <p class="button secondary small text-tooltip-tft" data-title="<?php echo languageVariables("sendGift", "words", $languageType); ?>" onclick="productGift('<?php echo $readChest["id"]; ?>', '<?php echo $readProduct["name"]; ?>');">
                    <svg class="button-icon icon-item">
                      <use xlink:href="#svg-item"></use>
                    </svg>
                  </p>
                </div>
              </div>
            </div>
          <?php
                }
              } else {
                $deleteChest = $db->prepare("DELETE FROM userChest WHERE productID = ?");
                $deleteChest->execute(array($readChest["productID"]));
              }
            }
          ?>
          </div>
          <?php } else { echo alert(languageVariables("alertNotProduct", "chest", $languageType), "warning", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <!-- /CHEST -->
      
      <!-- CHEC-KCHEST -->
      <div class="grid-column">
        <div class="widget-box">
        <?php
        $checkProductChest = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?");
        $checkProductChest->execute(array($readAccount["id"], 1));
        ?>
          <p class="widget-box-title"><?php echo languageVariables("checkProductTitle", "chest", $languageType); ?> (<?php echo $checkProductChest->rowCount(); ?>)</p>
          <div class="widget-box-content">
          <?php if ($checkProductChest->rowCount() > 0) { ?>
          <div class="grid grid-half mobile-prefer-content">
          <?php
            foreach ($checkProductChest as $readCheckProduct) {
              $searchCProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
              $searchCProduct->execute(array($readCheckProduct["productID"]));
              if ($searchCProduct->rowCount() > 0) {
                $readCProduct = $searchCProduct->fetch();
                $searchCServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                $searchCServer->execute(array($readCProduct["serverID"]));
                if ($searchCServer->rowCount() > 0) {
                  $readCServer = $searchCServer->fetch();
          ?>
            <div class="user-preview small fixed-height-medium">
              <figure class="user-preview-cover liquid">
                <img src="<?php echo $readCServer["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readCServer["name"]; ?>">
              </figure>
              <div class="user-preview-info">
                <div class="user-short-description small">
                  <a class="user-short-description-avatar user-avatar no-stats">
                    <div class="user-avatar-border">
                      <div class="hexagon-100-108"></div>
                    </div>
                    <div class="user-avatar-content">
                      <div class="hexagon-image-84-92" data-src="<?php echo $readCProduct["image"]; ?>"></div>
                    </div>
                  </a>
                  <p class="user-short-description-title" style="margin: 0;">
                    <a><?php echo $readCProduct["name"]; ?></a>
                  </p>
                  <p class="user-short-description-text"><?php echo $readCServer["name"]; ?></p>
                </div>
                <div class="user-preview-actions">
                  <a class="button white small" href="<?php echo urlConverter("store", $languageType)."/" . createSlug($readCServer["name"]) . "/" . createSlug($readCProduct["name"]) . "/" . $readCProduct["id"]; ?>"><?php echo languageVariables("detail", "words", $languageType); ?></a>
                </div>
              </div>
            </div>
          <?php } } } ?>
          </div>
          <?php } else { echo alert(languageVariables("alertNotHistory", "chest", $languageType), "warning", "0", "/"); } ?>
          </div>
        </div>
      </div>
      <!-- /CHECK-CHEST -->
    </div>
</div>