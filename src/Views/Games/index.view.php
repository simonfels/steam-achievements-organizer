<h2>Index-View</h2>
<ul class="list-disc">
  <?php foreach($games as $game): ?>
    <li>
      <strong>
        <?php echo "<a class='text-neutral-300 text-lg' href='/games/show.php?appid={$game->app_id}'>{$game->name}</a>" ?>
      </strong>
    </li>
  <?php endforeach;  ?>
</ul>
