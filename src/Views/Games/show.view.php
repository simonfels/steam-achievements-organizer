<h2><?php echo $game->name ?></h2>

<div class="flex">
    <div class="w-1/6 flex-none flex flex-col py-2 pl-2">
        <span class="rounded-full border border-black px-1 py-0.5 text-xs text-center">SURVIVOR</span>
        <span class="rounded-full border border-black px-1 py-0.5 text-xs mt-2 text-center bg-black text-yellow-100">KILLER</span>
    </div>
    <div id="achievementsContainer" class="flex flex-wrap p-1">
      <?php foreach($achievements as $achievement): ?>
          <div class="flex xl:w-1/4 md:w-1/3 w-full">
              <div class="w-full bg-zinc-800 m-1 p-2">
                  <div class="">
                      <p class="text-lg font-bold line-clamp-1"><?php echo $achievement->display_name ?></p>
                      <p class="text-sm line-clamp-2"><?php echo $achievement->description ?></p>
                      <div class="flex mt-2 mb-2">
                          <span class="rounded-full border border-black px-2 py-0.5 text-xs">SURVIVOR</span>
                          <span class="rounded-full border border-black bg-black text-yellow-100 px-2 py-0.5 text-xs ml-1">KILLER</span>
                      </div>
                  </div>
                  <div style="background-image: url('<?php echo ($achievement->achieved ? $achievement->icon : $achievement->icongray) ?>');width:50px;height:50px" class="bg-cover flex-none"></div>
              </div>
          </div>
      <?php endforeach; ?>
    </div>
</div>
