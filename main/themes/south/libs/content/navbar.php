<style type="text/css">
#displayed-menu-link {
    display: block;
}
@media (max-height: 800px) {
  #displayed-menu-link {
    display: none;
  }
}
.fa-lira-sign:before {
  content: '<?php echo languageVariables("currencyIcon", "words", $languageType); ?>' !important;
}
</style>
   <nav id="navigation-widget-small" class="navigation-widget navigation-widget-desktop closed sidebar left delayed">
   <?php if (isset($_SESSION["incAccountLogin"])) { ?>
    <a class="user-avatar small no-outline" href="<?php echo urlConverter("profil", $languageType); ?>">
    	<img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="40" height="40">
    </a>
    <?php } ?>
    <ul class="menu small">
      <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
      <li class="menu-item <?php if ($incRequirePage == "login" || $incRequirePage == "register") { echo "active"; } ?>" style="margin-bottom: 2rem;">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("login", $languageType); ?>" data-title="<?php echo languageVariables("login", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-members">
            <i class="fa fa-sign-in-alt nav-icon-text-fas <?php if ($incRequirePage == "login" || $incRequirePage == "register") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <?php } ?>
      <li class="menu-item <?php if ($incRequirePage == "home") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("home", $languageType); ?>" data-title="<?php echo languageVariables("home", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-newsfeed">
            <i class="fa fa-home nav-icon-text-fas <?php if ($incRequirePage == "home") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <?php if ($readModule["forumStatus"] == "1") { ?>
      <li class="menu-item <?php if ($incRequirePage == "forum") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("forum", $languageType); ?>" data-title="<?php echo languageVariables("forum", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-overview">
            <i class="fa fa-comment nav-icon-text-fas <?php if ($incRequirePage == "forum") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <?php } ?>
      <li class="menu-item <?php if ($incRequirePage == "store") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("store", $languageType); ?>" data-title="<?php echo languageVariables("store", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-overview">
            <i class="fa fa-shopping-basket nav-icon-text-fas <?php if ($incRequirePage == "store") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "support") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("support", $languageType); ?>" data-title="<?php echo languageVariables("support", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-group">
			      <i class="nav-icon-text-fas fa fa-life-ring <?php if ($incRequirePage == "support") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "help-center") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("help_center", $languageType); ?>" data-title="<?php echo languageVariables("helpCenter", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-group">
			      <i class="nav-icon-text-fas fa fa-question <?php if ($incRequirePage == "help-center") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "credit" && get("action") == "proccess") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("credit_upload", $languageType); ?>" data-title="<?php echo languageVariables("creditUpload", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-members">
            <i class="fa fa-lira-sign nav-icon-text-fas <?php if ($incRequirePage == "credit" && get("action") == "proccess") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li id="displayed-menu-link" class="menu-item <?php if ($incRequirePage == "credit" && get("action") == "transfer") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("credit_send", $languageType); ?>" data-title="<?php echo languageVariables("creditSend", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-members">
            <i class="fa fa-random nav-icon-text-fas <?php if ($incRequirePage == "credit" && get("action") == "transfer") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "lottery") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("lottery", $languageType); ?>" data-title="<?php echo languageVariables("lottery", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-streams">
            <i class="fa fa-chart-pie nav-icon-text-fas <?php if ($incRequirePage == "lottery") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "card") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("card_game", $languageType); ?>" data-title="<?php echo languageVariables("cardGame", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-badges">
            <i class="fa fa-dice-d6 nav-icon-text-fas <?php if ($incRequirePage == "card") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "chest") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("chest", $languageType); ?>" data-title="<?php echo languageVariables("chest", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-quests">
            <i class="fa fa-archive nav-icon-text-fas <?php if ($incRequirePage == "chest") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "inventory") { echo "active"; } ?>">
        <a class="menu-item-link text-tooltip-tfr" href="<?php echo urlConverter("inventory", $languageType); ?>" data-title="<?php echo languageVariables("inventory", "words", $languageType); ?>">
          <svg class="menu-item-link-icon icon-marketplace">
            <i class="fa fa-boxes nav-icon-text-fas <?php if ($incRequirePage == "inventory") { echo "text-white"; } ?>"></i>
          </svg>
        </a>
      </li>
    </ul>
  </nav>

  <nav id="navigation-widget" class="navigation-widget navigation-widget-desktop sidebar left hidden" data-simplebar>
    <?php if (isset($_SESSION["incAccountLogin"])) { ?>
    <figure class="navigation-widget-cover liquid">
      <img src="<?php echo $readAccount["imageAvatar"]; ?>" alt="Avatar - <?php echo $readAccount["username"]; ?>">
    </figure>
    <div class="user-short-description">
      <a class="user-short-description-avatar user-avatar medium" href="<?php echo urlConverter("profil", $languageType); ?>">
        <div class="user-avatar-badge">
          <img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="60" height="60" style="margin-right: 5rem;">
        </div>
        <p class="user-short-description-title mt-3"><a href="<?php echo urlConverter("profil", $languageType); ?>"><?php echo $readAccount["username"]; ?></a></p>
        <p class="user-short-description-text"><a href="<?php echo urlConverter("profile_prepare", $languageType); ?>"><?php echo $readAccount["email"]; ?></a></p>
      </a>
    </div>
    <?php $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?"); ?>
    <?php $rowCountUserProduct->execute(array($readAccount["id"], "0")); ?>
    <?php $rowCountUserProduct = $rowCountUserProduct->rowCount(); ?>
    <?php $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?"); ?>
    <?php $rowCountUserInvent->execute(array($readAccount["id"])); ?>
    <?php $rowCountUserInvent = $rowCountUserInvent->rowCount(); ?>
    <div class="user-stats">
      <a href="<?php echo urlConverter("chest", $languageType); ?>">
      <div class="user-stat">
        <p class="user-stat-title"><?php echo $rowCountUserProduct; ?></p>
        <p class="user-stat-text"><?php echo languageVariables("chest", "words", $languageType); ?></p>
      </div>
      </a>
      <a href="<?php echo urlConverter("credit_upload", $languageType); ?>">
      <div class="user-stat">
        <p class="user-stat-title"><?php echo $readAccount["credit"]; ?></p>
        <p class="user-stat-text"><?php echo languageVariables("credi", "words", $languageType); ?></p>
      </div>
      </a>
      <a href="<?php echo urlConverter("inventory", $languageType); ?>">
      <div class="user-stat">
        <p class="user-stat-title"><?php echo $rowCountUserInvent."/".$readAccount["inventorySlot"]; ?></p>
        <p class="user-stat-text"><?php echo languageVariables("inventory", "words", $languageType); ?></p>
      </div>
      </a>
    </div>
    <?php } else { ?>
    <div class="navigation-widget-info-wrap">
      <a href="<?php echo urlConverter("login", $languageType); ?>" class="navigation-widget-info-button button dark ml-5"><?php echo languageVariables("login", "words", $languageType); ?></a>
      <a href="<?php echo urlConverter("register", $languageType); ?>" class="navigation-widget-info-button button primary ml-5"><?php echo languageVariables("register", "words", $languageType); ?></a>
    </div>
    <?php } ?>
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
            <i class="fa fa-comment nav-icon-text-fa <?php if ($incRequirePage == "forum") { echo "text-white"; } ?>"></i>
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
            <i class="nav-icon-text-fa fa fa-life-ring <?php if ($incRequirePage == "support") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("support", "words", $languageType); ?>
        </a>
      </li>
      <li class="menu-item <?php if ($incRequirePage == "help-center") { echo "active"; } ?>">
        <a class="menu-item-link" href="<?php echo urlConverter("help_center", $languageType); ?>">
          <svg class="menu-item-link-icon icon-group">
            <i class="nav-icon-text-fa fa fa-question <?php if ($incRequirePage == "help-center") { echo "text-white"; } ?>"></i>
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
            <i class="fa fa-chart-pie nav-icon-text-fa <?php if ($incRequirePage == "lottery") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("lottery", "words", $languageType); ?>
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
  </nav>

  <nav id="navigation-widget-mobile" class="navigation-widget navigation-widget-mobile sidebar left hidden" data-simplebar>
    <div class="navigation-widget-close-button">
      <svg class="navigation-widget-close-button-icon icon-back-arrow">
        <use xlink:href="#svg-back-arrow"></use>
      </svg>
    </div>
    <div class="navigation-widget-info-wrap">
      <?php if (isset($_SESSION["incAccountLogin"])) { ?>
      <div class="navigation-widget-info">
        <a class="user-avatar small no-outline" href="<?php echo urlConverter("profil", $languageType); ?>">
        	<img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="50" height="50">
        </a>
        <p class="navigation-widget-info-title"><a href="<?php echo urlConverter("profil", $languageType); ?>"><?php echo $readAccount["username"]; ?></a></p>
        <p class="navigation-widget-info-text"><?php echo languageVariables("hello", "words", $languageType); ?></p>
      </div>
      <?php if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED") { ?>
      <a href="<?php echo urlConverter("admin", $languageType); ?>" target="_blank" class="navigation-widget-info-button button small primary"><?php echo languageVariables("admin", "words", $languageType); ?></a>
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
            <i class="fa fa-comment nav-icon-text-fa <?php if ($incRequirePage == "forum") { echo "text-white"; } ?>"></i>
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
            <i class="fa fa-chart-pie nav-icon-text-fa <?php if ($incRequirePage == "lottery") { echo "text-white"; } ?>"></i>
          </svg>
          <?php echo languageVariables("lottery", "words", $languageType); ?>
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
    <a class="navigation-widget-section-link" href="<?php echo urlConverter("profil", $languageType); ?>"><?php echo languageVariables("profileDetail", "words", $languageType); ?></a>
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
    <?php if ($readModule["personalizationMode"] == "1") { ?>
    <p class="navigation-widget-section-title"><?php echo languageVariables("customize", "words", $languageType); ?></p>
    <a class="navigation-widget-section-link">
      <div class="form-item">
        <div class="form-select">
          <label for="themeModeTypeMobile"><?php echo languageVariables("themeColorMode", "words", $languageType); ?></label>
          <select onchange="changeThemeMode('themeModeTypeMobile');" id="themeModeTypeMobile">
            <option value="0" <?php if ($_SESSION["themeModeType"] == "dark") { echo "selected"; } ?>><?php echo languageVariables("themeColorModeDark", "words", $languageType); ?></option>
            <option value="1" <?php if ($_SESSION["themeModeType"] == "light") { echo "selected"; } ?>><?php echo languageVariables("themeColorModeLight", "words", $languageType); ?></option>
          </select>
          <svg class="form-select-icon icon-small-arrow">
            <use xlink:href="#svg-small-arrow"></use>
          </svg>
        </div>
      </div>
    </a>
    <?php } ?>
  </nav>
  <?php if ($readModule["personalizationMode"] == "1") { ?>
  <aside id="chat-widget-messages" class="chat-widget closed sidebar right">
    <div class="chat-widget-messages">
      <div class="chat-widget-message">
    	<br>
        <div class="form-item">
          <div class="form-select">
            <label for="themeModeTypePC"><?php echo languageVariables("themeColorMode", "words", $languageType); ?></label>
            <select onchange="changeThemeMode('themeModeTypePC');" id="themeModeTypePC">
              <option value="0" <?php if ($_SESSION["themeModeType"] == "dark") { echo "selected"; } ?>><?php echo languageVariables("themeColorModeDark", "words", $languageType); ?></option>
              <option value="1" <?php if ($_SESSION["themeModeType"] == "light") { echo "selected"; } ?>><?php echo languageVariables("themeColorModeLight", "words", $languageType); ?></option>
            </select>
            <svg class="form-select-icon icon-small-arrow">
              <use xlink:href="#svg-small-arrow"></use>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="chat-widget-button">
      <div class="chat-widget-button-icon">
        <div class="burger-icon">
          <div class="burger-icon-bar"></div>
          <div class="burger-icon-bar"></div>
          <div class="burger-icon-bar"></div>
        </div>
      </div>
      <p class="chat-widget-button-text"><?php echo languageVariables("customize", "words", $languageType); ?></p>
    </div>
  </aside>
  <?php } ?>