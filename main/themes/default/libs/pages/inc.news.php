<?php $searchNewsOne = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT 1"); ?>
<?php if($searchNewsOne->rowCount() > 0) { ?>
<?php $readNewsOne = $searchNewsOne->fetch(); ?>
<section class="py-16 relative">
  <div class="container mx-auto relative z-10 px-4 md:px-0">
    <h1 class="h1 text-gray-700"><?php echo languageVariables("news", "words", $languageType); ?></h1>
    <div class="grid gap-6 mt-24">
      <div class="big-news-block">
        <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNewsOne["title"]); ?>/<?php echo $readNewsOne["id"]; ?>">
          <div class="bnb-bg"></div>
          <div class="bnb-img">
            <div style="background-image: url('<?php echo $readNewsOne["image"]; ?>')"></div>
          </div>
        </a>
        <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNewsOne["title"]); ?>/<?php echo $readNewsOne["id"]; ?>" class="card py-8 px-12">
          <dt class="h3 text-gray-700"><?php echo $readNewsOne["title"]; ?></dt>
          <dt class="fs-6 text-gray-400 mt-4 mb-6"><?php echo contentShort(strip_tags($readNewsOne["text"]), 200); ?></dt>

          <div class="mt-auto flex justify-between">
            <div class="flex gap-3 items-center">
              <div>
                <img class="rounded-full" src="https://minotar.net/avatar/<?php echo $readNewsOne["newsAuthor"]; ?>/100" alt="<?php echo $readNewsOne["newsAuthor"]; ?>" width="40" height="40">
              </div>
              <div class="justify-center flex-col flex">
                <span class="fs-6 font-semibold"><?php echo $readNewsOne["newsAuthor"]; ?></span>
                <time class="fs-8 text-gray-400"><?php echo checkTime($readNewsOne["date"], 2); ?></time>
              </div>
            </div>
            <div class="bnb-hover">
              <span><?php echo languageVariables("moreRead", "words", $languageType); ?></span>
              <i class="fas fa-arrow-right"></i>
            </div>
          </div>
        </a>
      </div>
      <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-12">
        <?php $searchNews = $db->prepare("SELECT * FROM newsList WHERE id != ? ORDER BY id DESC"); ?>
        <?php $searchNews->execute(array($readNewsOne["id"])); ?>
        <?php if($searchNews->rowCount() > 0) { ?>
        <?php foreach($searchNews as $readNews) { ?>
        <a href="<?php echo urlConverter("blog", $languageType); ?>/<?php echo createSlug($readNews["title"]); ?>/<?php echo $readNews["id"]; ?>" class="rounded-2xl relative h-[18rem] overflow-hidden group bg-cover bg-center" style="background-image: url('<?php echo $readNews["image"]; ?>')">
          <div class="absolute top-0 -left-full w-full group-hover:left-0 transition-all h-full">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-indigo-700/25 to-black/25"></div>
            <div class="relative z-10 p-10 flex flex-col h-full">
              <dt class="fw-bold text-white fs-3 max-w-lg leading-7"><span class="text-emerald-400"><?php echo $readNews["categoryName"]; ?></span> - <?php echo $readNews["title"]; ?></dt>
              <dd class="mt-5 text-indigo-100 max-w-lg"><?php echo contentShort(strip_tags($readNews["text"]), 60); ?></dd>
              <div class="flex justify-between items-center mt-auto">
                <div class="btn btn-primary"><?php echo languageVariables("moreRead", "words", $languageType); ?></div>
                <div class="flex gap-3 text-xs font-medium">
                  <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                    <i class="fas fa-eye"></i> <?php echo $readNews["newsDisplay"]; ?>
                  </div>
                  <div class="rounded-xl py-2 px-3 bg-indigo-400/50 text-indigo-200">
                    <i class="fas fa-heart"></i> <?php echo $readNews["newsHearts"]; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <span class="absolute top-8 right-12 rounded-xl bg-emerald-500 text-white py-2 px-4 fs-8 uppercase fw-medium group-hover:-right-full transition-all"><?php echo $readNews["categoryName"]; ?></span>
          <div class="absolute bottom-0 left-0 w-full py-5 px-10 overflow-hidden transform group-hover:translate-y-full transition-all">
            <div class="absolute top-0 left-0 w-full h-full bg-black/50 blur-sm"></div>
            <div class="relative z-10">
              <dt class="fw-bold text-white fs-4"><?php echo $readNews["title"]; ?></dt>
              <dd class="mt-1 text-white/75"><?php echo contentShort(strip_tags($readNews["text"]), 30); ?></dd>
            </div>
          </div>
        </a>
        <?php } } else { echo alert(languageVariables("alertNotNews", "home", $languageType), "danger", "0", "/"); } ?>
      </div>
    </div>
  </div>
</section>
<style>
  .news-bg-svg {
    opacity: .3;
    transform: rotate3d(1, 1, 1, 45deg);
  }
</style>
<?php } else { go("/"); } ?>