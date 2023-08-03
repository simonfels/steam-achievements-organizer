<?php

namespace App\Controller;
use App\Models\UsersList;
use DateInterval;
use DatePeriod;
use DateTime;

class UsersController extends AbstractController {
  private UsersList $users_list;

  public function __construct() {
    $this->users_list = new UsersList();
  }
  public function index(): void {
    $this->render('Users/index', [
      'users' => $this->users_list->all()
    ]);
  }

  public function show(): void {
    $user_id = @$_GET['userid'];
    [$user, $_trash1, $_trash2, $games] = $this->users_list->find($user_id);

    if(!empty($user_id)) {
      $this->render('Users/show', [
        'user' => $user,
        'games' => implode(", ", array_map(function($game) { return $game->getVars(); }, $games))
      ]);
    } else {
      $this->render('Users/404');
    }
  }

    public function activity(): void {
        $user_id = @$_GET['userid'];
        $date = @$_GET['date'];

        if(!empty($user_id)) {
            $user = $this->users_list->find($user_id, $date);
            $start = DateTime::createFromFormat('d.m.Y', date('d.m.Y'));
            $start->setTime(0,0);
            $start->modify("-1 year");
            $weekday = $start->format('w') == 0 ? 6 : $start->format('w') - 1;
            $start->modify("-$weekday days");

            $date_period = new DatePeriod($start, DateInterval::createFromDateString('1 day'), new DateTime('now'));
            $dates = $user[1];
            $weekdays = array_fill_keys(range(1, 7), []);
            $show_date = (!empty($date) ? DateTime::createFromFormat('U', $date)->format('d.m.Y') : null);
            foreach($date_period as $date){
                $weekday = $date->format('w');
                $values = $this->color_code($dates[$date->format('U')] ?? 0, $date);
                $values[] = $date;
                $weekdays[$weekday == 0 ? 7 : $weekday][$date->format('d.m.Y')] = $values;
            }
            $days = ['SO','SA','FR','DO','MI','DI','MO'];
            $months = array_count_values(array_map(function($day) { return $day[2]->format('M\'y'); }, $weekdays[1]));
            $this->render('Users/activity', [
                'user' => $user,
                'show_date' => $show_date,
                'days' => $days,
                'achievements' => $user[2],
                'weekdays' => $weekdays,
                'months' => $months
            ]);
        } else {
            $this->render('Users/404');
        }
    }

    private function color_code(int $count, DateTime $date): array {
        $calcIndex = ceil($count / 10);

        return ['hsl(' . $date->format('m') * 30 . ', 40%, ' . (ceil(min($calcIndex, 4))) * 15 + 16 . '%)', $count];
    }
}
