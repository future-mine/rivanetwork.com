<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/south/<?php echo $_SESSION["themeModeType"]; ?>/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
  <div class="grid grid-9-3 mobile-prefer-content">
      <!-- EXCHANGE COUPON  -->
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("cashOut", "words", $languageType); ?></h2>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-box-content">
            <?php
            $proccessStatus = "_UNDEFINED_";
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["exchangeCoupon"])) {
              if ($safeCsrfToken->validate('exchangeCouponToken')) {
                if (post("coupon") !== "") {
                  $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE code = ?");
                  $searchCoupon->execute(array(post("coupon")));
                  if ($searchCoupon->rowCount() > 0) {
                    $readCoupon = $searchCoupon->fetch();
                    $searchCouponHistory = $db->prepare("SELECT * FROM couponHistory WHERE username = ? AND couponID = ?");
                    $searchCouponHistory->execute(array($readAccount["username"], $readCoupon["id"]));
                    if ($searchCouponHistory->rowCount() == 0) {
                      $couponCount = $db->prepare("SELECT * FROM couponHistory WHERE couponID = ?");
                      $couponCount->execute(array($readCoupon["id"]));
                      if ($readCoupon["type"] == "0" || $readCoupon["custom"] > $couponCount->rowCount()) {
                        $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?");
                        $searchCouponItem->execute(array($readCoupon["id"]));
                        if (inventoryItemCount($readAccount["id"], $searchCouponItem->rowCount()) == true) {
                          if ($searchCouponItem->rowCount() > 0) {
                            foreach ($searchCouponItem as $readCouponItem) {
                              $reward = $readCouponItem["reward"];
                              $rewardType = $readCouponItem["type"];
                              if ($rewardType == "0") {
                                $variables = "{\"credit\": \"".$reward."\", \"image\": \"/main/includes/packages/layouts/inventory/image/credit/default.png\"}";
                                inventoryAddItem($readAccount["id"], "1", $variables, date("d.m.Y H:i:s"));
                              } else if ($rewardType == "1") {
                                $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                                $searchProduct->execute(array($reward));
                                $readProduct = $searchProduct->fetch();
                                $variables = "{\"productID\": \"".$reward."\", \"image\": \"".$readProduct["image"]."\"}";
                                inventoryAddItem($readAccount["id"], "2", $variables, date("d.m.Y H:i:s"));
                              }
                            }
                            $insertCouponHistory = $db->prepare("INSERT INTO couponHistory SET username = ?, userID = ?, couponCode = ?, couponID = ?, date = ?");
                            $insertCouponHistory->execute(array($readAccount["username"], $readAccount["id"], $readCoupon["code"], $readCoupon["id"], date("d.m.Y H:i:s")));
                            $searchCouponItems = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?");
                            $searchCouponItems->execute(array($readCoupon["id"]));
                            $proccessStatus = "_SUCCESS_";
                            echo alert(str_replace(["&coupon"], [post("coupon")], languageVariables("alertSuccess", "coupon", $languageType)), "success", "0", "/");
                          } else {
                            echo alert(languageVariables("alertNotCouponGift", "coupon", $languageType), "danger", "0", "/");
                          }
                        } else {
                          echo alert(str_replace(["&slot"], [$searchCouponItem->rowCount()], languageVariables("alertNotInvertorySlot", "coupon", $languageType)), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("alertNotCouponData", "coupon", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertAlreadyCoupon", "coupon", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertNotCouponGift", "coupon", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertNone", "coupon", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "coupon", $languageType), "danger", "0", "/");
              }
            }
            ?>
            <form action="" method="POST">
              <div class="form-row split">
                <div class="form-item">
                  <div class="form-input social-input small">
                    <div class="social-link no-hover youtube">
                      <svg class="icon-youtube">
                        <use xlink:href="#svg-item"></use>
                      </svg>
                    </div>
                    <label for="transfer-coupon"><?php echo languageVariables("coupon", "words", $languageType); ?></label>
                    <input type="text" id="transfer-coupon" name="coupon">
                  </div>
                </div>
              </div>
              <div class="form-row split">
                <div class="form-item active">
                  <?php echo $safeCsrfToken->input("exchangeCouponToken"); ?>
                  <button class="button w-25 primary" style="float:right;" type="submit" name="exchangeCoupon"><?php echo languageVariables("cashOut", "words", $languageType); ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php if ($proccessStatus == "_SUCCESS_") { ?>
        <div class="widget-box">
          <p class="widget-box-title"><?php echo languageVariables("gifts", "words", $languageType); ?></p>
          <div class="widget-box-content">
            <div class="inventory">
              <?php foreach ($searchCouponItems as $readCouponItems) { ?>
                <?php $reward = $readCouponItems["reward"]; $rewardType = $readCouponItems["type"]; ?>
                <?php if ($rewardType == "0") { ?>
                <div class="inventory-card text-tooltip-tft" data-title="<?php echo languageVariables("gift", "words", $languageType); ?> - <?php echo $reward; ?> <?php echo languageVariables("credi", "words", $languageType); ?>">
                  <div class="inventory-card-content">
                    <img src="/main/includes/packages/layouts/inventory/image/credit/default.png" alt="<?php echo languageVariables("gift", "words", $languageType); ?> - <?php echo $reward; ?> <?php echo languageVariables("credi", "words", $languageType); ?>">
                  </div>
                </div>
                <?php
                } else if ($rewardType == "1") {
                  $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                  $searchProduct->execute(array($reward));
                  $readProduct = $searchProduct->fetch();
                ?>
                <div class="inventory-card text-tooltip-tft" data-title="<?php echo languageVariables("gift", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
                  <div class="inventory-card-content">
                    <img src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("gift", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
                  </div>
                </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!-- /EXCHANGE COUPON -->
      
      <div class="grid-column">
        <div class="section-header">
          <div class="section-header-info">
            <p class="section-pretitle"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></p>
            <h2 class="section-title"><?php echo languageVariables("historyTitle", "coupon", $languageType); ?></h2>
          </div>
        </div>
        <?php $searchCouponHistory = $db->query("SELECT * FROM couponHistory ORDER BY id DESC LIMIT 6"); ?>
        <?php if ($searchCouponHistory->rowCount() > 0) { ?>
        <div class="widget-box">
          <div class="widget-box-content">
            <div class="user-status-list">
              <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
              <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
              <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
              <?php $readCoupon = $searchCoupon->fetch(); ?>
              <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
              <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
              <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
              <div class="user-status">
                <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readCouponHistory["username"]; ?>">
                	<img src="https://minotar.net/bust/<?php echo $readCouponHistory["username"]; ?>/100.png" width="40" height="40">
                </a>
                <?php $couponRewards = ""; ?>
                <?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { $couponRewards = $couponRewards.$readCouponItem["reward"]." ".languageVariables("creditAnd", "words", $languageType)." "; } else { $couponRewards = $couponRewards.$readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { $couponRewards = $couponRewards.$readCouponProduct["name"]." ".languageVariables("productAnd", "words", $languageType)." "; } else { $couponRewards = $couponRewards.$readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?></p>
                <p class="user-status-title"><?php echo str_replace(array("&username", "&rewards"), array($readCouponHistory["username"], $couponRewards), languageVariables("historyText", "coupon", $languageType)); ?></p>
                <p class="user-status-timestamp"><?php echo checkTime($readCouponHistory["date"]); ?></p>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("alertNotHistory", "coupon", $languageType), "warning", "0", "/"); } ?>
      </div>
    </div>
</div>