<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/dark/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <nav aria-label="breadcrumb" class="pt-lg-5 pt-4">
              <ol class="breadcrumb rounded-none bg-dark--5 font-size-6">
                <li class="breadcrumb-item"><a href="<?php echo urlConverter("home", $languageType); ?>" class="text-white font-100"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
                <li class="breadcrumb-item active"><a class="text-white font-100"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-8 col-12 pb-5 pt-3">
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
            <form method="post">
              <div class="bg-dark--3 p-5">
                <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                  <?php echo languageVariables("exCoupon", "coupon", $languageType); ?>
                </h3>
                <div class="input-group mb-3 flex-column bg-dark--5 border col-12 p-0 placeholder">
                  <label for="name" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute"><i class="fas fa-user fa-xs mr-1"></i><?php echo languageVariables("coupon", "words", $languageType); ?></label>
                  <input type="text" placeholder="<?php echo languageVariables("coupon", "words", $languageType); ?>" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="<?php echo languageVariables("coupon", "words", $languageType); ?>" id="name" aria-describedby="name" name="coupon">
                </div>
                <?php echo $safeCsrfToken->input("exchangeCouponToken"); ?>
                <button type="submit" name="exchangeCoupon" class="btn float-right text-white col-12 m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                  <span class="btn-text">
                    <?php echo languageVariables("cashOut", "words", $languageType); ?>
                  </span>
                </button>
              </div>
            </form>
            <?php if ($proccessStatus == "_SUCCESS_") { ?>
            <div class="bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <?php echo languageVariables("gifts", "words", $languageType); ?>
              </h3>
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
                  <div class="inventory-card text-tooltip-tft" data-title="<?php echo languageVariables("gifts", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
                    <div class="inventory-card-content">
                      <img src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("gifts", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?>">
                    </div>
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="col-lg-4 col-12 py-3">
            <div id="sidebar-wrapper">
              <?php $searchCouponHistory = $db->query("SELECT * FROM couponHistory ORDER BY id DESC LIMIT 5"); ?>
              <?php if ($searchCouponHistory->rowCount() > 0) { ?>
              <div class="card-header font-size-7 line-height-1  text-lowercase font-100 text-secondary text-center w-50 mb-4 mx-auto">
                <?php echo languageVariables("historyTitle", "coupon", $languageType); ?>
              </div>
              <div class="card-wrapper w-100 mx-auto mt-5 row">
                <!-- CARD -->
                <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
                <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
                <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
                <?php $readCoupon = $searchCoupon->fetch(); ?>
                <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
                <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
                <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
                <div class="col-12 p-1">
                  <div class="card text-white card-leaderboard pt-5">
                    <div class="card-body bg-dark--2 p-0 pt-5 d-flex flex-column font-100">
                      <div class="mc-skin position-absolute mb-4 center">
                        <div class="mc-skin-img-wrapper mx-auto js-mirror">
                          <div class="mc-skin-img">
                            <img src="https://minotar.net/body/<?php echo $readCouponHistory["username"]; ?>/100.png" alt="<?php echo $readCouponHistory["username"]; ?>">
                          </div>
                        </div>
                      </div>
                      <h5 class="card-title pt-4 text-center font-100 mb-0"><?php echo $readCouponHistory["username"]; ?></h5>
                      <p class="card-text font-size-7 text-center mt-n1 mb-3 text-secondary" style="padding-left: 5px; padding-right:5px; padding-top:5px;">
                        <?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType)." , "; } else { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType)." , "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?> <?php echo languageVariables("won", "words", $languageType); ?></p>
                      <div class="details font-size-6 d-flex justify-content-between bg-dark--3 px-3 py-2">
                        <div class="date text-secondary">
                          <?php echo checkTime($readCouponHistory["date"]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }?>
                <!-- / CARD -->
              </div>
              <?php }else{ ?>
              <?php echo alert(languageVariables("alertNotHistory", "coupon", $languageType), "warning", "0", "/"); ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>