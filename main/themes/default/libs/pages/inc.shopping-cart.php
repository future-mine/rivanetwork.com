<?php
AccountLoginControl(false);
$shoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ? ORDER BY id ASC");
$shoppingCart->execute(array($readAccount["id"]));
$searchCouponHistory = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND status = ?");
$searchCouponHistory->execute(array($readAccount["id"], 0));
if ($shoppingCart->rowCount() > 0) {
  if ($searchCouponHistory->rowCount() > 0) {
    $readCouponHistory = $searchCouponHistory->fetch();
    $searchCoupon = $db->prepare("SELECT * FROM discountCoupon WHERE id = ? AND type = ?");
    $searchCoupon->execute(array($readCouponHistory["couponID"], 1));
    if ($searchCoupon->rowCount() > 0) {
      $readCoupon = $searchCoupon->fetch();
      $couponDiscount = (100-$readCoupon["discount"])/100;
    } else {
      $couponDiscount = 0;
    }
  } else {
    $couponDiscount = 0;
  }
} else {
  $couponDiscount = 0;
}
$totalPrice = 0;
?>
<section class="py-16 container mx-auto px-4 md:px-0 overflow-hidden relative lg:overflow-visible">
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
          <a href="<?php echo urlConverter("store", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("store", "words", $languageType); ?></a>
        </div>
      </li>
      <li class="flex">
        <div class="flex items-center py-1">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
          </svg>
          <a href="javascript:void(0)" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("cart", "words", $languageType); ?></a>
        </div>
      </li>
    </ol>
  </nav>
  <div class="mt-20">
    <div class="mt-12 grid lg:grid-cols-12 gap-12 space-y-12 lg:space-y-0">
      <div class="lg:col-span-8" style="overflow-y: auto;">
      <?php if ($shoppingCart->rowCount() > 0) { ?>
        <div style="min-width: 710px;">
          <div class="grid grid-cols-12 text-gray-600 uppercase fw-bold fs-7">
            <div class="col-span-3 px-4"><?php echo languageVariables("product", "words", $languageType); ?></div>
            <div class="col-span-2"><?php echo languageVariables("duration", "words", $languageType); ?></div>
            <div class="col-span-1"><?php echo languageVariables("count", "words", $languageType); ?></div>
            <div class="col-span-3"><?php echo languageVariables("countPrice", "words", $languageType); ?></div>
            <div class="col-span-2"><?php echo languageVariables("totalAmount", "words", $languageType); ?></div>
            <div class="col-span-1"></div>
          </div>
          <div class="space-y-4 mt-4">
            <?php
            foreach ($shoppingCart as $readShoppingCarts) {
              $cartProducts = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
              $cartProducts->execute(array($readShoppingCarts["productID"]));
              if ($cartProducts->rowCount() > 0) {
                $readCartProducts = $cartProducts->fetch();
                $cartProductServers = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                $cartProductServers->execute(array($readCartProducts["serverID"]));
                $readCartProductServers = $cartProductServers->fetch();
                $cartProductCategorys = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                $cartProductCategorys->execute(array($readCartProducts["categoryID"]));
                $readCartProductCategorys = $cartProductCategorys->fetch();
                if ($readCartProducts["productType"] == 1 && $readCartProducts["productDiscount"] > 0) {
                  $productDiscount = floor($readCartProducts["price"]*(100-$readCartProducts["productDiscount"])/100);
                  $readCartProducts["price"] = "<del style=\"color: #fe2203;\">".number_format($readCartProducts["price"],2)."</del> ".number_format($productDiscount,2);
                  $readCartProductsSafePrice = number_format($productDiscount,2);
                }  else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                  $productDiscount = floor($readCartProducts["price"]*(100-$readModule["storeDiscount"])/100);
                  $readCartProducts["price"] = "<del style=\"color: #fe2203;\">".number_format($readCartProducts["price"],2)."</del> ".number_format($productDiscount,2);
                  $readCartProductsSafePrice = number_format($productDiscount,2);
                } else {
                  $productDiscount = $readCartProducts["price"];
                  $readCartProductsSafePrice = number_format($productDiscount,2);
                }
            ?>
            <div class="grid grid-cols-12 card p-4 items-center text-dark">
              <div class="col-span-3 flex gap-3 px-4">
                <img class="w-16 h-fit" src="<?php echo $readCartProducts["image"]; ?>" alt="<?php echo languageVariables("cart", "words", $languageType); ?> - <?php echo $readCartProducts["name"]; ?>">
                <div class="flex flex-col justify-center">
                  <dt class="fw-medium text-dark"><?php echo $readCartProducts["name"]; ?></dt>
                  <span class="text-gray-400"><?php echo $readCartProductServers["name"]; ?></span>
                </div>
              </div>
              <div class="col-span-2"><?php if ($readCartProducts["productTime"] > 0) { echo $readCartProducts["productTime"]." Gün"; } else { echo "Sınırsız"; } ?></div>
              <div class="col-span-1"><?php echo $readShoppingCarts["productCount"]; ?></div>
              <div class="col-span-3"><?php echo languageVariables("currencyIcon", "words", $languageType); ?> <?php echo $readCartProducts["price"]; ?></div>
              <div class="col-span-2"><?php echo languageVariables("currencyIcon", "words", $languageType); ?> <?php echo number_format($productDiscount*$readShoppingCarts["productCount"],2); ?></div>
              <div class="col-span-1 flex items-center justify-center" onclick="shoppingCartDelete('<?php echo $readShoppingCarts["id"]; ?>');">
                <a class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
              </div>
            </div>
            <?php $totalPrice = $totalPrice + ($readCartProductsSafePrice*$readShoppingCarts["productCount"]); ?>
            <?php } } ?>
          </div>
        </div>
        <?php } else { echo alert(languageVariables("cartQueryAlert", "shopping-cart", $languageType), "danger", "0", "/"); } ?>
      </div>
      <div class="lg:col-span-4">
        <h4 class="h4 text-gray-900"><?php echo languageVariables("cartInfo", "words", $languageType); ?></h4>
        <div class="card mt-4">
          <div class="rounded-2xl flex items-center justify-center bg-indigo-500/25 w-14 h-14 absolute -top-5 -right-5">
            <i class="fas fa-basket-shopping text-primary fs-5"></i>
          </div>
          <div class="p-6">
            <div class="rounded-xl max-w-xs mx-auto py-3 px-6 bg-indigo-400/10 text-primary gap-3 flex justify-center items-center">
              <p class="fw-extrabold fs-1"><?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?></p>
              <span class="fs-3 text-indigo-400"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span>
            </div>
          </div>
          <div class="p-4 mb-10 bg-gray-100/25 border-t border-gray-100/25 space-y-4">
            <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
              <?php echo languageVariables("totalAmount", "words", $languageType); ?>
              <span class="fs-5 fw-bold text-gray-800"><?php echo languageVariables("currencyIcon", "words", $languageType); ?><?php echo number_format($totalPrice,2); ?></span>
            </div>
            <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
              <?php echo languageVariables("couponDiscount", "words", $languageType); ?>
              <span class="fs-7 rounded-lg bg-red-400/10 py-1 px-3 text-red-500"><?php echo languageVariables("currencyIcon", "words", $languageType); ?><?php if ($couponDiscount !== 0) { echo number_format($totalPrice-($totalPrice*$couponDiscount),2); } else { echo number_format("0",2); } ?></span>
            </div>
            <div class="fs-6 text-gray-600 flex justify-between items-center px-2 fw-medium">
              <?php echo languageVariables("payAmount", "words", $languageType); ?>
              <span class="fs-7 rounded-lg bg-emerald-400/10 py-1 px-3 text-emerald-500"><?php echo languageVariables("currencyIcon", "words", $languageType); ?><?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?></span>
            </div>
          </div>
          <div class="p-6">
            <?php if ($shoppingCart->rowCount() > 0) { ?>
            <a class="btn btn-primary w-full text-center" onclick="shoppingCartPay('<?php if ($couponDiscount !== 0) { echo $totalPrice*$couponDiscount; } else { echo $totalPrice; } ?>');"><?php echo languageVariables("payCheck", "words", $languageType); ?></a>
            <?php } else { ?>
              <a class="btn btn-primary w-full text-center" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("goStore", "words", $languageType); ?></a>
            <?php } ?>
          </div>
        </div>

        <div class="mt-12">
          <h4 class="h4 text-gray-900"><?php echo languageVariables("coupon", "words", $languageType); ?></h4>
          <div class="card mt-4 p-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-500/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-sun text-primary fs-5"></i>
            </div>
            <p class="mt-2 text-gray-400 mb-2"><?php echo languageVariables("couponTitle", "shopping-cart", $languageType); ?></p>
            <?php
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            if (isset($_POST["checkPromo"])) {
              if ($safeCsrfToken->validate('checkPromoToken')) {
                if (post("promo-code") !== "") {
                  $searchCoupons = $db->prepare("SELECT * FROM discountCoupon WHERE code = ? AND type = ?");
                  $searchCoupons->execute(array(post("promo-code"), 1));
                  if ($searchCoupons->rowCount() > 0) {
                    $readCoupons = $searchCoupons->fetch();
                    $searchCouponHistorys = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND couponID = ?");
                    $searchCouponHistorys->execute(array($readAccount["id"], $readCoupons["id"]));
                    if ($searchCouponHistorys->rowCount() == 0) {
                      $couponCount = $db->prepare("SELECT * FROM discountCouponHistory WHERE couponID = ?");
                      $couponCount->execute(array($readCoupons["id"]));
                      if ($readCoupons["couponCount"] > $couponCount->rowCount() || $readCoupons["couponCount"] == "0-0-0-0") {
                        if ($shoppingCart->rowCount() > 0) {
                          $insertCouponHistory = $db->prepare("INSERT INTO discountCouponHistory SET userID = ?, couponID = ?, status = ?, date = ?");
                          $insertCouponHistory->execute(array($readAccount["id"], $readCoupons["id"], 0, date("d.m.Y H:i:s")));
                          echo alert(str_replace(["&coupon", "&discount"], [post("promo-code"), $readCoupons["discount"]], languageVariables("couponAlertSuccess", "shopping-cart", $languageType)), "success", "2", "");
                        } else {
                          echo alert(languageVariables("couponAlertNotProduct", "shopping-cart", $languageType), "danger", "0", "/");
                        }
                      } else {
                        echo alert(languageVariables("couponAlertNotCount", "shopping-cart", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("couponAlertAlready", "shopping-cart", $languageType), "danger", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("couponAlertNotCart", "shopping-cart", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("couponAlertNone", "shopping-cart", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("couponAlertSystem", "shopping-cart", $languageType), "danger", "0", "/");
              }
            } else if (isset($_POST["removePromo"])) {
              if ($safeCsrfToken->validate('removePromoToken')) {
                if (post("remove-id") !== "") {
                  $searchCouponHistorys = $db->prepare("SELECT * FROM discountCouponHistory WHERE userID = ? AND id = ? AND status = ?");
                  $searchCouponHistorys->execute(array($readAccount["id"], post("remove-id"), 0));
                  if ($searchCouponHistorys->rowCount() > 0) {
                    $deletePromo = $db->prepare("DELETE FROM discountCouponHistory WHERE userID = ? AND id = ? AND status = ?");
                    $deletePromo->execute(array($readAccount["id"], post("remove-id"), 0));
                    echo alert(str_replace("&coupon", post("promo-code"), languageVariables("couponAlertRemove", "shopping-cart", $languageType)), "success", "2", "");
                  } else {
                    echo alert(languageVariables("couponAlertNotCoupon", "shopping-cart", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("couponAlertNotCoupon", "shopping-cart", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("couponAlertSystem", "shopping-cart", $languageType), "danger", "0", "/");
              }
            }
            ?>
            <?php
            if ($shoppingCart->rowCount() > 0) {
              if ($searchCouponHistory->rowCount() > 0) {
                if ($searchCoupon->rowCount() > 0) {
                  $promoStatus = "_TRUE_";
                } else {
                  $promoStatus = "_FALSE_";
                }
              } else {
                $promoStatus = "_FALSE_";
              }
            } else {
              $promoStatus = "_FALSE_";
            }
            ?>
            <?php if ($promoStatus == "_TRUE_") { ?>
            <form action="" method="POST" class="flex gap-3 mt-10">
              <input type="text" name="promo-code" class="grow form-control !py-2" value="<?php echo $readCoupon["code"]; ?>" readonly>
              <input type="hidden" name="remove-id" value="<?php echo $readCouponHistory["id"]; ?>">
              <?php echo $safeCsrfToken->input("removePromoToken"); ?>
              <button type="submit" class="btn btn-danger !px-3" name="removePromo"><?php echo languageVariables("remove", "words", $languageType); ?></button>
            </form>
            <?php } else { ?>
            <form action="" method="POST" class="flex gap-3 mt-10">
              <input type="text" class="grow form-control !py-2" name="promo-code">
              <?php echo $safeCsrfToken->input("checkPromoToken"); ?>
              <button type="submit" class="btn btn-success !px-3" name="checkPromo"><?php echo languageVariables("check", "words", $languageType); ?></button>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>