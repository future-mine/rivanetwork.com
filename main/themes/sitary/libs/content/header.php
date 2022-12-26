<style type="text/css">
.site-header {
    background-image: url('<?php echo $themeSitaryVariables["headerImage"]; ?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
}
.site-header .hero .logo {
  background: url('<?php echo $rSettings["serverLogo"]; ?>') no-repeat 50%/100% auto;
}
</style>
  <header class="site-header jumbotron">
    <div class="hero">
        <div class="header-box copy-ip" server-command="serverIPCopy" data-clipboard-action="copy" data-clipboard-text="<?php echo $rSettings['IPAdres']; ?>">
            <span class="button w-25 mb-3" style="background: rgba(0, 0, 0, 0.35);"><i class="mdi mdi-minecraft"></i></span>
            <h3><?php echo $rSettings["IPAdres"]; ?></h3>
            <h4 class="players">
                <span server-command="serverOnlineStatus" server-ip="<?php echo $rSettings['IPAdres']; ?>">-/-</span> <?php echo languageVariables("serverOnlineText", "words", $languageType); ?>
            </h4>
        </div>
        <a class="header-box logo mb-5">
          <span class="button w-100 play-button-m" server-command="serverIPCopy" data-clipboard-action="copy" data-clipboard-text="<?php echo $rSettings['IPAdres']; ?>"><?php echo languageVariables("justPlay", "words", $languageType); ?></span>
        </a>
        <a href="/discord" target="_blank" class="header-box discord">
            <span class="button w-25 mb-3" style="background: rgba(0, 0, 0, 0.35);"><i class="mdi mdi-discord"></i></span>
            <h3 server-command="discordServerName"></h3>
            <h4 class="discordUsers"><span server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</span> <?php echo languageVariables("onlineUser", "words", $languageType); ?></h4>
        </a>
    </div>
  </header>
  <header class="header" style="position: relative; top: -1rem; z-index: 1;">
    <div class="header-actions">
      <a class="header-brand" href="<?php echo urlConverter("home", $languageType); ?>">
        <h1 class="header-brand-text d-block"><?php echo $rSettings["serverName"]; ?></h1>
      </a>
    </div>
    <div class="header-actions">
      <div class="mobilemenu-trigger navigation-widget-mobile-trigger">
        <div class="burger-icon inverted">
          <div class="burger-icon-bar"></div>
          <div class="burger-icon-bar"></div>
          <div class="burger-icon-bar"></div>
        </div>
      </div>
      <nav class="navigation">
        <ul class="menu-main">
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("home", $languageType); ?>"><?php echo languageVariables("home", "words", $languageType); ?></a>
          </li>
          <?php if ($readModule["forumStatus"] == "1") { ?>
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("forum", $languageType); ?>"><?php echo languageVariables("forum", "words", $languageType); ?></a>
          </li>
          <?php } ?>
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a>
          </li>
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("support", $languageType); ?>"><?php echo languageVariables("support", "words", $languageType); ?></a>
          </li>
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("help_center", $languageType); ?>"><?php echo languageVariables("helpCenter", "words", $languageType); ?></a>
          </li>
          <li class="menu-main-item">
            <p class="menu-main-item-link">
            <?php echo languageVariables("credi", "words", $languageType); ?>
            </p>
            <ul class="menu-main">
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("credit_upload", $languageType); ?>"><?php echo languageVariables("creditUpload", "words", $languageType); ?></a>
              </li>
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("credit_send", $languageType); ?>"><?php echo languageVariables("creditSend", "words", $languageType); ?></a>
              </li>
            </ul>
          </li>
          <li class="menu-main-item">
            <a class="menu-main-item-link" href="<?php echo urlConverter("lottery", $languageType); ?>"><?php echo languageVariables("lottery", "words", $languageType); ?></a>
          </li>
          <li class="menu-main-item">
            <p class="menu-main-item-link">
            <?php echo languageVariables("connects", "words", $languageType); ?>
            </p>
            <ul class="menu-main">
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("rules", $languageType); ?>"><?php echo languageVariables("rules", "words", $languageType); ?></a>
              </li>
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("banned", $languageType); ?>"><?php echo languageVariables("bans", "words", $languageType); ?></a>
              </li>
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("abouts", $languageType); ?>"><?php echo languageVariables("abouts", "words", $languageType); ?></a>
              </li>
              <li class="menu-main-item">
                <a class="menu-main-item-link" href="<?php echo urlConverter("privacy", $languageType); ?>"><?php echo languageVariables("privacy", "words", $languageType); ?></a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
    <div class="header-actions" style=\"display: none;\">
    </div>
    <div class="header-actions">
      <?php if (isset($_SESSION["incAccountLogin"])) { ?>
      <div class="action-list dark">
        <div class="action-list-item-wrap">
          <?php
          $searchShoppingCart = $db->prepare("SELECT * FROM shoppingCart WHERE userID = ? ORDER BY id ASC");
          $searchShoppingCart->execute(array($readAccount["id"]));
          ?>
          <div class="action-list-item header-dropdown-trigger">
            <svg class="action-list-item-icon icon-shopping-bag">
              <use xlink:href="#svg-shopping-bag"></use>
            </svg>
          </div>
          <div class="dropdown-box no-padding-bottom header-dropdown">
            <div class="dropdown-box-header">
              <p class="dropdown-box-header-title"><?php echo languageVariables("cart", "words", $languageType); ?> <span class="highlighted"><?php echo $searchShoppingCart->rowCount(); ?></span></p>
            </div>
            <div class="dropdown-box-list scroll-small no-hover" data-simplebar>
              <?php
              if ($searchShoppingCart->rowCount() > 0) {
                foreach ($searchShoppingCart as $readShoppingCart) {
                  $cartProduct = $db->prepare("SELECT * FROM categoryProduct WHERE id = ?");
                  $cartProduct->execute(array($readShoppingCart["productID"]));
                  if ($cartProduct->rowCount() > 0) {
                    $readCartProduct = $cartProduct->fetch();
                    $cartProductServer = $db->prepare("SELECT * FROM serverList WHERE id = ?");
                    $cartProductServer->execute(array($readCartProduct["serverID"]));
                    $cartProductCategory = $db->prepare("SELECT * FROM serverCategory WHERE id = ?");
                    $cartProductCategory->execute(array($readCartProduct["categoryID"]));
                    $readCartProductCategory = $cartProductCategory->fetch();
                    $readCartProductServer = $cartProductServer->fetch();
                    if ($readCartProduct["productType"] == 1 && $readCartProduct["productDiscount"] > 0) {
                      $productDiscounts = floor($readCartProduct["price"]*(100-$readCartProduct["productDiscount"])/100);
                      $readCartProduct["price"] = $productDiscounts;
                    } else if ($readModule["storeDiscountStatus"] == "1" && $readModule["storeDiscount"] > 0) {
                      $productDiscounts = floor($readCartProduct["price"]*(100-$readModule["storeDiscount"])/100);
                      $readCartProduct["price"] = $productDiscounts;
                    }
              ?>
              <div class="dropdown-box-list-item">
                <div class="cart-item-preview">
                  <a class="cart-item-preview-image" href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServer["name"])."/".(($readCartProduct["categoryID"] == "0") ? "kategorisiz" : createSlug($readCartProductCategory["name"]))."/".createSlug($readCartProduct["name"])."/".$readCartProduct["id"]; ?>">
                    <figure class="picture medium round liquid">
                      <img src="<?php echo $readCartProduct["image"]; ?>" alt="<?php echo languageVariables("cart", "words", $languageType); ?> - <?php echo $readCartProduct["image"]; ?>">
                    </figure>
                  </a>
                  <p class="cart-item-preview-title"><a href="<?php echo urlConverter("store", $languageType)."/".createSlug($readCartProductServer["name"])."/".(($readCartProduct["categoryID"] == "0") ? "kategorisiz" : createSlug($readCartProductCategory["name"]))."/".createSlug($readCartProduct["name"])."/".$readCartProduct["id"]; ?>"><?php echo $readCartProduct["name"]; ?></a></p>
                  <p class="cart-item-preview-text"><?php echo $readCartProductServer["name"]; ?></p>
                  <p class="cart-item-preview-price"><?php echo $readCartProduct["price"]." x ".$readShoppingCart["productCount"]; ?> (<span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span><?php echo number_format($readCartProduct["price"]*$readShoppingCart["productCount"],2); ?>)</p>
                  <div class="cart-item-preview-action" onclick="shoppingCartDelete('<?php echo $readShoppingCart["id"]; ?>');">
                    <svg class="icon-delete">
                      <use xlink:href="#svg-delete"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php $totalPrice = $totalPrice + ($readCartProduct["price"]*$readShoppingCart["productCount"]); ?>
              <?php } } } else { echo "<div class=\"dropdown-box-list-item\">".alert(languageVariables("shoppingCartAlertError", "words", $languageType), "warning", "0", "/")."</div>"; } ?>
            </div>
            <div class="cart-preview-total">
              <p class="cart-preview-total-title"><?php echo languageVariables("payAmount", "words", $languageType); ?>:</p>
              <p class="cart-preview-total-text"><span class="highlighted"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></span> <?php echo number_format($totalPrice, 2); ?></p>
            </div>
            <div class="dropdown-box-actions">
              <div class="dropdown-box-action">
                <a class="button secondary" href="<?php echo urlConverter("cart", $languageType); ?>"><?php echo languageVariables("goCart", "words", $languageType); ?></a>
              </div>
              <div class="dropdown-box-action">
                <a class="button primary" href="<?php echo urlConverter("cart", $languageType); ?>"><?php echo languageVariables("payCheck", "words", $languageType); ?></a>
              </div>
            </div>
          </div>
        </div>
        <div class="action-list-item-wrap" onclick="readNotifications()">
          <?php
          $unreadRowNotifications = $db->prepare("SELECT * FROM accountsNotifications WHERE userID = ? AND status = ?");
          $unreadRowNotifications->execute(array($readAccount["id"], "unread"));
          ?>
          <div id="account-notificationsread" class="action-list-item <?php if ($unreadRowNotifications->rowCount() > 0) { echo "unread"; } ?> header-dropdown-trigger">
            <svg class="action-list-item-icon icon-notification">
              <use xlink:href="#svg-notification"></use>
            </svg>
          </div>
          <div class="dropdown-box header-dropdown">
            <div class="dropdown-box-header">
              <p class="dropdown-box-header-title"><?php echo languageVariables("notifications", "words", $languageType); ?></p>
              <div class="dropdown-box-header-actions">
                <p class="dropdown-box-header-action"><?php echo languageVariables("notificationsAllCheck", "words", $languageType); ?></p>
                <p class="dropdown-box-header-action"><a href="<?php echo urlConverter("profile_settings", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></p>
              </div>
            </div>
            <div class="dropdown-box-list" data-simplebar>
              <?php
              $searchAccountNotification = $db->prepare("SELECT * FROM accountsNotifications WHERE userID = ? ORDER BY id DESC LIMIT 10");
              $searchAccountNotification->execute(array($readAccount["id"]));
              foreach ($searchAccountNotification as $readAccountNotification) {
                $readNotificationsData = json_decode($readAccountNotification["data"],true);
              ?>
              <div class="dropdown-box-list-item <?php if ($readAccountNotification["status"] == "unread") { echo "unread"; } ?>">
                <div class="user-status notification">
                  <a class="user-status-avatar" href="<?php echo urlConverter("profile_notifications", $languageType); ?>">
                  	<img src="https://minotar.net/bust/<?php echo $readAccountNotification["username"]; ?>/100.png" width="40" height="40">
                  </a>
                  <p class="user-status-title"><?php echo $readAccountNotification["text"]; ?></p>
                  <p class="user-status-timestamp"><?php echo checkTime($readAccountNotification["date"]); ?></p>
                  <div class="user-status-icon">
                    <svg class="icon-<?php echo $readNotificationsData["iconType"]; ?>">
                      <use xlink:href="#svg-<?php echo $readNotificationsData["iconType"]; ?>"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <a class="dropdown-box-button secondary" href="<?php echo urlConverter("profile_notifications", $languageType); ?>"><?php echo languageVariables("notificationsAllView", "words", $languageType); ?></a>
          </div>
        </div>
      </div>
      <div class="action-item-wrap ml-5 pl-5">
        <div class="action-item dark header-settings-dropdown-trigger">
          <div class="user-block">
            <div class="user-avatar"><span style="background-image: url(https://mc-heads.net/body/<?php echo $readAccount["username"]; ?>);"></span></div>
            <div class="text">
              <div class="left">
                <div class="cart-wrap"><?php echo languageVariables("hello", "words", $languageType); ?>, <?php echo $readAccount["username"]; ?></div>
              </div>
            </div>
          </div>
        </div>
        <div class="dropdown-navigation header-settings-dropdown">
          <div class="dropdown-navigation-header">
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("profil", $languageType); ?>">
              	<img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="40" height="40">
              </a>
              <p class="user-status-title"><span class="bold"><?php echo languageVariables("hello", "words", $languageType); ?>, <?php echo $readAccount["realname"]; ?>!</span></p>
              <p class="user-status-text small"><a href="<?php echo urlConverter("profil_prepare", $languageType); ?>"><?php echo $readAccount["email"]; ?></a></p>
            </div>
          </div>
          <p class="dropdown-navigation-category"><?php echo languageVariables("profile", "words", $languageType); ?></p>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile", $languageType); ?>"><?php echo languageVariables("profileDetail", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile_message", $languageType); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile_notifications", $languageType); ?>"><?php echo languageVariables("notifications", "words", $languageType); ?></a>
          <p class="dropdown-navigation-category"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile_prepare", $languageType); ?>"><?php echo languageVariables("accountInfo", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile_password_change", $languageType); ?>"><?php echo languageVariables("passwordChange", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("profile_settings", $languageType); ?>"><?php echo languageVariables("generalSettings", "words", $languageType); ?></a>
          <p class="dropdown-navigation-category"><?php echo languageVariables("transactions", "words", $languageType); ?></p>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("chest", $languageType); ?>"><?php echo languageVariables("chest", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("inventory", $languageType); ?>"><?php echo languageVariables("inventory", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("credit_send", $languageType); ?>"><?php echo languageVariables("creditSend", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("card,_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a>
          <a class="dropdown-navigation-link" href="<?php echo urlConverter("credit_upload", $languageType); ?>"><?php echo languageVariables("creditUpload", "words", $languageType); ?> <span class="highlighted"><?php echo $readAccount["credit"].languageVariables("currency", "words", $languageType)." (".languageVariables("credi", "words", $languageType).")"; ?></span></a>
          <?php if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED") { ?>
          <a class="dropdown-navigation-button button small primary" href="<?php echo urlConverter("admin", $languageType); ?>" target="_blank"><?php echo languageVariables("admin", "words", $languageType); ?></a>
          <?php } ?>
          <a class="dropdown-navigation-button button small secondary" href="<?php echo urlConverter("logout", $languageType); ?>"><?php echo languageVariables("logout", "words", $languageType); ?></a>
        </div>
      </div>
      <?php } else { ?>
      <div class="action-item-wrap mr-3">
        <a href="<?php echo urlConverter("login", $languageType); ?>" class="user-block">
          <div class="user-avatar"><span style="background-image: url(https://mc-heads.net/body/demo);"></span></div>
          <div class="text">
            <div class="left">
              <div class="cart-wrap"><?php echo languageVariables("login", "words", $languageType); ?></div>
            </div>
          </div>
        </a>
      </div>
      <?php } ?>
    </div>
  </header>

  <aside class="floaty-bar">
    <div class="bar-actions" style="display: none;">
      <div class="progress-stat">
        <div class="bar-progress-wrap">
          <p class="bar-progress-info"><?php echo languageVariables("credi", "words", $languageType); ?>: <span class="bar-progress-text"></span></p>
        </div>
        <div id="logged-user-level-cp" class="progress-stat-bar"></div>
      </div>
    </div>
    <div class="bar-actions">
      <?php if (isset($_SESSION["incAccountLogin"])) { ?>
      <div class="action-list dark">
        <a class="action-list-item" href="<?php echo urlConverter("home", $languageType); ?>">
          <svg class="action-list-item-icon icon-messages">
            <use xlink:href="#svg-newsfeed"></use>
          </svg>
        </a>
        <a class="action-list-item" href="<?php echo urlConverter("cart", $languageType); ?>">
          <svg class="action-list-item-icon icon-shopping-bag">
            <use xlink:href="#svg-shopping-bag"></use>
          </svg>
        </a>
        <a class="action-list-item <?php if ($unreadRowNotifications->rowCount() > 0) { echo "unread"; } ?>" href="<?php echo urlConverter("profile_notifications", $languageType); ?>">
          <svg class="action-list-item-icon icon-notification">
            <use xlink:href="#svg-notification"></use>
          </svg>
        </a>
      </div>
      <a class="action-item-wrap" href="<?php echo urlConverter("profile_settings", $languageType); ?>">
        <div class="action-item dark">
          <svg class="action-item-icon icon-settings">
            <use xlink:href="#svg-settings"></use>
          </svg>
        </div>
      </a>
      <?php } else { ?>
      <a class="action-item" href="<?php echo urlConverter("login", $languageType); ?>">
        <p class="button dark" style="width: 100px;"><?php echo languageVariables("login", "words", $languageType); ?></p>
      </a>
      <a class="action-item" href="<?php echo urlConverter("register", $languageType); ?>">
        <p class="button primary" style="width: 100px;"><?php echo languageVariables("register", "words", $languageType); ?></p>
      </a>
      <?php } ?>
    </div>
</aside>