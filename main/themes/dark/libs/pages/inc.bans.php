<div class="container-fluid">
  <div class="row">
    <div class="col-12 p-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-12 pb-5 pt-3" style="overflow: auto;">
            <div class="bg-dark--3 p-5">
              <h3 class="text-secondary mb-3 font-100 font-size-6 letter-spacing-1 text-uppercase">
                <?php echo languageVariables("bans", "words", $languageType); ?>
              </h3>
              <?php if ($rSettings["bannedType"] == "0") { ?>
              <?php $searchBannedHistory = $db->prepare("SELECT * FROM banned ORDER BY id DESC"); ?>
              <?php $searchBannedHistory->execute(); ?>
              <?php if ($searchBannedHistory->rowCount() > 0) { ?>
              <div class="overflow-auto">
              <table class="default-table w-100 table table-hover table-responsive mb-0">
                <thead class="bg-dark--5">
                  <tr class="text-secondary font-size-6">
                    <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                      #
                    </th>
                    <th class="font-100 p-3 line-height-1 w-30 border-0">
                      <?php echo languageVariables("user", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("category", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-30 border-0">
                      <?php echo languageVariables("reason", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("expiryDate", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("date", "words", $languageType); ?>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-dark--4">
                  <tr class="text-center font-size-7">
                    <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>

                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate">#<?php echo $readBannedHistory["id"]; ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo $readBannedHistory["username"]; ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php if ($readBannedHistory["type"] == "login") { echo languageVariables("site", "words", $languageType); } else if ($readBannedHistory["type"] == "support") { echo languageVariables("support", "words", $languageType); } else if ($readBannedHistory["type"] == "comment") { echo languageVariables("comment", "words", $languageType); } ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo $readBannedHistory["reason"]; ?></td>
                    <?php if ($readBannedHistory["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDate = languageVariables("indefinite", "words", $languageType); } else { if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) { $userBannedBackDate = max(round((strtotime($readBannedHistory["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } else { $userBannedBackDate = languageVariables("end", "words", $languageType); } } ?>

                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $userBannedBackDate; ?></td>

                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo $readBannedHistory["date"]; ?></td>
                    <?php }?>
                  </tr>
                </tbody>
              </table>
              </div>
              <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "danger", "0", "/"); } ?>
              <?php } if ($rSettings["bannedType"] == "1") { ?>
              <?php $searchBannedHistory = $db->prepare("SELECT * FROM PunishmentHistory ORDER BY id DESC"); ?>
              <?php $searchBannedHistory->execute(); ?>
              <?php if ($searchBannedHistory->rowCount() > 0) { ?>
              <div class="overflow-auto">
              <table class="default-table w-100 table table-hover mb-0">
                <thead class="bg-dark--5">
                  <tr class="text-secondary font-size-6">
                    <th class="font-100 p-3 pl-4 line-height-1 w-10 border-0">
                      #
                    </th>
                    <th class="font-100 p-3 line-height-1 w-30 border-0">
                      <?php echo languageVariables("user", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("category", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-30 border-0">
                      <?php echo languageVariables("reason", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("expiryDate", "words", $languageType); ?>
                    </th>
                    <th class="font-100 p-3 line-height-1 w-10 border-0">
                      <?php echo languageVariables("date", "words", $languageType); ?>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-dark--4">
                  <tr class="text-center font-size-7">
                    <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>

                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate">#<?php echo $readBannedHistory["id"]; ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo $readBannedHistory["name"]; ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php echo (($readBannedHistory["punishmentType"] == "BAN") ? languageVariables("normalBan", "words", $languageType) : (($readBannedHistory["punishmentType"] == "TEMP_BAN") ? languageVariables("tempBan", "words", $languageType) : languageVariables("kick", "words", $languageType))); ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-30 text-nowrap text-truncate"><?php echo (($readBannedHistory["reason"] !== "none") ? $readBannedHistory["reason"] : languageVariables("none", "words", $languageType)); ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"><?php if ($readBannedHistory["end"] == "-1") { echo languageVariables("indefinite", "words", $languageType); } else { echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["end"], -13, 10)), 2, true); } ?></td>
                    <td class="p-3 border-bottom font-100 line-height-1 w-10 text-nowrap text-truncate"> <?php echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["start"], -13, 10)), 2, true); ?></td>
                  </tr>
                </tbody>
              </table>
              </div>
              <?php }?>
              <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "danger", "0", "/"); } ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>