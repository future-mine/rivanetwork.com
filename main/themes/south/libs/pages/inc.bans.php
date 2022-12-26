<div class="content-grid">
  <?php include(__DR__."/main/themes/south/libs/content/header-box.php"); ?>
    <div class="grid grid-12 mobile-prefer-content">
      <!-- BANS -->
      <div class="grid-column">
        <!-- TABLE -->
        <?php if ($rSettings["bannedType"] == "0") { ?>
        <?php $searchBannedHistory = $db->prepare("SELECT * FROM banned ORDER BY id DESC"); ?>
        <?php $searchBannedHistory->execute(); ?>
        <?php if ($searchBannedHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("username", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("reason", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("expiryDate", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
              </div>
              <div class="table-body same-color-rows">
              <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
                <div class="table-row micro">
                  <div class="table-column centered padded">
                    <p class="table-text">#<?php echo $readBannedHistory["id"]; ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <a class="table-title" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readBannedHistory["username"]; ?>"><?php echo $readBannedHistory["username"]; ?></a>
                  </div>
                  <div class="table-column centered padded">
                    <a class="table-title"><span class="highlighted"><?php if ($readBannedHistory["type"] == "login") { echo languageVariables("site", "words", $languageType); } else if ($readBannedHistory["type"] == "support") { echo languageVariables("support", "words", $languageType); } else if ($readBannedHistory["type"] == "comment") { echo languageVariables("comment", "words", $languageType); } ?></span></a>
                  </div>
                  <div class="table-column centered padded">
                    <p class="table-title"><?php echo $readBannedHistory["reason"]; ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <?php if ($readBannedHistory["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDate = languageVariables("indefinite", "words", $languageType); } else { if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) { $userBannedBackDate = max(round((strtotime($readBannedHistory["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } else { $userBannedBackDate = languageVariables("end", "words", $languageType); } } ?>
                    <p class="table-title"><?php echo $userBannedBackDate; ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <p class="table-text"><?php echo $readBannedHistory["date"]; ?></p>
                  </div>
                  <?php if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) {  ?>
                  <div class="table-column padded-left">
                    <div class="percentage-diff-icon-wrap positive">
                      <svg class="percentage-diff-icon icon-plus-small">
                        <use xlink:href="#svg-plus-small"></use>
                      </svg>
                    </div>
                  </div>
                  <?php } else { ?>
                  <div class="table-column padded-left">
                    <div class="percentage-diff-icon-wrap negative">
                      <svg class="percentage-diff-icon icon-plus-small">
                        <use xlink:href="#svg-minus-small"></use>
                      </svg>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "danger", "0", "/"); } ?>
        <?php } if ($rSettings["bannedType"] == "1") { ?>
        <?php $searchBannedHistory = $db->prepare("SELECT * FROM PunishmentHistory ORDER BY id DESC"); ?>
        <?php $searchBannedHistory->execute(); ?>
        <?php if ($searchBannedHistory->rowCount() > 0) { ?>
        <div class="table-wrap" data-simplebar>
          <div class="table table-sales">
            <div class="table-header">
              <div class="table-header-column centered padded">
                <p class="table-header-title">ID</p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("username", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("reason", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("expiryDate", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column centered padded">
                <p class="table-header-title"><?php echo languageVariables("date", "words", $languageType); ?></p>
              </div>
              <div class="table-header-column padded-left"></div>
              </div>
              <div class="table-body same-color-rows">
              <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
                <div class="table-row micro">
                  <div class="table-column centered padded">
                    <p class="table-text">#<?php echo $readBannedHistory["id"]; ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <a class="table-title" href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readBannedHistory["name"]; ?>"><?php echo $readBannedHistory["name"]; ?></a>
                  </div>
                  <div class="table-column centered padded">
                    <a class="table-title"><span class="highlighted"><?php echo (($readBannedHistory["punishmentType"] == "BAN") ? languageVariables("normalBan", "words", $languageType) : (($readBannedHistory["punishmentType"] == "TEMP_BAN") ? languageVariables("tempBan", "words", $languageType): languageVariables("kick", "words", $languageType))); ?></span></a>
                  </div>
                  <div class="table-column centered padded">
                    <p class="table-title"><?php echo (($readBannedHistory["reason"] !== "none") ? $readBannedHistory["reason"] : languageVariables("none", "words", $languageType)); ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <p class="table-title"><?php if ($readBannedHistory["end"] == "-1") { echo languageVariables("indefinite", "words", $languageType); } else { echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["end"], -13, 10)), 2, true); } ?></p>
                  </div>
                  <div class="table-column centered padded">
                    <p class="table-text"><?php echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["start"], -13, 10)), 2, true); ?></p>
                  </div>
                  <div class="table-column padded-left">
                    <div class="percentage-diff-icon-wrap positive">
                      <svg class="percentage-diff-icon icon-plus-small">
                        <use xlink:href="#svg-plus-small"></use>
                      </svg>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
		      <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "danger", "0", "/"); } ?>
          <?php } ?>
          <!-- /TABLE -->
      </div>
      <!-- /BANS -->
    </div>
    <br>
</div>