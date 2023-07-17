<h2><?php echo $user[0]->name ?></h2>

<?php
function colorcode(int $count): array {
  $colors = [
      0 => '#161b22', //  0
      1 => '#0e4429', //  1 - 10
      2 => '#006d32', // 11 - 20
      3 => '#26a641', // 21 - 30
      4 => '#39d353', // 31 -
    ];
  if($count == 0) return [$colors[0], $count];

  $calcIndex = ceil($count / 10);

  return [$colors[ceil(min($calcIndex, 4))], $count];
}
$start = new DateTime('2023-01-01');
$weekday = $start->format('w') == 0 ? 6 : $start->format('w') - 1;
$start->modify("-$weekday days");

$date_period = new DatePeriod($start, DateInterval::createFromDateString('1 day'), new DateTime('now'));
$dates = $user[1];
$weekdays = array_fill_keys(range(1, 7), []);

foreach($date_period as $date){
    $weekday = $date->format('w');
    $weekdays[$weekday == 0 ? 7 : $weekday][$date->format('d.m.Y')] = colorcode($dates[$date->format('U')] ?? 0);
}
$days = ['SO','SA','FR','DO','MI','DI','MO'];
?>

  <?php foreach($weekdays as $weekday): ?>
    <div class="flex font-mono">
        <div class="text-xs font-bold text-neutral-500 self-center"><?php echo array_pop($days) ?></div>
        <?php foreach($weekday as $day => $count): ?>
            <?php echo "<div style='margin: 3px; width: 12px; height: 12px; background-color: {$count[0]}' title='Earned {$count[1]} Achievement" . ($count[1] === 1 ? '' : 's') . " on " . $day . "'></div>" ?>
        <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
<?php if(!empty($date)): ?>
    <?php echo $date; ?>
<?php endif; ?>
