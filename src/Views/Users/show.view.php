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
    $values = colorcode($dates[$date->format('U')] ?? 0);
    $values[] = $date->format('U');
    $weekdays[$weekday == 0 ? 7 : $weekday][$date->format('d.m.Y')] = $values;
}
$days = ['SO','SA','FR','DO','MI','DI','MO'];
$achievements = $user[2];
?>

<div class="flex max-w-7xl">
    <div class="m-3">
        <img class="w-60" src="<?php echo $user[0]->avatar_url ?>">
        <h2 class="text-2xl font-bold"><?php echo $user[0]->name ?></h2>
        <a class="text-blue-400" href="<?php echo $user[0]->steam_url ?>">Link to Steam</a>
    </div>
    <div class="flex-1">
        <?php foreach($weekdays as $weekday): ?>
            <div class="flex font-mono">
                <div class="text-xs font-bold text-neutral-500 self-center"><?php echo array_pop($days) ?></div>
                <?php foreach($weekday as $day => $count): ?>
                    <?php echo "<a href='/users/show.php?userid={$user[0]->id}&date=$count[2]'><div class='w-4 h-4 m-0.5 rounded' style='background-color: {$count[0]}' title='Earned {$count[1]} Achievement" . ($count[1] === 1 ? '' : 's') . " on " . $day . "'></div></a>" ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <?php if(!empty($achievements)): ?>
            <h3><?php echo DateTime::createFromFormat('U', $show_date)->format('d.m.Y'); ?></h3>
            <div class="grid gap-2 grid-cols-1">
                    <?php foreach($achievements as $key => $game): ?>
                        <h4><?php echo $key ?></h4>
                        <?php foreach($game as $achievement): ?>
                            <div class="flex flex-col justify-between w-full bg-neutral-800 p-2 rounded">
                                <div class="flex">
                                    <div style="background-image: url(' <?php echo $achievement->icon ?>'); width: 50px; height: 50px" class="bg-cover flex-none mr-2"></div>
                                    <div>
                                        <p class="text-lg font-bold line-clamp-1 text-neutral-300"><?php echo $achievement->display_name ?></p>
                                        <p class="text-sm line-clamp-2 hover:line-clamp-none text-neutral-400"><?php echo $achievement->description ?></p>
                                    </div>
                                </div>
                                <div class="text-left text-sm text-neutral-100 mt-2"><?php echo $achievement->formatted_unlocked_at('short') ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
        <?php endif; ?>
    </div>
</div>