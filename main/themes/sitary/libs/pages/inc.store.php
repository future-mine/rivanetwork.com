<link rel="stylesheet" href="/main/includes/packages/layouts/store/css/themes/sitary/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<?php if (isset($_GET["productID"])) { ?>
<?php
$searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ? AND (status = ? OR status = ?)");
$searchProduct->execute(array(get("productID"), 1, 2));
if ($searchProduct->rowCount() > 0) {
  $readProduct = $searchProduct->fetch();
  $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ? AND (status = ? OR status = ?)");
  $searchCategory->execute(array($readProduct["categoryID"], 1, 2));
  if ($searchCategory->rowCount() > 0 || $readProduct["categoryID"] == "0") {
    $readCategory = $searchCategory->fetch();
    $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
    $searchServer->execute(array($readProduct["serverID"], 1, 2));
    if ($searchServer->rowCount() > 0) {
      $readServer = $searchServer->fetch();
      $countProductSales = $db->prepare("SELECT * FROM storeHistory WHERE productID = ?");
      $countProductSales->execute(array($readProduct["id"]));
      $countProductRates = $db->prepare("SELECT * FROM productRates WHERE productID = ?");
      $countProductRates->execute(array($readProduct["id"]));
      $searchProductPosters = $db->prepare("SELECT * FROM productPosters WHERE productID = ? ORDER BY id ASC");
      $searchProductPosters->execute(array($readProduct["id"]));
      $searchProductPostersTwo = $db->prepare("SELECT * FROM productPosters WHERE productID = ? ORDER BY id ASC");
      $searchProductPostersTwo->execute(array($readProduct["id"]));
      if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
        $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
        $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
      }
?>
<div class="content-grid">
  <div class="section-header">
    <div class="section-header-info">
      <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
      <h2 class="section-title"><?php echo $readProduct["name"]; ?></h2>
    </div>
    <div class="section-header-actions">
      <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
      <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
      <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo (($readProduct["categoryID"] == "0") ? createSlug($readServer["name"])."/".$readServer["id"] : createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]); ?>"><?php echo (($readProduct["categoryID"] == "0") ? languageVariables("notCategory", "words", $languageType) : $readCategory["name"]); ?></a>
      <p class="section-header-subsection"><?php echo $readProduct["name"]; ?></p>
    </div>
  </div>
  <div class="grid grid-9-3">
    <div class="marketplace-content grid-column">
      <?php if ($readProduct["posters"] == 1 && $searchProductPosters->rowCount() > 0) { ?>
      <div class="slider-panel">
        <div id="product-box-slider-items" class="slider-panel-slides">
          <?php foreach ($searchProductPosters as $productPoster) { ?>
          <div class="slider-panel-slide">
            <figure class="slider-panel-slide-image liquid">
              <img src="<?php echo $productPoster["image"]; ?>" alt="<?php echo languageVariables("send", "words", $languageType); ?> - <?php echo languageVariables("productPoster", "words", $languageType); ?>">
            </figure>
          </div>
          <?php } ?>
        </div>
        <div class="slider-panel-roster">
          <div id="product-box-slider-controls" class="slider-controls">
            <div class="slider-control left">
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
            <div class="slider-control right">
              <svg class="slider-control-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
          </div>
          <div id="product-box-slider-roster" class="roster-pictures">
            <?php foreach ($searchProductPostersTwo as $productPosters) { ?>
            <div class="roster-picture">
              <figure class="roster-picture-image liquid">
                <img src="<?php echo $productPosters["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo languageVariables("productPoster", "words", $languageType); ?>">
              </figure>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="tab-box">
        <div class="tab-box-options">
          <div class="tab-box-option">
            <p class="tab-box-option-title"><?php echo languageVariables("productDesc", "store", $languageType); ?></p>
          </div>
        </div>
        <div class="tab-box-items">
          <div class="tab-box-item">
            <div class="tab-box-item-content">
              <p class="tab-box-item-paragraph"><?php echo $readProduct["text"]; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="marketplace-sidebar">
      <div class="sidebar-box">
        <div class="sidebar-box-items">
          <p class="price-title big"><span class="currency"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProduct["price"]; ?></p>
          <div class="row">
            <div class="col-sm-4">
              <p class="button secondary small text-tooltip-tft" data-title="<?php echo languageVariables("shoppingCartAdd", "words", $languageType); ?>" onclick="store('addCart', '<?php echo $readProduct["id"]; ?>');">
                <svg class="button-icon icon-marketplace">
                  <use xlink:href="#svg-marketplace"></use>
                </svg>
              </p>
            </div>
            <div class="col-sm-4">
              <p class="button dark small text-tooltip-tft" data-title="<?php echo languageVariables("buy", "words", $languageType); ?>" onclick="store('directBuy', '<?php echo $readProduct["id"]; ?>');">
                <svg class="button-icon icon-store">
                  <use xlink:href="#svg-store"></use>
                </svg>
              </p>
            </div>
            <div class="col-sm-4">
              <p class="button primary small text-tooltip-tft" data-title="<?php echo languageVariables("starAdd", "words", $languageType); ?>" onclick="store('starVote', '<?php echo $readProduct["id"]; ?>');">
                <svg class="button-icon icon-store">
                  <use xlink:href="#svg-star"></use>
                </svg>
              </p>
            </div>
          </div>
          <br>
          <div class="user-stats">
            <div class="user-stat big">
              <p class="user-stat-title"><?php echo $countProductSales->rowCount(); ?></p>
              <p class="user-stat-text"><?php echo languageVariables("sales", "words", $languageType); ?></p>
            </div>
            <div class="user-stat big">
              <p class="user-stat-title"><?php echo $countProductRates->rowCount(); ?></p>
              <div class="rating-list">
                <div class="rating filled">
                  <svg class="rating-icon icon-star">
                    <use xlink:href="#svg-star"></use>
                  </svg>
                </div>
                <div class="rating filled">
                  <svg class="rating-icon icon-star">
                    <use xlink:href="#svg-star"></use>
                  </svg>
                </div>
                <div class="rating filled">
                  <svg class="rating-icon icon-star">
                    <use xlink:href="#svg-star"></use>
                  </svg>
                </div>
                <div class="rating filled">
                  <svg class="rating-icon icon-star">
                    <use xlink:href="#svg-star"></use>
                  </svg>
                </div>
                <div class="rating filled">
                  <svg class="rating-icon icon-star">
                    <use xlink:href="#svg-star"></use>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="sidebar-box-title medium-space"><?php echo languageVariables("productInfo", "words", $languageType); ?></p>
        <div class="sidebar-box-items">
          <div class="information-line-list">
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("publishDate", "words", $languageType); ?></p>
              <p class="information-line-text"><span class="bold"><?php echo checkTime($readProduct["date"]); ?></span></p>
            </div>
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("server", "words", $languageType); ?></p>
              <p class="information-line-text"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a></p>
            </div>
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
              <p class="information-line-text"><?php if ($readProduct["categoryID"] > 0) { ?><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a><?php } else { ?><?php echo languageVariables("notCategory", "words", $languageType); ?><?php } ?></p>
            </div>
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("price", "words", $languageType); ?></p>
              <p class="information-line-text"><span class="bold"><?php echo $readProduct["price"]." ".languageVariables("credi", "words", $languageType); ?></span></p>
            </div>
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("duration", "words", $languageType); ?></p>
              <p class="information-line-text"><span class="bold"><?php if ($readProduct["productTime"] > 0) { echo $readProduct["productTime"]." ".languageVariables("day", "words", $languageType); } else { echo languageVariables("unlimited", "words", $languageType); } ?></span></p>
            </div>
            <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
            <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
            <div class="information-line">
              <p class="information-line-title"><?php echo languageVariables("stock", "words", $languageType); ?></p>
              <p class="information-line-text"><span class="bold"><?php if ($readProduct["productCount"] > 0) { $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount(); echo (($productCountPiece == "0") ? languageVariables("soldOut", "words", $languageType) : $productCountPiece." ".languageVariables("count", "words", $languageType)); } else { echo languageVariables("unlimited", "words", $languageType); } ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else if (isset($_GET["categoryID"])) { ?>
<?php
$searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ? AND (status = ? OR status = ?)");
$searchCategory->execute(array(get("categoryID"), 1, 2));
if ($searchCategory->rowCount() > 0) {
  $readCategory = $searchCategory->fetch();
  $searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
  $searchServer->execute(array($readCategory["serverID"], 1, 2));
  if ($searchServer->rowCount() > 0) {
    $readServer = $searchServer->fetch();
?>
<div class="content-grid">
  <!-- STORE -->
  <div class="grid grid-9-3 mobile-prefer-content">
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("products", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
          <p class="section-header-subsection"><?php echo $readCategory["name"]; ?></p>
        </div>
      </div>
      <?php $searchProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND serverID = ? AND status = ? ORDER BY id ASC"); ?>
      <?php $searchProduct->execute(array($readCategory["id"], $readServer["id"], 1)); ?>
      <div class="grid <?php if ($searchProduct->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>" id="game-product-list">
        <?php if ($searchProduct->rowCount() > 0) { ?>
        <?php foreach ($searchProduct as $readProduct) { ?>
        <?php
          if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) {
            $productDiscount = floor($readProduct["price"]*(100-$readProduct["productDiscount"])/100);
            $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
          } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
            $productDiscount = floor($readProduct["price"]*(100-$readModule["storeDiscount"])/100);
            $readProduct["price"] = "<del style=\"color: #fe2203;\">".$readProduct["price"]."</del> ".$productDiscount;
          }
          ?>
        <div class="product-preview">
          <?php if ($readProduct["productType"] == 1 && $readProduct["productDiscount"] > 0) { ?>
          <p class="product-discount-sticker text-tooltip-tft" data-title="<?php echo languageVariables("privateProductDiscount", "words", $languageType); ?>">
            <svg class="discount-icon">
              <use xlink:href="#svg-star"></use>
            </svg>
          </p>
          <?php } ?>
          <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
          <?php $searchProductStockHistory->execute(array($readProduct["id"])); ?>
          <?php 
            if ($readProduct["productCount"] > 0) {
              $productCountPiece = $readProduct["productCount"] - $searchProductStockHistory->rowCount();
              echo (($productCountPiece == "0") ? "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProduct", "words", $languageType)."\"><p class=\"product-count-sticker-text\"><span class=\"product-count-sticker-text-not\">".languageVariables("soldOut", "words", $languageType)."</span></p></div>" : "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProduct", "words", $languageType)."\"><p class=\"product-count-sticker-text\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</p></div>");
            }
            ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>">
            <figure class="product-preview-image liquid" style="height: 275px;">
              <img src="<?php echo $readProduct["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProduct["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            </figure>
          </a>
          <div class="product-preview-info">
            <p class="text-sticker"><span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProduct["price"]; ?></p>
            <p class="product-preview-title" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>';"><?php echo $readProduct["name"]; ?></p>
            <p class="product-preview-category digital"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a></p>
            <p class="product-preview-text" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProduct["name"])."/".$readProduct["id"]; ?>';"><?php echo contentShort(strip_tags($readProduct["text"]), 100); ?></p>
          </div>
        </div>
        <?php } } else { echo alert(languageVariables("notCategoryProductAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php if ($readModule["storeExProductStatus"] == "1") { ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("discountProducts", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a>
          <p class="section-header-subsection"><?php echo languageVariables("discountProducts", "words", $languageType); ?></p>
        </div>
      </div>
      <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND serverID = ?  AND status = ? AND productType = ? AND productDiscount > ? ORDER BY id DESC LIMIT 9"); ?>
      <?php $searchProducts->execute(array($readCategory["id"], $readServer["id"], 1, 1, 0)); ?>
      <div class="grid <?php if ($searchProducts->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>" id="game-product-list">
        <?php if ($searchProducts->rowCount() > 0) { ?>
        <?php foreach ($searchProducts as $readProducts) { ?>
        <?php
          if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readProducts["productDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readModule["storeDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          }
          ?>
        <div class="product-preview">
          <p class="product-discount-sticker text-tooltip-tft" data-title="<?php echo languageVariables("privateProductDiscount", "words", $languageType); ?>">
            <svg class="discount-icon">
              <use xlink:href="#svg-star"></use>
            </svg>
          </p>
          <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
          <?php $searchProductStockHistory->execute(array($readProducts["id"])); ?>
          <?php 
            if ($readProducts["productCount"] > 0) {
              $productCountPiece = $readProducts["productCount"] - $searchProductStockHistory->rowCount();
              echo (($productCountPiece == "0") ? "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"Sınırlı Ürün\"><p class=\"product-count-sticker-text\"><span class=\"product-count-sticker-text-not\">Tükendi</span></p></div>" : "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"Sınırlı Ürün\"><p class=\"product-count-sticker-text\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</p></div>");
            }
            ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>">
            <figure class="product-preview-image liquid" style="height: 275px;">
              <img src="<?php echo $readProducts["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProducts["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            </figure>
          </a>
          <div class="product-preview-info">
            <p class="text-sticker"><span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProducts["price"]; ?></p>
            <p class="product-preview-title"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>"><?php echo $readProducts["name"]; ?></a></p>
            <p class="product-preview-category digital"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a></p>
            <p class="product-preview-text" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>';"><?php echo contentShort(strip_tags($readProducts["text"]), 100); ?></p>
          </div>
        </div>
        <?php } } else { echo alert(languageVariables("notProductDiscountAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php } ?>
    </div>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("filters", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="search-bar">
            <div class="interactive-input">
              <input type="text" id="product-search" placeholder="<?php echo languageVariables("searchMake", "words", $languageType); ?>">
              <div class="interactive-input-icon-wrap">
                <svg class="interactive-input-icon icon-magnifying-glass">
                  <use xlink:href="#svg-magnifying-glass"></use>
                </svg>
              </div>
              <div class="interactive-input-action">
                <svg class="interactive-input-action-icon icon-cross-thin">
                  <use xlink:href="#svg-cross-thin"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        $discountValue = array($readModule['storeDiscount']);
        $textValue = array("[discount]");
        $discountText = str_replace($textValue, $discountValue, $readModule['storeDiscountText']);
        if($readModule['storeDiscountStatus'] == "1"){
          if ($readModule['storeDiscount'] !== "0") {
            echo "<div class=\"store-discount-card\">".$discountText."</div>";
          }
        }
        ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("lastShopping", "words", $languageType); ?></h2>
        </div>
      </div>
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchStoreHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
            <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
            <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
            <?php $readServerList = $searchServerList->fetch(); ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readStoreHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&serverID", "&serverName", "&productName"), array($readStoreHistory["username"], $readStoreHistory["serverID"], $readServerList["name"], $readStoreHistory["productName"]), languageVariables("storeHistoryText", "home", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkTime($readStoreHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("notStoreHistoryAlert", "store", $languageType), "warning", "0", "/"); } ?>
    </div>
  </div>
  <!-- /STORE -->
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else if (isset($_GET["serverID"])) { ?>
<?php
$searchServer = $db->prepare("SELECT * FROM serverList WHERE id = ? AND (status = ? OR status = ?)");
$searchServer->execute(array(get("serverID"), 1, 2));
if ($searchServer->rowCount() > 0) {
  $readServer = $searchServer->fetch();
  $searchCategory = $db->prepare("SELECT * FROM serverCategory WHERE serverID = ? AND status = ? ORDER BY id ASC");
  $searchCategory->execute(array($readServer["id"], 1));
  if ($searchCategory->rowCount() == "1") {
    $readCategory = $searchCategory->fetch();
    $searchQueryProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ? AND status = ?");
    $searchQueryProduct->execute(array(0, 1));
    if ($readModule["storeExProductStatus"] == "0") {
      go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]);
    } else {
      if ($searchQueryProduct->rowCount() == "0") {
        go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]);
      }
    }
  }
?>
<div class="content-grid">

  <!-- STORE -->
  <div class="grid grid-9-3 mobile-prefer-content">
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("categories", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <p class="section-header-subsection"><?php echo $readServer["name"]; ?></p>
        </div>
      </div>
      <div class="grid <?php if ($searchCategory->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>">
        <?php if ($searchCategory->rowCount() > 0) { ?>
        <?php foreach ($searchCategory as $readCategory) { ?>
        <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE categoryID = ?"); ?>
        <?php $countProduct->execute(array($readCategory["id"])); ?>
        <a class="product-category-box category-featured" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".createSlug($readCategory["name"])."/".$readCategory["id"]; ?>" style="background-image: url('<?php echo $readCategory["image"]; ?>'); background-size: cover; background-position: center !important; background-repeat: no-repeat; box-shadow: inset 0 0 7rem rgba(0, 0, 0, .8);">
          <p class="product-category-box-title"><?php echo $readCategory["name"]; ?></p>
          <p class="product-category-box-text"><?php echo str_replace("&category", $readCategory["name"], languageVariables("goCategoryText", "store", $languageType)); ?></p>
          <p class="product-category-box-tag"><?php echo $countProduct->rowCount(); ?> <?php echo languageVariables("product", "words", $languageType); ?></p>
        </a>
        <?php } } else { echo alert(languageVariables("notCategoryAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php if ($readModule["storeExProductStatus"] == "1") { ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("notCategoryProduct", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>"><?php echo $readServer["name"]; ?></a>
          <p class="section-header-subsection"><?php echo languageVariables("notCategoryProduct", "words", $languageType); ?></p>
        </div>
      </div>
      <?php $searchProducts = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ? AND categoryID = ? AND status = ? ORDER BY id DESC LIMIT 9"); ?>
      <?php $searchProducts->execute(array($readServer["id"], 0, 1)); ?>
      <div class="grid <?php if ($searchProducts->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>" id="game-product-list">
        <?php if ($searchProducts->rowCount() > 0) { ?>
        <?php foreach ($searchProducts as $readProducts) { ?>
        <?php
          if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readProducts["productDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readModule["storeDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          }
          ?>
        <div class="product-preview">
          <?php if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) { ?>
          <p class="product-discount-sticker text-tooltip-tft" data-title="<?php echo languageVariables("privateProductDiscount", "words", $languageType); ?>">
            <svg class="discount-icon">
              <use xlink:href="#svg-star"></use>
            </svg>
          </p>
          <?php } ?>
          <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
          <?php $searchProductStockHistory->execute(array($readProducts["id"])); ?>
          <?php 
            if ($readProducts["productCount"] > 0) {
              $productCountPiece = $readProducts["productCount"] - $searchProductStockHistory->rowCount();
              echo (($productCountPiece == "0") ? "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProcut", "words", $languageType)."\"><p class=\"product-count-sticker-text\"><span class=\"product-count-sticker-text-not\">".languageVariables("soldOut", "words", $languageType)."</span></p></div>" : "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProcut", "words", $languageType)."\"><p class=\"product-count-sticker-text\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</p></div>");
            }
          ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>">
            <figure class="product-preview-image liquid" style="height: 275px;">
              <img src="<?php echo $readProducts["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProducts["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            </figure>
          </a>
          <div class="product-preview-info">
            <p class="text-sticker"><span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProducts["price"]; ?></p>
            <p class="product-preview-title" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>';"><?php echo $readProducts["name"]; ?></p>
            <p class="product-preview-category digital"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>"><?php echo languageVariables("notCategory", "words", $languageType); ?></a></p>
            <p class="product-preview-text" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/"."kategorisiz"."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>';"><?php echo contentShort(strip_tags($readProducts["text"]), 100); ?></p>
          </div>
        </div>
        <?php } } else { echo alert(languageVariables("serverNotCategoryProductAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php } ?>
    </div>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("filter", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="search-bar">
            <div class="interactive-input">
              <input type="text" id="product-search" placeholder="<?php echo languageVariables("searchMake", "words", $languageType); ?>">
              <div class="interactive-input-icon-wrap">
                <svg class="interactive-input-icon icon-magnifying-glass">
                  <use xlink:href="#svg-magnifying-glass"></use>
                </svg>
              </div>
              <div class="interactive-input-action">
                <svg class="interactive-input-action-icon icon-cross-thin">
                  <use xlink:href="#svg-cross-thin"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        $discountValue = array($readModule['storeDiscount']);
        $textValue = array("[discount]");
        $discountText = str_replace($textValue, $discountValue, $readModule['storeDiscountText']);
        if($readModule['storeDiscountStatus'] == "1"){
          if ($readModule['storeDiscount'] !== "0") {
            echo "<div class=\"store-discount-card\">".$discountText."</div>";
          }
        }
        ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("lastShopping", "words", $languageType); ?></h2>
        </div>
      </div>
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchStoreHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
            <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
            <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
            <?php $readServerList = $searchServerList->fetch(); ?>
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readStoreHistory["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readStoreHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&serverID", "&serverName", "&productName"), array($readStoreHistory["username"], $readStoreHistory["serverID"], $readServerList["name"], $readStoreHistory["productName"]), languageVariables("storeHistoryText", "home", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkTime($readStoreHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("notStoreHistoryAlert", "store", $languageType), "warning", "0", "/"); } ?>
    </div>
  </div>
  <!-- /STORE -->
</div>
<?php } else { go(urlConverter("store", $languageType)); } ?>
<?php } else { ?>
<?php $searchServer = $db->prepare("SELECT * FROM serverList WHERE status = ? ORDER BY id ASC"); ?>
<?php $searchServer->execute(array(1)); ?>
<?php if ($searchServer->rowCount() == 1) { ?>
<?php $readServer = $searchServer->fetch(); ?>
<?php go(urlConverter("store", $languageType)."/".createSlug($readServer["name"])."/".$readServer["id"]); ?>
<?php } ?>
<div class="content-grid">
  <!-- STORE -->
  <div class="grid grid-9-3 mobile-prefer-content">
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("servers", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <p class="section-header-subsection"><?php echo languageVariables("servers", "words", $languageType); ?></p>
        </div>
      </div>
      <div class="grid <?php if ($searchServer->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>">
        <?php if ($searchServer->rowCount() > 0) { ?>
        <?php foreach ($searchServer as $readServer) { ?>
        <?php $countProduct = $db->prepare("SELECT * FROM categoryProduct WHERE serverID = ?"); ?>
        <?php $countProduct->execute(array($readServer["id"])); ?>
        <a class="product-category-box category-featured" href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($readServer["name"])."/".$readServer["id"]; ?>" style="background-image: url('<?php echo $readServer["image"]; ?>'); background-size: cover; background-repeat: no-repeat; box-shadow: inset 0 0 7rem rgba(0, 0, 0, .8);">
          <p class="product-category-box-title"><?php echo $readServer["name"]; ?></p>
          <p class="product-category-box-text"><?php echo str_replace("&server", $readServer["name"], languageVariables("goServerText", "store", $languageType)); ?></p>
          <p class="product-category-box-tag"><?php echo $countProduct->rowCount(); ?> <?php echo languageVariables("product", "words", $languageType); ?></p>
        </a>
        <?php } } else { echo alert(languageVariables("notServerAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php if ($readModule["storeExProductStatus"] == "1") { ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("lastAddProduct", "words", $languageType); ?></h2>
        </div>
        <div class="section-header-actions">
          <a class="section-header-subsection" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          <p class="section-header-subsection"><?php echo languageVariables("lastAddProduct", "words", $languageType); ?></p>
        </div>
      </div>
      <?php $searchProducts= $db->prepare("SELECT * FROM categoryProduct WHERE status = ? ORDER BY id DESC LIMIT 9"); ?>
      <?php $searchProducts->execute(array(1)); ?>
      <div class="grid <?php if ($searchProducts->rowCount() > 0) { echo "grid-3-3-3-3 centered"; } else { echo "grid-4-4"; } ?>" id="game-product-list">
        <?php if ($searchProducts->rowCount() > 0) { ?>
        <?php foreach ($searchProducts as $readProducts) { ?>
        <?php $productServer = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
        <?php $productServer->execute(array($readProducts["serverID"])); ?>
        <?php $productCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?"); ?>
        <?php $productCategory->execute(array($readProducts["categoryID"])); ?>
        <?php $productServer = $productServer->fetch(); ?>
        <?php $productCategory = $productCategory->fetch(); ?>
        <?php
          if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readProducts["productDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
            $productDiscount = floor($readProducts["price"]*(100-$readModule["storeDiscount"])/100);
            $readProducts["price"] = "<del style=\"color: #fe2203;\">".$readProducts["price"]."</del> ".$productDiscount;
          }
          ?>
        <div class="product-preview">
          <?php if ($readProducts["productType"] == 1 && $readProducts["productDiscount"] > 0) { ?>
          <p class="product-discount-sticker text-tooltip-tft" data-title="<?php echo languageVariables("privateProductDiscount", "words", $languageType); ?>">
            <svg class="discount-icon">
              <use xlink:href="#svg-star"></use>
            </svg>
          </p>
          <?php } ?>
          <?php $searchProductStockHistory = $db->prepare("SELECT * FROM productStockHistory WHERE productID = ?"); ?>
          <?php $searchProductStockHistory->execute(array($readProducts["id"])); ?>
          <?php 
            if ($readProducts["productCount"] > 0) {
              $productCountPiece = $readProducts["productCount"] - $searchProductStockHistory->rowCount();
              echo (($productCountPiece == "0") ? "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProduct", "words", $languageType)."\"><p class=\"product-count-sticker-text\"><span class=\"product-count-sticker-text-not\">".languageVariables("soldOut", "words", $languageType)."</span></p></div>" : "<div class=\"product-count-sticker text-tooltip-tft\" data-title=\"".languageVariables("limitedProduct", "words", $languageType)."\"><p class=\"product-count-sticker-text\">".str_replace("&count", $productCountPiece, languageVariables("productLimitedText", "store", $languageType))."</p></div>");
            }
            ?>
          <a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/".(($readProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($productCategory["name"]))."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>">
            <figure class="product-preview-image liquid" style="height: 275px;">
              <img src="<?php echo $readProducts["image"]; ?>" alt="<?php echo languageVariables("store", "words", $languageType); ?> - <?php echo $readProducts["name"]; ?> <?php echo languageVariables("product", "words", $languageType); ?>">
            </figure>
          </a>
          <div class="product-preview-info">
            <p class="text-sticker"><span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo $readProducts["price"]; ?></p>
            <p class="product-preview-title" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/".(($readProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($productCategory["name"]))."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>';"><?php echo $readProducts["name"]; ?></p>
            <p class="product-preview-category digital"><a href="<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/".$productServer["id"]; ?>"><?php echo $productServer["name"]; ?></a></p>
            <p class="product-preview-text" onclick="window.location='<?php echo urlConverter("store", $languageType); ?>/<?php echo createSlug($productServer["name"])."/".(($readProducts["categoryID"] == "0") ? "kategorisiz" : createSlug($productCategory["name"]))."/".createSlug($readProducts["name"])."/".$readProducts["id"]; ?>';"><?php echo contentShort(strip_tags($readProducts["text"]), 100); ?></p>
          </div>
        </div>
        <?php } } else { echo alert(languageVariables("notProductAlert", "store", $languageType), "warning", "0", "/"); }?>
      </div>
      <?php } ?>
    </div>
    <div class="grid-column">
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("filter", "words", $languageType); ?></h2>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="search-bar">
            <div class="interactive-input">
              <input type="text" id="product-search" placeholder="<?php echo languageVariables("searchMake", "words", $languageType); ?>">
              <div class="interactive-input-icon-wrap">
                <svg class="interactive-input-icon icon-magnifying-glass">
                  <use xlink:href="#svg-magnifying-glass"></use>
                </svg>
              </div>
              <div class="interactive-input-action">
                <svg class="interactive-input-action-icon icon-cross-thin">
                  <use xlink:href="#svg-cross-thin"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        $discountValue = array($readModule['storeDiscount']);
        $textValue = array("[discount]");
        $discountText = str_replace($textValue, $discountValue, $readModule['storeDiscountText']);
        if($readModule['storeDiscountStatus'] == "1"){
          if ($readModule['storeDiscount'] !== "0") {
            echo "<div class=\"store-discount-card\">".$discountText."</div>";
          }
        }
        ?>
      <div class="section-header">
        <div class="section-header-info">
          <p class="section-pretitle"><?php echo languageVariables("store", "words", $languageType); ?></p>
          <h2 class="section-title"><?php echo languageVariables("lastShopping", "words", $languageType); ?></h2>
        </div>
      </div>
      <?php $searchStoreHistory = $db->query("SELECT * FROM storeHistory ORDER BY id DESC LIMIT 5"); ?>
      <?php if ($searchStoreHistory->rowCount() > 0) { ?>
      <div class="widget-box">
        <div class="widget-box-content">
          <div class="user-status-list">
            <?php foreach ($searchStoreHistory as $readStoreHistory) { ?>
            <?php $searchServerList = $db->prepare("SELECT * FROM serverList WHERE id = ?"); ?>
            <?php $searchServerList->execute(array($readStoreHistory["serverID"])); ?>
            <?php $readServerList = $searchServerList->fetch(); ?>
            <div class="user-status">
              <a class="user-status-avatar" href="/oyuncu/<?php echo $readStoreHistory["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readStoreHistory["username"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><?php echo str_replace(array("&username", "&serverID", "&serverName", "&productName"), array($readStoreHistory["username"], $readStoreHistory["serverID"], $readServerList["name"], $readStoreHistory["productName"]), languageVariables("storeHistoryText", "home", $languageType)); ?></p>
              <p class="user-status-timestamp"><?php echo checkTime($readStoreHistory["date"]); ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("notStoreHistoryAlert", "store", $languageType), "warning", "0", "/"); } ?>
    </div>
  </div>
  <!-- /STORE -->
</div>
<?php } ?>