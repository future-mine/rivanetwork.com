<style type="text/css">
<?php if ($readModule["generalChatStatus"] == "1") { ?>
.footer-message-box-refresh {
  float: right;
  font-size: 24px;
  font-weight: bold;
}
<?php } else { ?>
.disable-chat-logo {
  margin-top: 2rem;
  text-align: center;
  align-items: center;
  justify-content: center;
}
.disable-chat-logo img {
  width: 150px;
}
.disable-chat-text {
  font-weight: 900;
  font-size: 2rem;
  margin-top: 1.5rem;
  margin-bottom: 3rem;
  text-align: center;
  align-items: center;
  justify-content: center;
}
<?php } ?>
</style>
<footer class="footer">
  <div class="content-grid" style="padding-bottom: 2rem; padding-top: 1.5rem;">
    <div class="grid grid-3-6-3">
      <div class="grid-column">
        <div class="user-preview">
          <figure class="user-preview-cover liquid">
            <img src="<?php echo $themeSouthVariables["footerImage"]; ?>" alt="<?php echo $rSettings["serverName"]; ?> - Footer">
          </figure>
          <div class="user-preview-info">
            <div class="user-short-description">
              <a class="user-short-description-avatar user-avatar medium">
                <div class="user-avatar-content">
                  <div class="hexagon-image-82-90" data-src="<?php echo $rSettings["serverLogo"]; ?>"></div>
                </div>
              </a>
              <p class="user-short-description-title" style="margin: 0;"><?php echo $rSettings["serverName"]; ?></p>
              <p class="user-short-description-text"><?php echo languageVariables("abouts", "words", $languageType); ?></p>
            </div>
            <div id="user-preview-stats-slides-01" class="user-preview-stats-slides">
              <div class="user-preview-stats-slide">
                <div class="user-stats">
                  <p class="user-preview-text"><?php echo $rSettings["metaDescription"]; ?></p>
                </div>
             </div>
            </div>
            <div class="social-links small">
              <a class="social-link small twitter" href="<?php echo $rMedia["twitter"]; ?>" target="_blank">
                <svg class="social-link-icon icon-twitter">
                  <use xlink:href="#svg-twitter"></use>
                </svg>
              </a>
              <a class="social-link small instagram" href="<?php echo $rMedia["instagram"]; ?>" target="_blank">
                <svg class="social-link-icon icon-instagram">
                  <use xlink:href="#svg-instagram"></use>
                </svg>
              </a>
              <a class="social-link small youtube" href="<?php echo $rMedia["youtube"]; ?>" target="_blank">
                <svg class="social-link-icon icon-youtube">
                  <use xlink:href="#svg-youtube"></use>
                </svg>
              </a>
              <a class="social-link small facebook" href="<?php echo $rMedia["facebook"]; ?>" target="_blank">
                <svg class="social-link-icon icon-facebook">
                  <use xlink:href="#svg-facebook"></use>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="grid-column">
        <div class="widget-box">
        <?php if ($readModule["generalChatStatus"] == "1") { ?>
          <span class="footer-message-box-refresh" id="footer-message-box-refresh">
            <svg class="action-list-item-icon icon-return">
              <use xlink:href="#svg-return"></use>
            </svg>
          </span>
          <div class="widget-box-content">
          <div id="footer-message-box-loader" style="display: none;">
            <div class="loader-bars">
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
              <div class="loader-bar"></div>
            </div><br><br>
          </div>
          <div id="footer-message-box-info" style="display: block;">
            <div id="footer-message-box" class="chat-widget-conversation" style="height: 220px; background: none; overflow: scroll; overflow-x: hidden;" data-simplebar></div>
          </div>
            <div class="chat-widget-form" style="background: none;">
              <div class="form-row split">
                <div class="form-item">
                  <div class="interactive-input small">
                    <input type="text" id="footer-message-input" placeholder="<?php echo languageVariables("footerMessagePlaceholder", "words", $languageType); ?>">
                    <div class="interactive-input-action">
                      <svg class="interactive-input-action-icon icon-cross-thin">
                        <use xlink:href="#svg-cross-thin"></use>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <div class="widget-box-content">
            <div class="disable-chat-logo">
              <img src="<?php echo $rSettings["serverLogo"]; ?>" alt="<?php echo $rSettings["serverName"]." - Logo"; ?>">
            </div>
            <p class="disable-chat-text"><?php echo $rSettings["serverName"]; ?></p>
          </div>
        <?php } ?>
        </div>
      </div>
      <div class="grid-column">
        <div class="user-preview small">
          <figure class="user-preview-cover liquid">
            <img src="/assets/uploads/images/landing/footer/discord-background.png" alt="cover-48">
          </figure>
          <div class="user-preview-info">
            <div class="user-short-description small">
              <a class="user-short-description-avatar user-avatar no-stats">
                <div class="user-avatar-content">
                  <div class="hexagon-image-84-92" data-src="/assets/uploads/images/landing/footer/discord-logo.png"></div>
                </div>
              </a>
              <p class="user-short-description-title" style="margin: 0;" server-command="discordServerName">-/-</p>
              <p class="user-short-description-text"><?php echo languageVariables("footerDiscordTitle", "words", $languageType); ?></p>
            </div>
            <div class="user-stats">
              <div class="user-stat">
                <p class="user-stat-title"></p>
                <p class="user-stat-text"></p>
              </div>
              <div class="user-stat">
                <p class="user-stat-title" server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</p>
                <p class="user-stat-text"><?php echo languageVariables("onlineUser", "words", $languageType); ?></p>
              </div>
              <div class="user-stat">
                <p class="user-stat-title"></p>
                <p class="user-stat-text"></p>
              </div>
            </div>
            <div class="user-preview-actions">
              <p class="button secondary" server-command="discordInstantInvite">
                <svg class="button-icon icon-join-group">
                  <use xlink:href="#svg-join-group"></use>
                </svg>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-5 text-center text-md-left mb-2 mb-md-0"><?php echo $rSettings["serverName"]; ?>, <?php echo date("Y"); ?> <?php echo languageVariables("footerCopyright", "words", $languageType); ?></div>
        <div class="col-12 col-md-3 text-center text-md-left mb-2 mb-md-0">
          <div class="form-item">
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
        <div class="col-12 col-md-4 text-center text-md-right">
          <copyright class="text-tooltip-tft" data-title="Software: Hasan ESKİSARAÇ">
            <a class="font-weight-bold" href="<?php echo "https://www.minexon.net/".(($languageType == "tr") ? "tr" : "en"); ?>" target="_blank" rel="external"><?php echo "MineXON " . "v" . $_CONFIG["PROJECT_VERSION"]; ?></a>
          </copyright>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-br"></div>
</footer>