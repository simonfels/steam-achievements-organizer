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

    if(!empty($user_id)) {
      $this->render('Users/show', [
        'user' => $this->users_list->find($user_id)
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
//        $colors = [
//            0 => '#161b22', //  0
//            1 => '#0e4429', //  1 - 10
//            2 => '#006d32', // 11 - 20
//            3 => '#26a641', // 21 - 30
//            4 => '#39d353', // 31 -
//        ];
        //if($count == 0) return [$colors[0], $count];

        $calcIndex = ceil($count / 10);

        //  return [$colors[ceil(min($calcIndex, 4))], $count];
        return ['hsl(' . $date->format('m') * 30 . ', 40%, ' . (ceil(min($calcIndex, 4))) * 15 + 16 . '%)', $count];
    }
}
