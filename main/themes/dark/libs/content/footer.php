<div class="container-fluid position-relative m-0 p-0">
  <footer class="bg-dark--1">
    <div class="footer-details text-center bg-dark--3 px-5 pb-5">
      <div class="container px-lg-5">
        <div class="header position-relative">
          <a href="<?php echo $rMedia["instagram"]; ?>" class="phone-number">
            <i class="fab fa-instagram"></i>
            <span><?php echo str_replace("//www.instagram.com/", "", $rMedia["instagram"]); ?></span>
          </a>
          <a href="mailto:<?php echo $rMedia["email"]; ?>" class="mail">
            <i class="fas fa-at"></i>
            <span><?php echo $rMedia["email"]; ?></span>
          </a>
          <img src="<?php echo $rSettings['serverLogo']?>" alt="" class="js-mirror">
          <img src="<?php echo $rSettings['serverLogo']?>" alt="" class="js-mirror mirrored-item">
        </div>
        <div class="mb-0 font-100 mt-3 px-lg-5 o-90" style="text-align: -webkit-center;">
          <?php echo $rSettings["metaDescription"]; ?>
          <div class="input-group mt-3 flex-column bg-dark--5 col-12 p-0 select-wrapper w-25 input-focused">
            <label for="changeLang" class="o-100 d-block mb-0 text-white font-size-6 font-100 position-absolute">
              <i class="fas fa-language fa-xs mr-1"></i><?php echo languageVariables("languageChange", "words", $languageType); ?>
            </label>
            <select id="changeLang" language="change" class="js-select2 w-100" data-toggle="select2" ref="<?php echo $_SERVER["REQUEST_URI"]; ?>">
              <?php $languageListF = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
              <?php foreach ($languageListF as $readList) { ?>
                <option value="<?php echo $readList["code"]; ?>" <?php if ($languageType == $readList["code"]) { echo "selected"; } ?>><?php echo $readList["title"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-top bg-dark--2 p-4">
      <div class="container d-flex justify-content-between flex-lg-row flex-column align-items-center">
        <a href="//mcthemes.net" target="_blank" class="text-white" data-toggle="tooltip" data-placement="top" title="Design: Anathory & Anka" data-original-title="Tasarım: Anathory & Anka">
          MCTHEMES
        </a>
        <div class="social-media my-lg-0 my-3 border-top border-bottom py-3 py-lg-0">
          <ul class="navbar-nav d-flex align-items-center flex-row">
            <li class="nav-item mr-4">
              <a href="<?php echo $rMedia["discord"]; ?>" target="_blank" class="nav-link p-0">
                <i class="fab fa-discord fa-sm mr-1 text-white"></i>
              </a>
            </li>
			      <li class="nav-item mr-4">
              <a href="<?php echo $rMedia["facebook"]; ?>" target="_blank" class="nav-link p-0">
                <i class="fab fa-facebook fa-sm mr-1 text-white"></i>
              </a>
            </li>
		      	<li class="nav-item mr-4">
              <a href="<?php echo $rMedia["youtube"]; ?>" target="_blank" class="nav-link p-0">
                <i class="fab fa-youtube fa-sm mr-1 text-white"></i>
              </a>
            </li>
            <li class="nav-item mr-4">
              <a href="<?php echo $rMedia["instagram"]; ?>" target="_blank" class="nav-link p-0">
                <i class="fab fa-instagram fa-sm mr-1 text-white"></i>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $rMedia["twitter"]; ?>" target="_blank" class="nav-link p-0">
                <i class="fab fa-twitter fa-sm mr-1 text-white"></i>
              </a>
            </li>
          </ul>
        </div>
        <a href="<?php echo "https://www.minexon.net/".(($languageType == "tr") ? "tr" : "en"); ?>" target="_blank" class="footer-script text-white" data-toggle="tooltip" data-placement="top" title="Software: Hasan ESKİSARAÇ" data-original-title="Software: Hasan ESKİSARAÇ">
		      <span class="script-name"><?php echo "MINEXON"; ?></span>
		      <span class="script-version text-secondary"><?php echo "v".$_CONFIG["PROJECT_VERSION"]; ?></span>
        </a>
      </div>
    </div>
    <div class="footer-bottom bg-dark--3 p-4 text-center text-white ">
      <div class="container">
        <span><?php echo $rSettings['serverName']?> <span class="text-secondary"><?php echo languageVariables("footerCopyright", "words", $languageType); ?></span></span>
      </div>
    </div>
  </footer>
</div>