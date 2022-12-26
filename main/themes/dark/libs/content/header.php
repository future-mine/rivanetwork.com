<div class="loader d-flex position-fixed text-uppercase align-items-center justify-content-center text-white font-900 letter-spacing-2">
  <span class="d-none"><?php echo $rSettings['serverName'];?></span>
</div>
<?php 
    if ($readModule["broadcastStatus"] == "1") {
      $searchBroadcastOne = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT 4");
      if ($searchBroadcastOne->rowCount() > 0) {
  ?>
<div class="broadcast w-100 d-block p-0 m-0">
  <div class="container">
    <ul class="d-flex flex-row js-marquee align-items-center letter-spacing-0 py-4 m-0 navbar-nav position-relative overflow-hidden">
      <?php foreach ($searchBroadcastOne as $readBroadcastOne) { ?>
      <li class="font-100 broadcast-item font-size-6 o-75">
        <a class="text-decoration-none text-white" href="<?php echo $readBroadcastOne["url"]; ?>">
          <?php echo $readBroadcastOne["title"]; ?>
        </a>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php } } ?>
<div class="navbar-wrapper position-relative">
  <nav class="navbar navbar-top navbar-expand-lg navbar-dark bg-dark--2 p-0 border-dark border-bottom">
    <div class="container">
      <button class="navbar-toggler d-lg-none text-white d-flex align-items-center justify-content-center p-4" type="button" data-toggle="collapse" data-target="#navbar-top-content" aria-controls="navbar-top-content" aria-expanded="false" aria-label="Toggle navigation">
        <div class="btn-lines">
          <span class="btn-line"></span>
          <span class="btn-line"></span>
          <span class="btn-line"></span>
        </div>
      </button>
      <div class="collapse navbar-collapse" id="navbar-top-content">
        <div class="d-flex w-100 justify-content-between align-items-center flex-lg-row flex-column-reverse p-lg-0 p-4">
          <div class="d-lg-none">
            <nav class="navbar navbar-expand nav-alt-nav bg-dark--4 mt-3">
              <ul class="navbar-nav font-100 mx-0 row p-1 py-0 position-relative">
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("home", $languageType); ?>" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="mx-2"><?php echo languageVariables("home", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("store", $languageType); ?>" class="nav-link">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="mx-2"><?php echo languageVariables("store", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    <span class="mx-2"><?php echo languageVariables("creditUpload", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("support", $languageType); ?>" class="nav-link">
                    <i class="fas fa-concierge-bell"></i>
                    <span class="mx-2"><?php echo languageVariables("support", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="nav-link">
                    <i class="fas fa-question"></i>
                    <span class="mx-2"><?php echo languageVariables("helpCenter", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("gift_coupon", $languageType); ?>" class="nav-link">
                    <i class="fas fa-gift"></i>
                    <span class="mx-2"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("card_game", $languageType); ?>" class="nav-link">
                    <i class="fas fa-sd-card"></i>
                    <span class="mx-2"><?php echo languageVariables("cardGame", "words", $languageType); ?></span>
                  </a>
                </li>
                <?php if ($readModule["voteSystemStatus"] == 0) { ?>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("rules", $languageType); ?>" class="nav-link">
                    <i class="fas fa-book"></i>
                    <span class="mx-2"><?php echo languageVariables("rules", "words", $languageType); ?></span>
                  </a>
                </li>
                <?php } else { ?>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("vote", $languageType); ?>" class="nav-link">
                    <i class="fas fa-check-circle"></i>
                    <span class="mx-2"><?php echo languageVariables("vote", "words", $languageType); ?></span>
                  </a>
                </li>
                <?php } ?>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("inventory", $languageType); ?>" class="nav-link">
                    <i class="fas fa-boxes"></i>
                    <span class="mx-2"><?php echo languageVariables("inventory", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("chest", $languageType); ?>" class="nav-link">
                    <i class="fas fa-archive"></i>
                    <span class="mx-2"><?php echo languageVariables("chest", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="nav-item col-6 col-sm-4 col-md-3 text-center p-2">
                  <a href="<?php echo urlConverter("cart", $languageType); ?>" class="nav-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="mx-2"><?php echo languageVariables("cart", "words", $languageType); ?></span>
                  </a>
                </li>
              </ul>
            </nav>
            <?php $searchLastNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT 1"); ?>
            <?php if ($searchLastNews->rowCount() > 0) { ?>
            <?php $readLastNews = $searchLastNews->fetch(); ?>
            <div class="last-article bg-dark--4 mt-3 p-4">
              <div class="last-article-head font-100 text-white w-100 d-flex justify-content-between">
                <p class="d-inline">
                <?php echo languageVariables("lastNew", "words", $languageType); ?>:
                </p>
              </div>
              <div class="last-article-body w-100 bg-dark--2 text-white p-5 text-center" style="background-image: linear-gradient(to top, rgb(38 38 38 / 88%), rgb(38 38 38 / 84%)), url(<?php echo $readLastNews["image"]; ?>); background-size: cover;">
                <h1 class="font-500 mb-1">
                  <?php echo $readLastNews["title"]; ?>
                </h1>
                <p class="font-100 o-75 mb-4 line-height-1">
                  <?php echo contentShort(strip_tags($readLastNews["text"]), 150); ?>
                </p>
                <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readLastNews["title"]); ?>/<?php echo $readLastNews["id"]; ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary w-100">
                  <i class="fas fa-bookmark fa-sm mr-1 btn-icon"></i>
                  <span class="btn-text">
                  <?php echo languageVariables("moreRead", "words", $languageType); ?>
                  </span>
                </a>
              </div>
            </div>
            <?php } ?>
          </div>
          <button class="ip w-100 mt-lg-0 mt-3 p-lg-0 p-4 text-white font-100 d-flex align-items-center justify-content-lg-start justify-content-center cursor-pointer" type="button" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("copyIP", "words", $languageType); ?>" data-clipboard-text="<?php echo $rSettings['IPAdres'];?>">
            <i class="fas fa-mouse-pointer mr-3 js-mirror"></i>
            <span class="ip-text mr-1"><?php echo $rSettings['IPAdres'];?></span><span class="ip-playing"> — <span server-command="serverOnlineStatus" server-ip="<?php echo $rSettings['IPAdres'];?>">-/-</span> <?php echo languageVariables("serverOnlineText", "words", $languageType); ?></span>
          </button>
          <?php if (isset($_SESSION["incAccountLogin"])):?>
          <div class="profile text-white d-flex align-items-center justify-conten-lg-left justify-content-between">
            <div class="mirrored-ellipse-wrapper d-lg-none">
              <div class="mirrored-ellipse"></div>
            </div>
            <div class="dropdown d-flex align-items-center flex-lg-row flex-row-reverse">
              <!-- PROFILE INFO -->
              <div class="profile-text text-lg-right text-left text-nowrap font-100 btn font-100 font-size-8 text-white" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="navbar-profile-dropdown">
                <span class="username"><?php echo $readAccount["username"];?></span>
                <span class="balance line-height-1 mt-lg-n1 mt-0 d-block text-secondary">
                  <span class="balance-amount"><?php echo $readAccount['credit'];?></span> <?php echo languageVariables("credi", "words", $languageType); ?>
                </span>
              </div>
              <!-- / PROFILE INFO -->

              <!-- DROPDOWN BUTTON -->
              <button class="btn line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 text-white ml-lg-1 ml-3 mr-1 mr-lg-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="navbar-profile-dropdown">
                <i class="fas fa-xs fa-chevron-circle-down"></i>
              </button>
              <!-- / DROPDOWN BUTTON -->

              <!-- DROPDOWN MENU -->
              <div class="dropdown-menu p-0 bg-dark--4 rounded-0 mr-3 mt-4" aria-labelledby="navbar-profile-dropdown">
                <!-- CONTAINER -->
                <div class="d-flex flex-wrap">
                  <!-- MENU-ITEMS -->
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("profile", $languageType); ?>">
                    <i class="fas fa-user fa-lg text-white"></i>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("myProfile", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("credit_upload", $languageType); ?>">
                    <div class="dropdown-item-text-icon">
                      <?php echo $readAccount['credit']; ?><?php echo languageVariables("credi", "words", $languageType); ?>
                    </div>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("creditUpload", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("credit_send", $languageType); ?>">
                    <div class="dropdown-item-text-icon">
                      <?php echo $readAccount['credit']; ?><?php echo languageVariables("credi", "words", $languageType); ?>
                    </div>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("creditSend", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("chest", $languageType); ?>">
                    <div class="dropdown-item-text-icon">
                      <i class="fas fa-archive"></i>
                    </div>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("chest", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("inventory", $languageType); ?>">
                    <div class="dropdown-item-text-icon">
                      <i class="fas fa-boxes"></i>
                    </div>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("inventory", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("cart", $languageType); ?>">
                    <div class="dropdown-item-text-icon">
                      <i class="fas fa-shopping-bag"></i>
                    </div>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("cart", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("gift_coupon", $languageType); ?>">
                    <i class="fas fa-gift text-white fa-lg"></i>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("giftCoupon", "words", $languageType); ?>
                    </span>
                  </a>
                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("card_game", $languageType); ?>">
                    <i class="fas fa-sd-card text-white fa-lg"></i>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("cardGame", "words", $languageType); ?>
                    </span>
                  </a>
                  <?php if(AccountPermControl($readAccount['id'], "panel_login") == "AUTHORİZATİON_APPROVED"):?>

                  <a class="dropdown-item py-4 w-50 d-flex align-items-center flex-column" href="<?php echo urlConverter("admin", $languageType); ?>" target="_blank">
                    <i class="fas fa-user-secret text-white fa-lg"></i>
                    <span class="dropdown-item-text text-secondary font-100 d-block">
                    <?php echo languageVariables("admin", "words", $languageType); ?>
                    </span>
                  </a>
                  <?php endif;?>
                  <!-- / MENU-ITEMS -->
                  <div class="p-2 d-flex w-100 bg-dark--5">
                    <div class="input-group flex-column bg-dark--5 border mr-2 p-0 input-focused">
                      <label for="dropdown-search" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute text-center"><i class="fas fa-search fa-xs mr-1"></i>Oyuncu Ara</label>
                      <input type="text" name="search" placeholder="Oyuncu Ara" required="required" class="form-control pt-4 text-white font-size-7 py-2 w-100 font-100 rounded-none" aria-label="Bir şeyler ara" id="dropdown-search" aria-describedby="dropdown-search" data-toggle="searchAccount">
                    </div>
                    <button type="button" data-toggle="searchAccountButton" class="h-100 btn-outline-primary p-5 btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6">
                      <i class="fas fa-search fa-xs"></i>
                    </button>
                  </div>
                  <!-- LOG OUT -->
                  <a class="dropdown-item log-out bg-dark--5 w-100 d-flex align-items-center justify-content-center" href="<?php echo urlConverter("logout", $languageType); ?>">
                    <i class="fas fa-xs mr-2 mb-1 fa-sign-out-alt text-white"></i>
                    <span class="dropdown-item-text text-uppercase mt-0 p-0 font-100 letter-spacing-1 text-white font-100 d-block">
                    <?php echo languageVariables("logout", "words", $languageType); ?>
                    </span>
                  </a>
                  <!-- / LOG OUT -->
                </div>
                <!-- / CONTAINER -->
              </div>
              <!-- / DROPDOWN MENU -->
            </div>
            <div class="mc-skin right">
              <div class="mc-skin-img-wrapper js-mirror">
                <div class="mc-skin-img">
                  <img src="https://minotar.net/body/<?php echo $readAccount["username"]; ?>/100.png" alt="<?php echo $readAccount["username"]; ?>">
                </div>
              </div>
            </div>

          </div>
          <?php else:?>
          <div class="login-buttons d-flex align-items-center justify-content-lg-end justify-content-center" style="height: 124px">
            <a href="<?php echo urlConverter("login", $languageType); ?>" class="btn text-white m-0 mr-3 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-primary">
              <svg class="svg-inline--fa fa-user fa-w-14 fa-sm mr-2 btn-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
              </svg><!-- <i class="fas fa-user fa-sm mr-2 btn-icon"></i> -->
              <span class="btn-text">
              <?php echo languageVariables("login", "words", $languageType); ?>
              </span>
            </a>
            <a href="<?php echo urlConverter("register", $languageType); ?>" class="btn text-white m-0 line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
              <svg class="svg-inline--fa fa-user-plus fa-w-20 fa-sm mr-2 btn-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                <path fill="currentColor" d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
              </svg><!-- <i class="fas fa-user-plus fa-sm mr-2 btn-icon"></i> -->
              <span class="btn-text">
              <?php echo languageVariables("register", "words", $languageType); ?>
              </span>
            </a>
          </div>
          <?php endif;?>
          <button class="navbar-toggler  responsive-navbar-toggler d-lg-none text-white d-flex align-items-center flex-column justify-content-center p-4 mb-2" type="button" data-toggle="collapse" data-target="#navbar-top-content" aria-expanded="true" aria-controls="navbar-top-content" aria-label="Toggle navigation">
            <div class="btn-lines">
              <span class="btn-line"></span>
              <span class="btn-line"></span>
              <span class="btn-line"></span>
            </div>
            <span class="text-uppercase o-25 font-100 mt-3 ml-1"><?php echo languageVariables("close", "words", $languageType); ?></span>
          </button>

        </div>
      </div>
    </div>
  </nav>
  <nav class="navbar-bottom navbar w-100 navbar-expand navbar-dark bg-dark--3 p-0">
    <!-- CONTAINER -->
    <div class="container">
      <!-- INNER CONTENT -->
      <div class="collapse navbar-collapse d-flex justify-content-lg-between justify-content-center" id="navbar-top-content">
        <!-- MENU -->
        <ul class="navbar-nav font-100 w-100 d-flex">
          <li class="nav-item">
            <a href="<?php echo urlConverter("home", $languageType); ?>" class="nav-link text-white d-lg-block d-flex flex-column align-items-center">
              <i class="fas fa-home fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js mt-lg-0 mt-1">
              <?php echo languageVariables("home", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo urlConverter("store", $languageType); ?>" class="nav-link text-white d-lg-block d-flex flex-column align-items-center">
              <i class="fas fa-shopping-basket fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js mt-lg-0 mt-1">
              <?php echo languageVariables("store", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo urlConverter("credit_upload", $languageType); ?>" class="nav-link text-white d-lg-block d-flex flex-column align-items-center">
              <i class="fas fa-credit-card fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js mt-lg-0 mt-1">
              <?php echo languageVariables("creditUpload", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <?php if ($readModule["voteSystemStatus"] == 0) { ?>
          <li class="nav-item">
            <a href="<?php echo urlConverter("rules", $languageType); ?>" class="nav-link text-white d-lg-block d-flex flex-column-reverse align-items-center">
              <i class="fas fa-book fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js mt-lg-0 mt-1">
              <?php echo languageVariables("rules", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <?php } else { ?>
          <li class="nav-item">
            <a href="<?php echo urlConverter("vote", $languageType); ?>" class="nav-link text-white d-lg-block d-flex flex-column-reverse align-items-center">
              <i class="fas fa-check-circle fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js mt-lg-0 mt-1">
              <?php echo languageVariables("vote", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?php echo urlConverter("help_center", $languageType); ?>" class="nav-link text-white">
              <i class="fas fa-question fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js">
              <?php echo languageVariables("helpCenter", "words", $languageType); ?>
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo urlConverter("support", $languageType); ?>" class="nav-link text-white">
              <i class="fas fa-cog fa-xs mr-1"></i>
              <span class="nav-item-text text-divider-js">
              <?php echo languageVariables("support", "words", $languageType); ?>
              </span>
            </a>
          </li>
        </ul>
        <!-- / MENU -->
      </div>
      <!-- / INNER CONTENT -->
    </div>
    <!-- / CONTAINER -->
  </nav>
  <div class="logo">
    <div class="logo-wrapper">
      <img src="<?php echo $rSettings['serverLogo']?>" alt="" class="js-mirror p-lg-0 px-4">
    </div>
  </div>
</div>
<?php $rowCountUserProduct = $db->prepare("SELECT * FROM userChest WHERE userID = ? AND status = ?"); ?>
<?php $rowCountUserProduct->execute(array($readAccount["id"], "0")); ?>
<?php $rowCountUserProduct = $rowCountUserProduct->rowCount(); ?>
<?php $rowCountUserInvent = $db->prepare("SELECT * FROM accountsInventory WHERE userID = ?"); ?>
<?php $rowCountUserInvent->execute(array($readAccount["id"])); ?>
<?php $rowCountUserInvent = $rowCountUserInvent->rowCount(); ?>