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
?>
  <div class="content-grid">
    <div class="section-header">
      <div class="section-header-info">
        <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
        <h2 class="section-title"><?php echo languageVariables("cart", "words", $languageType); ?> <span class="highlighted"><?php echo $shoppingCart->rowCount(); ?></span></h2>
      </div>
    </div>
    <div class="grid grid-9-3 small-space">
      <div class="grid-column">
        <div class="table-wrap" data-simplebar>
          <?php if ($shoppingCart->rowCount() > 0) { ?>
          <div class="table table-cart split-rows">
            <div class="table-header">
              <div class="table-header-column">
                <p class="table-header-title"><?php echo languageVariables("product", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded-left">
                <p class="table-header-title"><?php echo languageVariables("duration", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded-left">
                <p class="table-header-title"><?php echo languageVariables("count", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded-left">
                <p class="table-header-title"><?php echo languageVariables("countPrice", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded-left">
                <p class="table-header-title"><?php echo languageVariables("totalAmount", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-big-left"></div>
            </div>
            <div class="table-body same-color-rows">
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
                    }  else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                      $productDiscount = floor($readCartProducts["price"]*(100-$readModule["storeDiscount"])/100);
                      $readCartProducts["price"] = "<del style=\"color: #fe2203;\">".number_format($readCartProducts["price"],2)."</del> ".number_format($productDiscount,2);
                    } else {
                      $productDiscount = $readCartProducts["price"];
                    }
              ?>
              <div class="table-row medium">
                <div class="table-column">
                  <div class="product-preview tiny">
                    <a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServers["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readCartProductCategorys["name"]))."/".createSlug($readCartProducts["name"])."/".$readCartProducts["id"]; ?>">
                      <figure class="product-preview-image liquid">
                        <img src="<?php echo $readCartProducts["image"]; ?>" alt="<?php echo languageVariables("cart", "words", $languageType); ?> - <?php echo $readCartProducts["name"]; ?>">
                      </figure>
                    </a>
                    <div class="product-preview-info">
                      <p class="product-preview-title"><a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServers["name"])."/".(($readCartProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($readCartProductCategorys["name"]))."/".createSlug($readCartProducts["name"])."/".$readCartProducts["id"]; ?>"><?php echo $readCartProducts["name"]; ?></a></p>
                      <p class="product-preview-category digital"><a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServers["name"])."/".$readCartProductServers["id"]; ?>"><?php echo $readCartProductServers["name"]; ?></a></p>
                    </div>
                  </div>
                </div>
                <div class="table-column centered padded-left">
                  <p class="price-title"><?php if ($readCartProducts["productTime"] > 0) { echo $readCartProducts["productTime"]." Gün"; } else { echo "Sınırsız"; } ?></p>
                </div>
                <div class="table-column centered padded-left">
                  <p class="price-title"><?php echo $readShoppingCarts["productCount"]; ?></p>
                </div>
                <div class="table-column centered padded-left">
                  <p class="price-title"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readCartProducts["price"]; ?></p>
                </div>
                <div class="table-column centered padded-left">
                  <p class="price-title"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo number_format($productDiscount*$readShoppingCarts["productCount"],2); ?></p>
                </div>
                <div class="table-column padded-big-left">
                  <div class="table-action" onclick="shoppingCartDelete('<?php echo $readShoppingCarts["id"]; ?>');">
                    <svg class="icon-delete">
                      <use xlink:href="#svg-delete"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } } ?>
            </div>
          </div>
          <?php } else { echo alert(languageVariables("cartQueryAlert", "shopping-cart", $languageType), "warning", "0", "/"); } ?>
        </div>
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
        <div class="promo-line">
          <p class="promo-line-text"><?php echo languageVariables("couponTitle", "shopping-cart", $languageType); ?></p>
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
          <form class="promo-line-actions" action="" method="POST">
            <div class="form-input small active">
              <label for="promo-code"><?php echo languageVariables("coupon", "words", $languageType); ?></label>
              <input type="text" id="promo-code" name="promo-code" value="<?php echo $readCoupon["code"]; ?>" readonly>
            </div>
            <?php echo $safeCsrfToken->input("removePromoToken"); ?>
            <input type="hidden" name="remove-id" value="<?php echo $readCouponHistory["id"]; ?>">
            <button type="submit" class="button secondary" style="color: #fff;" name="removePromo"><?php echo languageVariables("remove", "words", $languageType); ?></button>
          </form>
          <?php } else { ?>
          <form class="promo-line-actions" action="" method="POST">
            <div class="form-input small <?php if (isset($_POST["promo-code"])) { echo "active"; } ?>">
              <label for="promo-code"><?php echo languageVariables("coupon", "words", $languageType); ?></label>
              <input type="text" id="promo-code" name="promo-code" value="<?php if (isset($_POST["promo-code"])) { echo post("promo-code"); } ?>">
            </div>
            <?php echo $safeCsrfToken->input("checkPromoToken"); ?>
            <button type="submit" class="button primary" style="color: #fff;" name="checkPromo"><?php echo languageVariables("check", "words", $languageType); ?></button>
          </form>
          <?php } ?>
        </div>
      </div>
      <div class="grid-column">
        <div class="sidebar-box margin-top">
          <p class="sidebar-box-title"><?php echo languageVariables("cartInfo", "words", $languageType); ?></p>
          <div class="sidebar-box-items">
            <p class="price-title big"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?></p>
            <div class="totals-line-list">
              <div class="totals-line">
                <p class="totals-line-title"><?php echo languageVariables("totalAmount", "words", $languageType); ?></p>
                <p class="price-title"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo number_format($totalPrice,2); ?></p>
              </div>
              <div class="totals-line">
                <p class="totals-line-title"><?php echo languageVariables("couponDiscount", "words", $languageType); ?></p>
                <p class="price-title" style="color: #fe2203;"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php if ($couponDiscount !== 0) { echo number_format($totalPrice-($totalPrice*$couponDiscount),2); } else { echo number_format("0",2); } ?></p>
              </div>
              <div class="totals-line">
                <p class="totals-line-title"><?php echo languageVariables("payAmount", "words", $languageType); ?></p>
                <p class="price-title"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php if ($couponDiscount !== 0) { echo number_format($totalPrice*$couponDiscount,2); } else { echo number_format($totalPrice,2); } ?></p>
              </div>
            </div>
            <?php if ($shoppingCart->rowCount() > 0) { ?>
            <a class="button primary" style="color: #fff;" onclick="shoppingCartPay('<?php if ($couponDiscount !== 0) { echo $totalPrice*$couponDiscount; } else { echo $totalPrice; } ?>');"><?php echo languageVariables("payCheck", "words", $languageType); ?></a>
            <?php } else { ?>
            <a class="button secondary" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("goStore", "words", $languageType); ?></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>