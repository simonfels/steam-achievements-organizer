<h2>User/show.php</h2>

<?php
function colorcode(int $count, int $maxvalue): array {
  $colors = [
      0 => '#161b22',
      1 => '#0e4429',
      2 => '#006d32',
      3 => '#26a641',
      4 => '#39d353',
    ];
  if($count == 0) return [$colors[0], $count];

  return [$colors[ceil(($count / $maxvalue) * 5)], $count];
}
$start = new DateTime('2023-01-01');
$weekday = $start->format('w') == 0 ? 6 : $start->format('w') - 1;
$start->modify("-$weekday days");

$date_period = new DatePeriod($start, DateInterval::createFromDateString('1 day'), new DateTime('now'));
$dates = $user[1];
$max_value = max(array_values($dates));
$weekdays = array_fill_keys(range(1, 7), []);

foreach($date_period as $date){
    $weekday = $date->format('w');
    $weekdays[$weekday == 0 ? 7 : $weekday][$date->format('d.m.Y')] = colorcode($dates[$date->format('U')] ?? 0, $max_value);
}
?>

  <?php foreach($weekdays as $weekday): ?>
<div class="flex font-mono">
<?php foreach($weekday as $day => $count): ?>
            <?php echo "<div style='margin: 4px; width: 15px; height: 15px; background-color: {$count[0]}' title='Earned {$count[1]} Achievement" . ($count[1] === 1 ? '' : 's') . " on " . $day . "'></div>" ?>
      <?php endforeach; ?>
</div>
  <?php endforeach; ?>
