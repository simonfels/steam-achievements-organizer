<?php
function colorcode(int $count, DateTime $date): array {
  $colors = [
      0 => '#161b22', //  0
      1 => '#0e4429', //  1 - 10
      2 => '#006d32', // 11 - 20
      3 => '#26a641', // 21 - 30
      4 => '#39d353', // 31 -
    ];
  //if($count == 0) return [$colors[0], $count];

  $calcIndex = ceil($count / 10);

  //  return [$colors[ceil(min($calcIndex, 4))], $count];
  return ['hsl(' . $date->format('m') * 30 . ', 40%, ' . (ceil(min($calcIndex, 4))) * 15 + 16 . '%)', $count];
}
$start = DateTime::createFromFormat('d.m.Y', date('d.m.Y'));
$start->setTime(0,0);
$start->modify("-1 year");
$weekday = $start->format('w') == 0 ? 6 : $start->format('w') - 1;
$start->modify("-$weekday days");

$date_period = new DatePeriod($start, DateInterval::createFromDateString('1 day'), new DateTime('now'));
$dates = $user[1];
$weekdays = array_fill_keys(range(1, 7), []);
foreach($date_period as $date){
    $weekday = $date->format('w');
    $values = colorcode($dates[$date->format('U')] ?? 0, $date);
    $values[] = $date;
    $weekdays[$weekday == 0 ? 7 : $weekday][$date->format('d.m.Y')] = $values;
}
$days = ['SO','SA','FR','DO','MI','DI','MO'];
$achievements = $user[2];
?>
<div class="w-full flex justify-center">
    <div class="max-w-7xl">
        <div class="m-3 hidden">
            <img class="w-40" src="<?php echo $user[0]->avatar_url ?>">
            <h2 class="text-2xl font-bold"><?php echo $user[0]->name ?></h2>
            <a class="text-blue-400" href="<?php echo $user[0]->steam_url ?>">Link to Steam</a>
        </div>
        <div class="flex justify-center w-full">
            <table>
                <thead class="font-mono text-xs font-normal text-neutral-500">
                    <th></th>
                    <?php
                        $months = array_count_values(array_map(function($day) { return $day[2]->format('M\'y'); }, $weekdays[1]));
                    ?>
                    <?php foreach($months as $month => $count): ?>
                        <th class="text-neutral-300" colspan="<?php echo $count ?>"><small><?php echo $month ?></small></th>
                    <?php endforeach; ?>
                </thead>
                <tbody>
                    <?php foreach($weekdays as $weekday): ?>
                        <tr class="font-mono">
                                <td class="text-xs font-bold text-neutral-500 self-center"><?php echo array_pop($days) ?></td>
                                <?php foreach($weekday as $day => $count): ?>
                                    <?php echo "<td><a href='/users/show.php?userid={$user[0]->id}&date={$count[2]->format('U')}'><div class='w-4 h-4 rounded' style='background-color: {$count[0]}' title='Earned {$count[1]} Achievement" . ($count[1] === 1 ? '' : 's') . " on " . $day . "'></div></a></td>" ?>
                                <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if(!empty($show_date)): ?>
            <h3><?php echo DateTime::createFromFormat('U', $show_date)->format('d.m.Y'); ?></h3>
        <?php endif ?>
        <?php if(!empty($achievements)): ?>
            <div class="grid gap-2 grid-cols-1">
                    <?php foreach($achievements as $key => $game): ?>
                        <h4><?php echo $key ?></h4>
                        <?php foreach($game as $achievement): ?>
                            <div class="flex flex-col justify-between w-full bg-neutral-800 p-2 rounded">
                                <div class="flex">
                                    <div style="background-image: url(' <?php echo $achievement->icon ?>');" class="w-14 h-14 bg-cover flex-none mr-2"></div>
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