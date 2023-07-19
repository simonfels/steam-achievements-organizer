<h1 class="text-neutral-300 text-2xl mb-2 ml-2"><strong><?php echo $game->name ?></strong></h1>
<h2 class="text-neutral-300 text-lg mb-4 ml-2">Achievements</h2>
<div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-6">
    <?php foreach($achievements as $achievement): ?>
        <div class="w-full bg-neutral-800 p-2 rounded">
            <div class="flex">
                <div style="background-image: url('<?php echo $achievement->icon ?>'); width: 50px; height: 50px" class="bg-cover flex-none mr-2"></div>
                <div>
                    <p class="text-lg font-bold line-clamp-1 text-neutral-300" title="<?php echo $achievement->display_name ?>"><?php echo $achievement->display_name ?></p>
                    <p class="text-sm line-clamp-2 hover:line-clamp-none text-neutral-400"><?php echo $achievement->description ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
