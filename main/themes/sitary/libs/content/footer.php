<div class="footer-banner t-5" style="background-image: url('<?php echo $themeSitaryVariables["footerImage"]; ?>') !important;">
  <div class="container">
    <div class="footer-banner-fix">
      <div class="footer-banner-info">
        <p class="footer-banner-title"><?php echo languageVariables("footerTitle", "words", $languageType); ?></p>
        <p class="footer-banner-description"><?php echo languageVariables("footerText", "words", $languageType); ?></p>
      </div>
      <a class="footer-banner-button" server-command="serverIPCopy" data-clipboard-action="copy" data-clipboard-text="<?php echo $rSettings['IPAdres']; ?>"><i class="mdi mdi-minecraft"></i><?php echo languageVariables("justPlay", "words", $languageType); ?></a>
    </div>
  </div>
</div>
<footer>
  <div class="footer-m">
    <div class="container">
      <div class="row">
        <div class="col-sm-4 space">
          <h5><?php echo languageVariables("footerTitle", "words", $languageType); ?></h5>
          <div class="well">
            <div class="iconbox"><i class="mdi mdi-minecraft"></i></div>
            <span>
              <?php echo $rSettings['IPAdres']; ?><br>
              <div class="boxtext"><span server-command="serverOnlineStatus" server-ip="<?php echo $rSettings['IPAdres']; ?>">-/-</span> <?php echo languageVariables("serverOnlineText", "words", $languageType); ?></div>
            </span>
          </div>
          <div class="well">
            <div class="iconbox"><i class="mdi mdi-discord"></i></div>
            <span>
              <span server-command="discordServerName">-/-</span><br>
              <div class="boxtext"><span server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</span> <?php echo languageVariables("onlineUser", "words", $languageType); ?></div>
            </span>
          </div>
          <div class="well mt-2">
            <span style="font-weight: 400;">
              <span><?php echo $rSettings["serverName"]; ?>,</span> <?php echo date("Y"); ?> <?php echo languageVariables("footerCopyright", "words", $languageType); ?>
            </span>
          </div>
        </div>
        <div class="col-sm-4 space">
          <h5><?php echo languageVariables("connects", "words", $languageType); ?></h5>
          <ul class="sayfalar">
            <li><i class="mdi mdi-home mr-2"></i> <a href="<?php echo urlConverter("home", $languageType); ?>"><?php echo languageVariables("home", "words", $languageType); ?></a></li>
            <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
            <li><i class="mdi mdi-login-variant mr-2"></i> <a href="<?php echo urlConverter("login", $languageType); ?>"><?php echo languageVariables("login", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-account-plus-outline mr-2"></i> <a href="<?php echo urlConverter("register", $languageType); ?>"><?php echo languageVariables("register", "words", $languageType); ?></a></li>
            <?php } else { ?>
            <li><i class="mdi mdi-cart mr-2"></i> <a href="<?php echo urlConverter("store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-lifebuoy mr-2"></i> <a href="<?php echo urlConverter("support", $languageType); ?>"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-plus-circle-multiple-outline mr-2"></i> <a href="<?php echo urlConverter("credit_upload", $languageType); ?>"><?php echo languageVariables("creditUpload", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-gift mr-2"></i> <a href="<?php echo urlConverter("gift_coupon", $languageType); ?>"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-cube-outline mr-2"></i> <a href="<?php echo urlConverter("card_game", $languageType); ?>"><?php echo languageVariables("cardGame", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-archive mr-2"></i> <a href="<?php echo urlConverter("chest", $languageType); ?>"><?php echo languageVariables("chest", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-grid-large mr-2"></i> <a href="<?php echo urlConverter("inventory", $languageType); ?>"><?php echo languageVariables("inventory", "words", $languageType); ?></a></li>
            <?php } ?>
            <li><i class="mdi mdi-help mr-2"></i> <a href="<?php echo urlConverter("abouts", $languageType); ?>"><?php echo languageVariables("abouts", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-filter-variant mr-2"></i> <a href="<?php echo urlConverter("rules", $languageType); ?>"><?php echo languageVariables("rules", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-file-document-edit-outline mr-2"></i> <a href="<?php echo urlConverter("privacy", $languageType); ?>"><?php echo languageVariables("privacy", "words", $languageType); ?></a></li>
            <li><i class="mdi mdi-cancel mr-2"></i> <a href="<?php echo urlConverter("banned", $languageType); ?>"><?php echo languageVariables("bans", "words", $languageType); ?></a></li>
          </ul>
        </div>
        <div class="col-sm-4 space">
          <h5><?php echo languageVariables("abouts", "words", $languageType); ?></h5>
          <p><?php echo $rSettings["metaDescription"]; ?></p>
          <div class="form-item mt-2">
            <div class="form-select">
              <label for="changeLang"><?php echo languageVariables("languageChange", "words", $languageType); ?></label>
              <select language="change" id="changeLang" ref="<?php echo $_SERVER["REQUEST_URI"]; ?>">
              <?php $languageListF = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
              <?php foreach ($languageListF as $readList) { ?>
                <option value="<?php echo $readList["code"]; ?>" <?php if ($languageType == $readList["code"]) { echo "selected"; } ?>><?php echo $readList["title"]; ?></option>
              <?php } ?>
              </select>
              <svg class="form-select-icon icon-small-arrow">
                <use xlink:href="#svg-small-arrow"></use>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-m-alt">
    <div class="container">
      <div class="altortala">
        <div class="social-medias">
          <a class="social-media-div facebook" target="_blank" href="<?php echo $rMedia["facebook"]; ?>">
            <i class="fab fa-facebook"></i>
          </a>
          <a class="social-media-div twitter" target="_blank" href="<?php echo $rMedia["twitter"]; ?>">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="social-media-div instagram" target="_blank" href="<?php echo $rMedia["instagram"]; ?>">
            <i class="fab fa-instagram"></i>
          </a>
          <a class="social-media-div youtube" target="_blank" href="<?php echo $rMedia["youtube"]; ?>">
            <i class="fab fa-youtube"></i>
          </a>
          <a class="social-media-div discord" target="_blank" href="<?php echo $rMedia["discord"]; ?>">
            <i class="fab fa-discord"></i>
          </a>
          <div class="social-media-div email text-tooltip-tft" data-title="<?php echo $rMedia["email"]; ?>">
            <i class="mdi mdi-email-outline"></i>
          </div>
        </div>
        <div class="copyright-minelab">
          <copyright class="text-tooltip-tft" data-title="Software: Hasan ESKİSARAÇ">
            <a class="font-weight-bold text-white" href="<?php echo "https://www.minexon.net/".(($languageType == "tr") ? "tr" : "en"); ?>" target="_blank" rel="external"><?php echo "MineXON " . "v" . $_CONFIG["PROJECT_VERSION"]; ?></a>
          </copyright>
        </div>
      </div>
    </div>
  </div>
</footer>
<div id="mobile-footer-br">
</div>