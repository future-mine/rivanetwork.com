<!-- CTA -->
<section id="cta" class="relative py-20 bg-center bg-cover <?php echo (($incRequirePage !== "login" && $incRequirePage !== "register" && $incRequirePage !== "recovery") ? "" : "!hidden"); ?>" style="background-image: url('<?php echo $themeDefaultVariables["footerImage"]; ?>')">
  <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-gray-900/75 to-indigo-900/25"></div>
  <div class="z-10 container mx-auto relative items-center flex flex-col justify-center">
    <div class="h2 fw-extrabold text-white text-center"><?php echo languageVariables("footerTitle", "words", $languageType); ?></div>
    <div class="flex gap-3 mt-6">
      <a href="#" class="btn btn-primary fw-medium fs-6"><?php echo $rSettings["IPAdres"]; ?></a>
      <a href="<?php echo ((!isset($_SESSION["incAccountLogin"])) ? urlConverter("register", $languageType) : urlConverter("profile", $languageType)); ?>" class="btn btn-white fs-6 fw-medium"><?php echo ((!isset($_SESSION["incAccountLogin"])) ? languageVariables("register", "words", $languageType) : languageVariables("myProfile", "words", $languageType)); ?></a>
    </div>
  </div>
</section>
</main>
<footer class="bg-gray-100 border-t-2 border-gray-200 relative overflow-hidden <?php echo (($incRequirePage !== "login" && $incRequirePage !== "register" && $incRequirePage !== "recovery") ? "" : "!hidden"); ?>">
  <div class="container mx-auto pb-12 py-6 px-4 relative sm:px-6 lg:px-8 grid grid-cols-2 lg:grid-cols-3">
    <div class="flex gap-3">
      <img class="w-32 hidden md:block" src="<?php echo $rSettings["serverLogo"]; ?>" alt="" style="max-height: 140px;">
      <div class="flex flex-col justify-center">
        <span class="fw-bold fs-5 text-gray-800"><?php echo $rSettings["serverName"]; ?></span>
        <p class="text-gray-400 mt-1"><?php echo $rSettings["metaDescription"]; ?></p>
      </div>
    </div>
    <div class="select-none text-gray-300/20 h1 text-center hidden lg:block"><?php echo $rSettings["serverName"]; ?></div>
    <div class="flex justify-end">
      <div class="flex gap-4 my-auto mx-auto md:mx-0 mt-5">
        <a class="icon bg-pink-400 bg-opacity-25 text-pink-500" target="_blank" href="<?php echo $rMedia["instagram"]; ?>">
          <i class="fab fa-instagram"></i>
        </a>
        <a class="icon bg-red-400 bg-opacity-25 text-red-500" target="_blank" href="<?php echo $rMedia["youtube"]; ?>">
          <i class="fab fa-youtube"></i>
        </a>
        <a class="icon bg-blue-500 bg-opacity-25 text-blue-500" target="_blank" href="<?php echo $rMedia["discord"]; ?>">
          <i class="fab fa-discord"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="bg-gray-300/25 py-3">
    <div class="container mx-auto py-8 px-4 relative sm:px-6 lg:px-8 grid grid-cols-3 mobile-footer-signature">
      <div class="fw-bolder">
        <span class="hidden md:block"><?php echo $rSettings["serverName"]; ?>, <?php echo date("Y"); ?> <?php echo languageVariables("footerCopyright", "words", $languageType); ?></span>
        <img class="invisible md:hidden mt-2" src="<?php echo $rSettings["serverLogo"]; ?>" width="60" height="60">
      </div>
      <div class="relative flex items-center justify-center">
        <div class="absolute top-0 left-0 w-full shadow-3xl shadow-indigo-400/25"></div>
        <div onclick="openJustPlay()" class="relative z-10 cursor-pointer -mt-28 !rounded-2xl !flex items-center justify-center gap-3 btn btn-primary uppercase btn-lg fw-medium">
          <i class="fab fa-google-play fs-5"></i>
          <?php echo languageVariables("justPlay", "words", $languageType); ?>
        </div>
        <div class="absolute -bottom-3">
          <a onclick="openChangeLang()" class="cursor-pointer border-b-2 transition border-indigo-300 hover:border-indigo-500 fs-6 fw-bolder py-2 px-4 text-primary"><?php echo languageVariables("languageChange", "words", $languageType); ?></a>
        </div>
    </div>
  </div>

<!-- Modals -->
<!-- Profile menu modal -->
<div id="profileMenu" class="hidden fixed top-0 left-0 w-full h-full flex z-[105]">
  <a onclick="closeProfileMenu()" class="absolute top-0 left-0 w-full h-full bg-black/25"></a>
  <div class="grow"></div>
  <div id="profileMenuNav" class="bg-white w-3/4 max-w-[28rem] h-full transform translate-x-full transition-all" style="padding-bottom: 6rem;">
    <div class="flex justify-between items-center py-6 px-12 bg-gray-100 border-b-2 border-gray-200">
      <div class="flex"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/40" alt="" width="40" height="40"><span class="mt-2 ml-2" style="font-size: 1.2rem;"><?php echo $readAccount["username"]; ?></span></div>
      <div class="btn btn-white fw-bold fs-4" onclick="closeProfileMenu()">
        <i class="fa fa-times"></i>
      </div>
    </div>
    <div class="grid grid-cols-2 relative overflow-y-auto h-[inherit]">
      <a href="<?php echo urlConverter("profile", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-violet-400 bg-opacity-10 hover:bg-violet-500">
        <div class="flex w-12 h-12 items-center justify-center bg-violet-400 bg-opacity-25 rounded-xl">
          <i class="fas fa-user text-violet-900 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-900 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("myProfile", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("profile_message", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-pink-400/10 hover:bg-pink-500">
        <div class="flex w-12 h-12 items-center justify-center bg-pink-400/25 rounded-xl">
          <i class="fas fa-message text-pink-500 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("messages", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-yellow-400/10 hover:bg-yellow-500">
        <div class="flex w-12 h-12 items-center justify-center bg-yellow-400/25 rounded-xl">
          <span class="fs-7 fw-bold text-warning group-hover:text-white transition"><?php echo $readAccount["credit"]; ?></span>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("credi", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("credit_send", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-yellow-400/10 hover:bg-yellow-500">
        <div class="flex w-12 h-12 items-center justify-center bg-yellow-400/25 rounded-xl">
          <span class="fs-7 fw-bold text-warning group-hover:text-white transition"><?php echo $readAccount["credit"]; ?></span>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("creditSend", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("cart", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-gray-400/10 hover:bg-gray-800">
        <div class="flex w-12 h-12 items-center justify-center bg-gray-400/25 rounded-xl">
          <i class="fas fa-shopping-bag text-gray-600 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("cart", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("chest", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-emerald-400/10 hover:bg-emerald-500">
        <div class="flex w-12 h-12 items-center justify-center bg-emerald-400/25 rounded-xl">
          <i class="fas fa-box text-success group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("chest", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("inventory", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-blue-400/10 hover:bg-blue-500">
        <div class="flex w-12 h-12 items-center justify-center bg-blue-400/25 rounded-xl">
          <i class="fas fa-layer-group text-blue-500 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("inventory", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("gift_coupon", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-purple-400/10 hover:bg-purple-500">
        <div class="flex w-12 h-12 items-center justify-center bg-purple-400/25 rounded-xl">
          <i class="fas fa-gift text-purple-500 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></span>
      </a>
      <a href="<?php echo urlConverter("card_game", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-indigo-400/10 hover:bg-indigo-700">
        <div class="flex w-12 h-12 items-center justify-center bg-indigo-400/25 rounded-xl">
          <i class="fas fa-vr-cardboard text-indigo-500 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("cardGame", "words", $languageType); ?></span>
      </a>
      <?php if(AccountPermControl($readAccount['id'], "panel_login") == "AUTHORİZATİON_APPROVED") { ?>
      <a href="<?php echo urlConverter("admin", $languageType); ?>" target="_blank" class="group flex flex-col justify-center items-center transition p-8 bg-red-400/10 hover:bg-red-500">
        <div class="flex w-12 h-12 items-center justify-center bg-red-400/25 rounded-xl">
          <i class="fas fa-chart-line text-danger group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("admin", "words", $languageType); ?></span>
      </a>
      <?php } ?>
      <a href="<?php echo urlConverter("logout", $languageType); ?>" class="group flex flex-col justify-center items-center transition p-8 bg-gray-400/10 hover:bg-gray-900">
        <div class="flex w-12 h-12 items-center justify-center bg-gray-400/25 rounded-xl">
          <i class="fas fa-sign-out text-gray-800 group-hover:text-white transition"></i>
        </div>
        <span class="text-gray-600 fw-bolder group-hover:text-white transition mt-4"><?php echo languageVariables("logout", "words", $languageType); ?></span>
      </a>
    </div>
  </div>
</div>
<!-- Mobile menu modal -->
<div id="mobileMenu" class="hidden fixed top-0 left-0 w-full h-full flex z-[105]">
  <a onclick="closeMobileMenu()" class="absolute top-0 left-0 w-full h-full bg-black/25"></a>
  <div class="grow"></div>
  <div id="mobileMenuNav" class="bg-white w-3/4 max-w-[28rem] h-full transform translate-x-full transition-all">
    <div class="flex justify-between items-center py-6 px-12 bg-gray-100 border-b-2 border-gray-200">
      <a href="/">
        <img class="w-20" src="<?php echo $rSettings["serverLogo"]; ?>">
      </a>
      <div class="btn btn-white fw-bold fs-4" onclick="closeMobileMenu()">
        <i class="fa fa-times"></i>
      </div>
    </div>
    <div class="grid divide-y divide-gray-200/25">
      <a href="<?php echo urlConverter("home", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "home") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-home mr-2"></i><?php echo languageVariables("home", "words", $languageType); ?>
      </a>
      <?php if ($readModule["forumStatus"] == "1") { ?>
      <a href="<?php echo urlConverter("forum", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "forum") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-message mr-2"></i><?php echo languageVariables("forum", "words", $languageType); ?>
      </a>
      <?php } ?>
      <a href="<?php echo urlConverter("store", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "store") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-store mr-2"></i><?php echo languageVariables("store", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("support", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "support") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-life-ring mr-2"></i><?php echo languageVariables("support", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "help-center") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-question mr-2"></i><?php echo languageVariables("helpCenter", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "credit") ? "bg-indigo-400/25" : ""); ?>">
        <i class="mr-2"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></i><?php echo languageVariables("credi", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("gift_coupon", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "coupon") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-gift mr-2"></i><?php echo languageVariables("giftCoupon", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("lottery", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "lottery") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-ticket mr-2"></i><?php echo languageVariables("lottery", "words", $languageType); ?>
      </a>
      <a href="<?php echo urlConverter("rules", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "rules") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-book mr-2"></i><?php echo languageVariables("rules", "words", $languageType); ?>
      </a>
      <?php if ($readModule["voteSystemStatus"] == "1") { ?>
      <a href="<?php echo urlConverter("vote", $languageType); ?>" class="py-4 px-6 fw-bold text-dark <?php echo (($incRequirePage == "vote") ? "bg-indigo-400/25" : ""); ?>">
        <i class="fas fa-check-to-slot mr-2"></i><?php echo languageVariables("vote", "words", $languageType); ?>
      </a>
      <?php } ?>
    </div>
  </div>
</div>
<!-- Just Play modal -->
<div id="justPlay" class="hidden fixed top-0 left-0 w-full h-full flex flex-col z-[105]">
  <a onclick="closeJustPlay()" class="absolute top-0 left-0 w-full h-full bg-black/25"></a>
  <div class="grow"></div>
  <div id="justPlayContent" class="bg-white w-full h-[20rem] mx-auto transform translate-y-full transition-all" style="background: url('/assets/uploads/images/landing/images/default/dirt.png'); border-radius: 3rem 3rem 0 0;">
      <div class="join-now-modal p-12 max-w-2xl mx-auto">
        <div class="grid lg:grid-cols-12">
          <div class="lg:col-span-12">
            <div style="margin-top: -2rem;">
              <div class="w-75">
                <span class="ip-title"><?php echo languageVariables("serverIP", "words", $languageType); ?></span>
                <div class="ip-box">
                  <span class="ip"><?php echo $rSettings["IPAdres"]; ?></span>
                </div>
                <button class="join-btn" onclick="copyIp()"><?php echo languageVariables("serverJoin", "words", $languageType); ?></button>
                <button class="join-btn mt-2" onclick="closeJustPlay()"><?php echo languageVariables("cancel", "words", $languageType); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<!-- MODAL -->
<div id="panelModal" class="hidden fixed w-full h-full flex flex-col z-[105]" style="padding: 110px 30%;">
  <a onclick="closePanelModal()" class="absolute top-0 left-0 w-full h-full bg-black/50"></a>
  <div class="grow"></div>
  <div id="panelModalContent" class="bg-white rounded-3xl w-full h-[28rem] transform translate-y-full transition-all overflow-hdn">
    <?php echo $themeDefaultVariables["alertModal"]; ?>
  </div>
</div>
<!-- Change language modal -->
<div id="changeLang" class="hidden fixed top-0 left-0 w-full h-full flex flex-col z-[105]">
  <a onclick="closeChangeLang()" class="absolute top-0 left-0 w-full h-full bg-black/25"></a>
  <div class="grow"></div>
  <div id="changeLangContent" class="bg-white rounded-t-3xl w-full h-[28rem] transform translate-y-full transition-all">
    <div class="p-12 max-w-2xl mx-auto">
      <h4 class="h3 text-center"><?php echo languageVariables("languageSelect", "words", $languageType); ?></h4>
      <?php $languageListF = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
      <div class="mt-6 grid grid-cols-1 lg:grid-cols-1">
        <?php foreach ($languageListF as $readList) { ?>
        <a href="/main/index.php?language=<?php echo $readList["code"]; ?>&ref=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="cursor-pointer text-gray-800 fw-bolder py-3 px-6 <?php echo (($readList["code"] == $languageType) ? "flex items-center bg-gray-100" : "transition hover:bg-gray-100"); ?>"><?php echo $readList["title"]; ?> <?php if ($readList["code"] == $languageType) { ?><span class="ml-auto rounded-lg py-1 px-2 fs-7 text-primary bg-indigo-400/25"><?php echo languageVariables("selected", "words", $languageType); ?></span><?php } ?></a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>