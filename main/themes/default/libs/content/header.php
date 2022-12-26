<header class="relative <?php echo (($incRequirePage !== "login" && $incRequirePage !== "register" && $incRequirePage !== "recovery") ? "" : "!hidden"); ?>">
  <div class="relative bg-indigo-600">
    <div class="absolute top-0 left-0 bg-cover bg-center w-full h-full" style="background-image: url('<?php echo $themeDefaultVariables["headerImage"]; ?>')">
      <?php if ($themeDefaultVariables["headerBlur"] == "1") { ?>
      <div class="backdrop-blur-sm bg-indigo-500/40 w-full h-full"></div>
      <?php } ?>
    </div>
    <div class="relative z-30 container mx-auto grid grid-cols-3 gap-3 py-16">
      <div class="hidden md:block">
        <a onclick="copyIp()" class="cursor-pointer rounded-2xl flex gap-8 items-center relative overflow-hidden group p-6">
          <div class="relative z-10 flex items-center justify-center p-6 bg-indigo-100 rounded-3xl">
            <i class="fas fa-copy text-3xl text-indigo-500"></i>
          </div>
          <div class="relative z-10">
            <input type="text" value="<?php echo $rSettings["IPAdres"]; ?>" class="hidden" id="server-ip">
            <p class="fw-extrabold text-indigo-50 h3"><?php echo $rSettings["IPAdres"]; ?></p>
            <span class="text-indigo-100/75 fs-6 fw-medium"><span server-command="serverOnlineStatus" server-ip="<?php echo $rSettings['IPAdres']; ?>">-/-</span> <?php echo languageVariables("serverOnlineText", "words", $languageType); ?></span>
          </div>
          <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
            <span class="w-2 h-2 bg-indigo-400/40 rounded-3xl transition-all group-hover:w-full group-hover:h-full"></span>
          </div>
        </a>
      </div>
      <div class="flex items-center justify-center col-span-3 md:col-span-1">
        <img class="mx-auto" style="max-width: 240px; max-height: 160px;" src="<?php echo $rSettings["serverLogo"]; ?>" alt="">
      </div>
      <div class="hidden md:block">
        <a href="<?php echo $rMedia["discord"]; ?>" target="_blank" class="cursor-pointer rounded-2xl flex gap-8 items-center relative justify-end overflow-hidden group p-6">
          <div class="relative z-10 text-right">
            <p class="fw-extrabold text-indigo-50 h3" server-command="discordServerName">Discord</p>
            <span class="text-indigo-100/75 fs-6 fw-medium"><span server-command="discordServerOnlineStatus" discord-widget="<?php echo $rMedia["widget"]; ?>">-/-</span> <?php echo languageVariables("onlineUser", "words", $languageType); ?></span>
          </div>
          <div class="relative z-10 flex items-center justify-center p-6 bg-indigo-100 rounded-3xl">
            <i class="fab fa-discord text-3xl text-indigo-500"></i>
          </div>
          <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
            <span class="w-2 h-2 bg-indigo-400/40 rounded-3xl transition-all group-hover:w-full group-hover:h-full"></span>
          </div>
        </a>
      </div>
    </div>
    <?php if ($themeDefaultVariables["navbarType"] == "1") { ?>
    <svg class="w-full relative z-30 fill-gray-100 top-px" viewBox="0 0 1440 47" xmlns="http://www.w3.org/2000/svg">
      <path d="M69.5 22.151C26.7767 25.091 -1 46.6511 -1 46.6511H1441C1441 46.6511 1371.59 25.2764 1338.5 22.1511C1301.05 18.6141 1274.03 36.5938 1236.5 39.1511C1158.03 44.4982 1161.15 10.0009 1082.5 10.1509C1032.27 10.2467 897.5 32.6509 849 32.6509C805.727 32.6509 803.2 30.6647 760 28.1508C706.372 25.0302 636.552 2.68875 589.5 0.651018C462.5 -4.84915 463.844 26.1238 345.5 32.6509C286.419 35.9094 232.169 0.162976 173 0.651092C122.94 1.06406 119.444 18.7141 69.5 22.151Z" />
    </svg>
    <?php } ?>
  </div>
  <div id="navbar" class="border-b-2 border-gray-200 pt-4 pb-5 bg-gray-100 relative z-10">
    <div class="nav">
      <nav class="left-column nav-menu gap-2">
        <a href="<?php echo urlConverter("home", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "home") ? "active" : ""); ?>">
          <i class="fas fa-home mr-2"></i><?php echo languageVariables("home", "words", $languageType); ?>
        </a>
        <?php if ($readModule["forumStatus"] == "1") { ?>
        <a href="<?php echo urlConverter("forum", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "forum") ? "active" : ""); ?>">
          <i class="fas fa-message mr-2"></i><?php echo languageVariables("forum", "words", $languageType); ?>
        </a>
        <?php } ?>
        <a href="<?php echo urlConverter("store", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "store") ? "active" : ""); ?>">
          <i class="fas fa-store mr-2"></i><?php echo languageVariables("store", "words", $languageType); ?>
        </a>
        <a href="<?php echo urlConverter("support", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "support") ? "active" : ""); ?>">
          <i class="fas fa-life-ring mr-2"></i><?php echo languageVariables("support", "words", $languageType); ?>
        </a>
        <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "help-center") ? "active" : ""); ?>">
          <i class="fas fa-question mr-2"></i><?php echo languageVariables("helpCenter", "words", $languageType); ?>
        </a>
        <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "credit") ? "active" : ""); ?>">
          <i class="mr-2"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></i><?php echo languageVariables("credi", "words", $languageType); ?>
        </a>
        <a href="<?php echo urlConverter("lottery", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "lottery") ? "active" : ""); ?>">
          <i class="fas fa-ticket mr-2"></i><?php echo languageVariables("lottery", "words", $languageType); ?>
        </a>
        <a href="<?php echo urlConverter("rules", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "rules") ? "active" : ""); ?>">
          <i class="fas fa-book mr-2"></i><?php echo languageVariables("rules", "words", $languageType); ?>
        </a>
        <?php if ($readModule["voteSystemStatus"] == "1") { ?>
        <a href="<?php echo urlConverter("vote", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "vote") ? "active" : ""); ?>">
          <i class="fas fa-check-to-slot mr-2"></i><?php echo languageVariables("vote", "words", $languageType); ?>
        </a>
        <?php } ?>
      </nav>
      <div class="right-column">
        <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
        <a href="<?php echo urlConverter("login", $languageType); ?>" class="btn btn-white"><?php echo languageVariables("login", "words", $languageType); ?></a>
        <a href="<?php echo urlConverter("register", $languageType); ?>" class="btn btn-primary"><?php echo languageVariables("register", "words", $languageType); ?></a>
        <?php } else { ?>
        <a onclick="openProfileMenu()" class="cursor-pointer btn !flex gap-3 btn-primary fs-6">
          <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/28" alt="" width="28" height="18">
          <?php echo $readAccount["username"]; ?>
        </a>
        <?php } ?>
      </div>

      <!--  Mobile  -->
      <div class="fs-5 fw-extrabold text-dark lg:hidden cursor-pointer" onclick="openMobileMenu()"><i class="fas fa-bars-staggered"></i></div>
      <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
      <a href="<?php echo urlConverter("login", $languageType); ?>" class="lg:!hidden cursor-pointer btn !flex gap-3 btn-primary fs-6">
        <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/steve/28" alt="" width="28" height="18">
        <?php echo languageVariables("login", "words", $languageType); ?>
      </a>
      <?php } else { ?>
      <a onclick="openProfileMenu()" class="lg:!hidden cursor-pointer btn !flex gap-3 btn-primary fs-6">
        <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/28" alt="" width="28" height="18">
        <?php echo $readAccount["username"]; ?>
      </a>
      <?php } ?>
    </div>
  </div>
  <div id="fixedNavbar" class="hidden">
    <div class="relative overflow-hidden py-2 bg-indigo-500/75">
      <div class="bg-indigo-900/40 backdrop-blur-sm w-full h-full absolute top-0 left-0"></div>
      <div class="relative z-10 container mx-auto">
        <div class="nav2">
          <nav class="left-column nav-menu">
            <a href="<?php echo urlConverter("home", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "home") ? "active" : ""); ?>">
              <i class="fas fa-home mr-2"></i><?php echo languageVariables("home", "words", $languageType); ?>
            </a>
            <?php if ($readModule["forumStatus"] == "1") { ?>
            <a href="<?php echo urlConverter("forum", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "store") ? "active" : ""); ?>">
              <i class="fas fa-message mr-2"></i><?php echo languageVariables("forum", "words", $languageType); ?>
            </a>
            <?php } ?>
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "store") ? "active" : ""); ?>">
              <i class="fas fa-store mr-2"></i><?php echo languageVariables("store", "words", $languageType); ?>
            </a>
            <a href="<?php echo urlConverter("support", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "support") ? "active" : ""); ?>">
              <i class="fas fa-life-ring mr-2"></i><?php echo languageVariables("support", "words", $languageType); ?>
            </a>
            <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "help-center") ? "active" : ""); ?>">
              <i class="fas fa-question mr-2"></i><?php echo languageVariables("helpCenter", "words", $languageType); ?>
            </a>
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "credit") ? "active" : ""); ?>">
              <i class="mr-2"><?php echo languageVariables("currencyIcon", "words", $languageType); ?></i><?php echo languageVariables("credi", "words", $languageType); ?>
            </a>
            <a href="<?php echo urlConverter("lottery", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "lottery") ? "active" : ""); ?>">
              <i class="fas fa-ticket mr-2"></i><?php echo languageVariables("lottery", "words", $languageType); ?>
            </a>
            <a href="<?php echo urlConverter("rules", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "rules") ? "active" : ""); ?>">
              <i class="fas fa-book mr-2"></i><?php echo languageVariables("rules", "words", $languageType); ?>
            </a>
            <?php if ($readModule["voteSystemStatus"] == "1") { ?>
            <a href="<?php echo urlConverter("vote", $languageType); ?>" class="nav-item <?php echo (($incRequirePage == "vote") ? "active" : ""); ?>">
              <i class="fas fa-check-to-slot mr-2"></i><?php echo languageVariables("vote", "words", $languageType); ?>
            </a>
            <?php } ?>
          </nav>
          <div class="right-column">
            <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
            <a href="<?php echo urlConverter("login", $languageType); ?>" class="btn btn-white"><?php echo languageVariables("login", "words", $languageType); ?></a>
            <a href="<?php echo urlConverter("register", $languageType); ?>" class="btn btn-primary"><?php echo languageVariables("register", "words", $languageType); ?></a>
            <?php } else { ?>
            <a onclick="openProfileMenu()" class="cursor-pointer btn !flex gap-3 btn-primary fs-6">
              <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/28" alt="" width="28" height="18">
              <?php echo $readAccount["username"]; ?>
            </a>
            <?php } ?>
          </div>
          <div class="fs-5 fw-extrabold text-white lg:hidden cursor-pointer" onclick="openMobileMenu()"><i class="fas fa-bars-staggered"></i></div>
          <?php if (!isset($_SESSION["incAccountLogin"])) { ?>
          <a href="<?php echo urlConverter("login", $languageType); ?>" class="lg:!hidden cursor-pointer btn !flex gap-3 btn-primary fs-6">
            <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/steve/28" alt="" width="28" height="18">
            <?php echo languageVariables("login", "words", $languageType); ?>
          </a>
          <?php } else { ?>
          <a onclick="openProfileMenu()" class="lg:!hidden cursor-pointer btn !flex gap-3 btn-primary fs-6">
            <img class="w-6 h-6 rounded-lg" src="https://minotar.net/avatar/<?php echo $readAccount["username"]; ?>/28" alt="" width="28" height="18">
            <?php echo $readAccount["username"]; ?>
          </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div id="particles-js" class="absolute z-20 bottom-0 left-0 w-full h-full <?php echo (($themeDefaultVariables["headerParticles"] == "1") ? "" : "!hidden"); ?>"></div>
</header>
<main class="relative">
  <div class="absolute top-0 left-0 w-full h-full opacity-50 body-image"></div>