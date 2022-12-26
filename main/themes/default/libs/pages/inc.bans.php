<section class="py-16">
  <div class="container mx-auto px-4 md:px-0">
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
            <a href="<?php echo urlConverter("banned", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("bans", "words", $languageType); ?></a>
          </div>
        </li>
      </ol>
    </nav>
  </div>
  <div class="container mx-auto grid lg:grid-cols-12 gap-10 mt-10 px-4 md:px-0">
    <div class="mt-6 card overflow-x-auto w-full col-span-12">
      <?php if ($rSettings["bannedType"] == "0") { ?>
      <?php $searchBannedHistory = $db->prepare("SELECT * FROM banned ORDER BY id DESC"); ?>
      <?php $searchBannedHistory->execute(); ?>
      <?php if ($searchBannedHistory->rowCount() > 0) { ?>
      <table class="w-full text-left relative z-10">
        <thead>
          <tr class="text-xs uppercase text-white font-medium bg-indigo-900 relative">
            <th class="py-4 px-3 relative z-10">ID</th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("category", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("reason", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("expiryDate", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"></th>
          </tr>
        </thead>
        <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
        <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
          <tr class="hover:bg-gray-100">
            <td class="font-normal p-3">#<?php echo $readBannedHistory["id"]; ?></td>
            <td class="font-normal p-3"><a href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readBannedHistory["username"]; ?>"><?php echo $readBannedHistory["username"]; ?></a></td>
            <td class="font-normal p-3"><?php if ($readBannedHistory["type"] == "login") { echo languageVariables("site", "words", $languageType); } else if ($readBannedHistory["type"] == "support") { echo languageVariables("support", "words", $languageType); } else if ($readBannedHistory["type"] == "comment") { echo languageVariables("comment", "words", $languageType); } ?></td>
            <td class="font-normal p-3"><?php echo $readBannedHistory["reason"]; ?></td>
            <?php if ($readBannedHistory["bannedDate"] == "1000-01-01 00:00:00") { $userBannedBackDate = languageVariables("indefinite", "words", $languageType); } else { if ($readBannedHistory["bannedDate"] > date("Y-m-d H:i:s")) { $userBannedBackDate = max(round((strtotime($readBannedHistory["bannedDate"]) - strtotime(date("Y-m-d H:i:s"))) / 86400), 0).' '.languageVariables("day", "words", $languageType); } else { $userBannedBackDate = languageVariables("end", "words", $languageType); } } ?>
            <td class="font-normal p-3"><?php echo $userBannedBackDate; ?></td>
            <td class="font-normal p-3"><?php echo $readBannedHistory["date"]; ?></td>
            <td class="font-normal p-3 flex gap-3">
              <div class="cursor-pointer bg-red-500 text-white py-1 px-2 rounded-xl">
                <i class="fas fa-times text-sm"></i>
              </div>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "warning", "0", "/"); } ?>
      <?php } if ($rSettings["bannedType"] == "1") { ?>
      <?php $searchBannedHistory = $db->prepare("SELECT * FROM PunishmentHistory ORDER BY id DESC"); ?>
      <?php $searchBannedHistory->execute(); ?>
      <?php if ($searchBannedHistory->rowCount() > 0) { ?>
        <table class="w-full text-left relative z-10">
        <thead>
          <tr class="text-xs uppercase text-white font-medium bg-indigo-900 relative">
            <th class="py-4 px-3 relative z-10">ID</th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("username", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("category", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("reason", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("expiryDate", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"><?php echo languageVariables("date", "words", $languageType); ?></th>
            <th class="py-4 px-3 relative z-10"></th>
          </tr>
        </thead>
        <tbody class="text-gray-500 dark:text-green-400/75 text-sm">
        <?php foreach ($searchBannedHistory as $readBannedHistory) { ?>
          <tr class="hover:bg-gray-100">
            <td class="font-normal p-3">#<?php echo $readBannedHistory["id"]; ?></td>
            <td class="font-normal p-3"><a href="<?php echo urlConverter("player", $languageType); ?>/<?php echo $readBannedHistory["name"]; ?>"><?php echo $readBannedHistory["name"]; ?></a></td>
            <td class="font-normal p-3"><?php echo (($readBannedHistory["punishmentType"] == "BAN") ? languageVariables("normalBan", "words", $languageType) : (($readBannedHistory["punishmentType"] == "TEMP_BAN") ? languageVariables("tempBan", "words", $languageType): languageVariables("kick", "words", $languageType))); ?></td>
            <td class="font-normal p-3"><?php echo (($readBannedHistory["reason"] !== "none") ? $readBannedHistory["reason"] : languageVariables("none", "words", $languageType)); ?></td>
            <td class="font-normal p-3"><?php if ($readBannedHistory["end"] == "-1") { echo languageVariables("indefinite", "words", $languageType); } else { echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["end"], -13, 10)), 2, true); } ?></td>
            <td class="font-normal p-3"><?php echo checkTime(date('Y-m-d H:i:s', substr($readBannedHistory["start"], -13, 10)), 2, true); ?></td>
            <td class="font-normal p-3 flex gap-3">
              <div class="cursor-pointer bg-red-500 text-white py-1 px-2 rounded-xl">
                <i class="fas fa-times text-sm"></i>
              </div>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <?php } else { echo alert(languageVariables("alert", "bans", $languageType), "danger", "0", "/"); } ?>
      <?php } ?>
    </div>
  </div>
</section>