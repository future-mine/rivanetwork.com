<div class="col-12 p-0">
    <section class="games bg-dark--1 p-1 py-5">
      <div class="container">
        <div class="col-12">
          <h1 class="text-white mb-0 font-500 text-center line-height-0 heading-title">
            <?php echo languageVariables("news", "words", $languageType); ?>
          </h1>
        </div>
        <div class="row">
          <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC"); ?>
          <?php if($searchNews->rowCount() > 0): ?>
          <?php foreach($searchNews as $readNews): ?>
          <div class="col-lg-4">
            <div class="card text-white card-blog pt-4 mt-1 wide">
              <div class="card-body bg-dark--2 p-5 d-flex flex-row align-items-start font-10">
                <img src="<?php echo $readNews["image"]; ?>" alt="Haber - <?php echo $readNews["title"]; ?>" class="rounded-sm">
                <div class="text-group position-relative h-100 w-100">
                  <h5 class="card-title px-4 text-left font-400 w-75 mb-0"><?php echo $readNews["title"]; ?></h5>
                  <p class="card-text font-size-6 text-left text-white mt-1 px-4 font-100 o-75 h-50"><?php echo contentShort(strip_tags($readNews["text"]), 150); ?></p>
  
                  <div class="btn-group pl-4 mt-5">
                    <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>" class="btn text-white line-height-1 text-uppercase letter-spacing-1 font-100 font-size-6 btn-outline-primary">
                      <i class="fas fa-arrow-right fa-sm mr-2 btn-icon"></i>
                      <span class="btn-text">
                      <?php echo languageVariables("moreRead", "words", $languageType); ?>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach;?>
          <?php else:?>
            <?php echo alert(languageVariables("alertNotNews", "home", $languageType), "danger", "0", "/");?>
          <?php endif;?>
        </div>
      </div>
    </section>
</div>