<h2>Index-View</h2>
<ul>
  <?php foreach($games as $game): ?>
    <li><?php echo "<a href='/games/show.php?appid={$game->app_id}'>{$game->name}</a>" ?></li>
  <?php endforeach;  ?>
</ul>
