<a href="/users/activity.php?<?php echo http_build_query(['userid' => $user[0]->id]) ?>">Activity</a>

<div class="grid md:grid-cols-4 grid-cols-1 gap-2">
    <?php foreach($user[3] as $game): ?>
        <a href="/games/user.php?<?php echo http_build_query(['gameid' => $game->id, 'userid' => $user[0]->id]) ?>">
            <div style="background-color: hsl(<?php echo round($game->achievement_percent, 0) ?>, 50%, 35%)" class="p-2">
                <strong class="line-clamp-1"><?php echo $game->name ?></strong>
                <div class="flex justify-between">
                    <span  class="truncate"><?php echo $game->unlocked_achievements ?>/<?php echo $game->total_achievements ?></span>
                    <span><?php echo round($game->achievement_percent, 1) ?>%</span>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
