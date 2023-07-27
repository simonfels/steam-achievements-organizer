<h2>List of all fetched Games</h2>
<ul class="list-disc">
  <?php foreach($games as $game): ?>
    <li>
      <strong>
          <a class="text-neutral-300 text-lg" href="/games/show.php?<?php echo http_build_query(['gameid' => $game->id]) ?>">
            <?php echo $game->name ?> (<?php echo $game->total_achievements ?>)
          </a>
      </strong>
    </li>
  <?php endforeach;  ?>
</ul>
