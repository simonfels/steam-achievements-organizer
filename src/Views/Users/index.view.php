<h2>Index-View</h2>
<div class="grid grid-cols-3 text-neutral-300 text-center">
  <?php foreach($users as $user): ?>
    <a href="/users/show.php?<?php echo http_build_query(["appid" => $user->id]); ?>"><?php echo $user->name; ?></a>
    <div><?php echo "{$user->achieved_achievements} / {$user->total_achievements}" ?></div>
    <div><?php echo $user->achievementPercentage() ?>%</div>
  <?php endforeach;  ?>
</div>
