<?php AccountLoginControl(false); ?>
<link rel="stylesheet" href="/main/includes/packages/layouts/inventory/css/themes/default/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<section class="py-16 relative overflow-hidden">
  <div class="container mx-auto px-4 md:px-0">
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
            <a href="<?php echo urlConverter("coupon", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("coupon", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-10 gap-16 px-4 md:px-0 mt-10">
    <div class="card lg:col-span-7 flex flex-col gap-16">
      <div class="px-6 py-8">
        <h3 class="text-gray-800 fw-bold fs-5"><?php echo languageVariables("exCoupon", "coupon", $languageType); ?></h3>
        <div class="text-gray-400 mt-4">
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
            <div class="grid">
              <label for="coupon" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("coupon", "words", $languageType); ?></label>
              <input id="coupon" type="text" name="coupon" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("coupon", "words", $languageType); ?>">
            </div>
            <?php if ($proccessStatus == "_SUCCESS_") { ?>
            <div class="mt-4 border-t-2 border-gray-200/50">
              <h3 class="text-gray-800 fw-bold fs-5 pt-4"><?php echo languageVariables("gifts", "words", $languageType); ?></h3>
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
            <?php echo $safeCsrfToken->input("exchangeCouponToken"); ?>
            <div class="mt-8 border-t-2 border-gray-200/50 pt-5 flex justify-center items-center">
              <button type="submit" name="exchangeCoupon" class="btn btn-primary"><?php echo languageVariables("cashOut", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
	<div class="lg:col-span-3 flex flex-col gap-12">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-gift !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("historyTitle", "coupon", $languageType); ?></p>
          </div>
          <div class="">
            <?php $searchCouponHistory = $db->query("SELECT * FROM couponHistory ORDER BY id DESC LIMIT 5"); ?>
            <?php if ($searchCouponHistory->rowCount() > 0) { ?>
            <div class="overflow-x-auto w-full">
              <table class="w-full text-left relative z-10">
                <thead>
                  <tr class="bg-indigo-400/25 !text-indigo-700">
                    <th class="py-4 px-3 relative z-10">#</th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("rewards", "words", $languageType); ?></th>
                    <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
                  </tr>
                </thead>
                <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
                  <?php foreach ($searchCouponHistory as $readCouponHistory) { ?>
                  <?php $searchCoupon = $db->prepare("SELECT * FROM coupon WHERE id = ?"); ?>
                  <?php $searchCoupon->execute(array($readCouponHistory["couponID"])); ?>
                  <?php $readCoupon = $searchCoupon->fetch(); ?>
                  <?php $searchCouponItem = $db->prepare("SELECT * FROM couponItem WHERE couponID = ?"); ?>
                  <?php $searchCouponItem->execute(array($readCouponHistory["couponID"])); ?>
                  <?php $couponItemRow = $searchCouponItem->rowCount(); ?>
                  <tr class="hover:bg-gray-100">
                    <td class="font-normal p-3"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readCouponHistory["username"]; ?>/28" alt="<?php echo languageVariables("coupon", "words", $languageType); ?> - <?php echo $readCouponHistory["username"]; ?>"></td>
                    <td class="font-normal p-3 w-100"><?php echo $readCouponHistory["username"]; ?></td>
                    <td class="font-normal p-3"><?php foreach($searchCouponItem as $readCouponItem) { if ($readCouponItem["type"] == "0") { if ($couponItemRow > 1) { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType)." , "; } else { echo $readCouponItem["reward"]." ".languageVariables("credi", "words", $languageType); } } else if ($readCouponItem["type"] == "1") { ?><?php $searchCouponProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?"); ?><?php $searchCouponProduct->execute(array($readCouponItem["reward"])); ?><?php $readCouponProduct = $searchCouponProduct->fetch(); ?><?php if ($couponItemRow > 2) { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType)." , "; } else { echo $readCouponProduct["name"]." ".languageVariables("product", "words", $languageType); } } } ?> <?php echo languageVariables("won", "words", $languageType); ?></td>
                    <td class="font-normal p-3"><?php echo checkTime($readCouponHistory["date"]); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } else { echo alert(languageVariables("alertNotHistory", "coupon", $languageType), "danger", "0", "/"); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>