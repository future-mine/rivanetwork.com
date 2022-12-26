<?php $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?"); ?>
<?php $rowCountUserProduct->execute(array($readAccount["id"], "0")); ?>
<?php $rowCountUserProduct = $rowCountUserProduct->rowCount(); ?>
<?php $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?"); ?>
<?php $rowCountUserInvent->execute(array($readAccount["id"])); ?>
<?php $rowCountUserInvent = $rowCountUserInvent->rowCount(); ?>
  <nav id="navigation-widget-mobile" class="navigation-widget navigation-widget-mobile sidebar left hidden" data-simplebar>
    <div class="navigation-widget-close-button">
      <svg class="navigation-widget-close-button-icon icon-back-arrow">
        <use xlink:href="#svg-back-arrow"></use>
      </svg>
    </div>
    <div class="navigation-widget-info-wrap">
      <?php if (isset($_SESSION["incAccountLogin"])) { ?>
      <div class="navigation-widget-info">
        <a class="user-avatar small no-outline" href="<?php echo urlConverter("profile", $languageType); ?>">
        	<img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="50" height="50">
        </a>
        <p class="navigation-widget-info-title"><a href="<?php echo urlConverter("profile", $languageType); ?>"><?php echo $readAccount["username"]; ?></a></p>
        <p class="navigation-widget-info-text"><?php echo languageVariables("hello", "words", $languageType); ?></p>
      </div>
      <?php if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED") { ?>
      <a href="<?php echo urlConverter("admin", $languageType); ?>" class="navigation-widget-info-button button small primary"><?php echo languageVariables("admin", "words", $languageType); ?></a>
      <?php } ?>
      <a href="<?php echo urlConverter("logout", $languageType); ?>" class="navigation-widget-info-button button small secondary"><?php echo languageVariables("logout", "words", $languageType); ?></a>
      <?php } else { ?>
      <a href="<?php echo urlConverter("login", $languageType); ?>" class="navigation-widget-info-button button dark ml-5"><?php echo languageVariables("login", "words", $languageType); ?></a>
      <a href="<?php echo urlConverter("register", $languageType); ?>" class="navigation-widget-info-button button primary ml-5"><?php echo languageVariables("register", "words", $languageType); ?></a>
      <?php } ?>
    </div>
    <p class="navigation-widget-section-title"><?php echo languageVariables("menus", "words", $languageType); ?></p>
    <ul class="menu">
      <li class="menu-item <?php if ($incRequirePage == "home") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("home", $languageType); ?>">
          <svg class="menu-item-link-icon icon-newsfeed">
            <i class="fa fa-home nav-icon-text-fa <?php if ($incRequirePage == "home") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("home", "words", $languageType); ?>
        </a>
      </li>
      <?php if ($readModule["forumStatus"] == "1") { ?>
      <li class="menu-item <?php if ($incRequirePage == "forum") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("forum", $languageType); ?>">
          <svg class="menu-item-link-icon icon-overview">
            <i class="fa fa-message nav-icon-text-fa <?php if ($incRequirePage == "forum") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("forum", "words", $languageType); ?>
        </a>
      </li>
      <?php } ?>
      <li class="menu-item <?php if ($incRequirePage == "store") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("store", $languageType); ?>">
          <svg class="menu-item-link-icon icon-overview">
            <i class="fa fa-shopping-basket nav-icon-text-fa <?php if ($incRequirePage == "store") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("store", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "support") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("support", $languageType); ?>">
          <svg class="menu-item-link-icon icon-group">
            <i class="fa fa-life-ring nav-icon-text-fa <?php if ($incRequirePage == "support") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("support", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "help-center") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("help_center", $languageType); ?>">
          <svg class="menu-item-link-icon icon-group">
            <i class="fa fa-question nav-icon-text-fa <?php if ($incRequirePage == "help-center") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("helpCenter", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "credit" && get("action") == "proccess") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("credit_upload", $languageType); ?>">
          <svg class="menu-item-link-icon icon-members">
            <i class="fa fa-lira-sign nav-icon-text-fa <?php if ($incRequirePage == "credit" && get("action") == "proccess") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("creditUpload", "words", $languageType); ?>
        </a>
      </li>
      <li id="displayed-menu-link" class="menu-item <?php if ($incRequirePage == "credit" && get("action") == "transfer") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("credit_send", $languageType); ?>">
          <svg class="menu-item-link-icon icon-badges">
            <i class="fa fa-random nav-icon-text-fa <?php if ($incRequirePage == "credit" && get("action") == "transfer") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("creditSend", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "lottery") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("lottery", $languageType); ?>">
          <svg class="menu-item-link-icon icon-quests">
            <i class="fa fa-ticket nav-icon-text-fa <?php if ($incRequirePage == "lottery") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("lottery", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "coupon") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("gift_coupon", $languageType); ?>">
          <svg class="menu-item-link-icon icon-quests">
            <i class="fa fa-gift nav-icon-text-fa <?php if ($incRequirePage == "coupon") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("giftCoupon", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "card") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("card_game", $languageType); ?>">
          <svg class="menu-item-link-icon icon-streams">
            <i class="fa fa-dice-d6 nav-icon-text-fa <?php if ($incRequirePage == "card") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("cardGame", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "chest") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("chest", $languageType); ?>">
          <svg class="menu-item-link-icon icon-events">
            <i class="fa fa-archive nav-icon-text-fa <?php if ($incRequirePage == "chest") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("chest", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "inventory") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("inventory", $languageType); ?>">
          <svg class="menu-item-link-icon icon-marketplace">
            <i class="fa fa-boxes nav-icon-text-fa <?php if ($incRequirePage == "inventory") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("inventory", "words", $languageType); ?>
        </a>
      </li>
    </ul>
    <?php if (isset($_SESSION["incAccountLogin"])) { ?>
    <p class="navigation-widget-section-title"><?php echo languageVariables("profile", "words", $languageType); ?></p>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile", $languageType); ?>"><?php echo languageVariables("profileDetail", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile_message", $languageType); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile_notifications", $languageType); ?>"><?php echo languageVariables("notifications", "words", $languageType); ?></a>
    <p class="navigation-widget-section-title"><?php echo languageVariables("accountSettings", "words", $languageType); ?></p>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile_prepare", $languageType); ?>"><?php echo languageVariables("accountInfo", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile_password_change", $languageType); ?>"><?php echo languageVariables("passwordChange", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profile_settings", $languageType); ?>"><?php echo languageVariables("generalSettings", "words", $languageType); ?></a>
    <p class="navigation-widget-section-title"><?php echo languageVariables("transactions", "words", $languageType); ?></p>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("chest", $languageType); ?>"><?php echo languageVariables("chest", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("credit_send", $languageType); ?>"><?php echo languageVariables("creditSend", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("credit_upload", $languageType); ?>"><?php echo languageVariables("creditUpload", "words", $languageType); ?> <span class="highlighted"><?php echo languageVariables("credi", "words", $languageType); ?>: <?php echo $readAccount["credit"]; ?></span></a>
    <?php } ?>
    <p class="navigation-widget-section-title"><?php echo languageVariables("connects", "words", $languageType); ?></p>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("abouts", $languageType); ?>"><?php echo languageVariables("abouts", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("rules", $languageType); ?>"><?php echo languageVariables("rules", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("banned", $languageType); ?>"><?php echo languageVariables("bans", "words", $languageType); ?></a>
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("privacy", $languageType); ?>"><?php echo languageVariables("privacy", "words", $languageType); ?></a>
  </nav>