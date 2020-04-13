<?php
class api
{
    private $startDate;
    private $endDate;
    private $userId;
    private $get_holidays;

    function __construct($start_date, $end_date, $user_id, $get_holidays = 0)
    {
        $this->startDate = $start_date;
        $this->endDate = $end_date;
        $this->userId = $user_id;
        $this->get_holidays = $get_holidays;
    }

    function get_schedule()
    {
        try {
            $start_date = $this->startDate;
            $end_date = $this->endDate;
            $user_id = $this->userId;
            $get_holidays = $this->get_holidays;

            //Если параметры переданы
            if (!empty($start_date) && !empty($end_date) && !empty($user_id)) {
                $start_date = strtotime($start_date);
                $end_date = strtotime($end_date);

                if ($start_date >= $end_date) return json_encode(['status' => 'error', 'error' => 'Конечная дата больше начальной'], JSON_UNESCAPED_UNICODE);

                //Загружаем json данные в виде ассоциативного массива
                $contents = file_get_contents('.ht.schedule');
                $jsonArray = json_decode($contents, true);
                $schedules = $jsonArray['schedules'];

                //Ищем порядковый номер записи в массиве по id пользователя
                $key = array_search($user_id, array_column($schedules, 'id'));
                if ($key === false) return json_encode(['status' => 'error', 'error' => 'Пользователь не найден'], JSON_UNESCAPED_UNICODE);

                //Праздники
                $holidays = $this->holidays();

                //Корпоратив
                $party = $jsonArray['party'];
                $party_arr = [];

                $p_start = strtotime(date('Y-m-d', strtotime($party['start'])));
                $p_end = strtotime(date('Y-m-d', strtotime($party['end'])));
                for ($ts = $p_start; $ts < $p_end + 3600 * 24; $ts += 3600 * 24) {
                    $party_arr[] = date('m-d', $ts);
                }

                //Отпуск
                $vacations = $schedules[$key]['vacations'];
                $vacations_arr = [];
                foreach ($vacations as $vacation) {
                    $v_start = strtotime(date('Y') . '-' . $vacation['start']);
                    $v_end = strtotime(date('Y') . '-' . $vacation['end']);
                    for ($ts = $v_start; $ts < $v_end + 3600 * 24; $ts += 3600 * 24) {
                        $vacations_arr[] = date('m-d', $ts);
                    }
                }

                $schedule = [];
                $holidays_schedule = [];
                $vacations_schedule = [];
                $party_schedule = [];
                $dinner_schedule = [];

                $timeRanges = $schedules[$key]['timeRanges'][0];

                //Перебор дней в пределах указанного диапазона
                for ($ts = $start_date; $ts < $end_date + 3600 * 24; $ts += 3600 * 24) {

                    //Если получаем рабочие дни
                    if(!$get_holidays) {
                        //Если не праздник, не отпуск, и не корпоратив
                        if (!in_array(date('m.d', $ts), $holidays) && !in_array(date('m-d', $ts), $vacations_arr) && !in_array(date('m-d', $ts), $party_arr)) {

                            if (date('D', $ts) === 'Mon' && !empty($timeRanges['monday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['monday']];
                            elseif (date('D', $ts) === 'Tue' && !empty($timeRanges['tuesday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['tuesday']];
                            elseif (date('D', $ts) === 'Wed' && !empty($timeRanges['wednesday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['wednesday']];
                            elseif (date('D', $ts) === 'Thu' && !empty($timeRanges['thursday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['thursday']];
                            elseif (date('D', $ts) === 'Fri' && !empty($timeRanges['friday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['friday']];
                            elseif (date('D', $ts) === 'Sat' && !empty($timeRanges['saturday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['saturday']];
                            elseif (date('D', $ts) === 'Sun' && !empty($timeRanges['sunday'])) $schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $timeRanges['sunday']];
                        }
                    }
                    else {
                        if (in_array(date('m.d', $ts), $holidays)) $holidays_schedule[] = date('Y-m-d', $ts);
                        if (in_array(date('m-d', $ts), $vacations_arr)) $vacations_schedule[] = date('Y-m-d', $ts);
                        if (in_array(date('m-d', $ts), $party_arr)) $party_schedule[] = date('Y-m-d', $ts);

                        //Получаем обеденное время
                        if (!in_array(date('m.d', $ts), $holidays) && !in_array(date('m-d', $ts), $vacations_arr) && !in_array(date('m-d', $ts), $party_arr)) {
                            $dinner = [];
                            if (date('D', $ts) === 'Mon' && !empty($timeRanges['monday'])) $timeRange = $timeRanges['monday'];
                            elseif (date('D', $ts) === 'Tue' && !empty($timeRanges['tuesday'])) $timeRange = $timeRanges['tuesday'];
                            elseif (date('D', $ts) === 'Wed' && !empty($timeRanges['wednesday'])) $timeRange = $timeRanges['wednesday'];
                            elseif (date('D', $ts) === 'Thu' && !empty($timeRanges['thursday'])) $timeRange = $timeRanges['thursday'];
                            elseif (date('D', $ts) === 'Fri' && !empty($timeRanges['friday'])) $timeRange = $timeRanges['friday'];
                            elseif (date('D', $ts) === 'Sat' && !empty($timeRanges['saturday'])) $timeRange = $timeRanges['saturday'];
                            elseif (date('D', $ts) === 'Sun' && !empty($timeRanges['sunday'])) $timeRange = $timeRanges['sunday'];
                            else $timeRange = null;

                            if(!empty($timeRange)) {
                                foreach ($timeRange as $tkey => $timeRange_item) {
                                    if ($tkey < count($timeRange) - 1) {
                                        $dinner[] = ['start' => $timeRange[$tkey]['end'], 'end' => $timeRange[$tkey + 1]['start']];
                                    }
                                }
                            }
                            else $dinner[] = ['start' => '0000', 'end' => '2400'];
                            $dinner_schedule[] = ['day' => date('Y-m-d', $ts), 'timeRanges' => $dinner];
                        }
                    }
                }

                if(!$get_holidays) return json_encode(['status' => 'ok', 'schedule' => $schedule], JSON_UNESCAPED_UNICODE);
                else return json_encode(['status' => 'ok', 'dinner' => $dinner_schedule, 'holidays' => $holidays_schedule, 'vacations' => $vacations_schedule, 'party' => $party_schedule], JSON_UNESCAPED_UNICODE);
            }
        }
        catch (exception $ex)
        {
            return json_encode(['status' => 'error', 'error' => $ex->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    /*
        hello-site.ru/share/prazdniki-i-vyhodnye-dni-php/
    */
    function holidays($year = null)
    {
        if(!isset($year)) $year = date('Y');
        $calendar = simplexml_load_file('http://xmlcalendar.ru/data/ru/'.$year.'/calendar.xml');

        $calendar = $calendar->days->day;

        $arHolidays = [];

        //все праздники за текущий год
        foreach( $calendar as $day ){
            $d = (array)$day->attributes()->d;
            $d = $d[0];
            //не считая короткие дни
            if( $day->attributes()->t == 1 ) $arHolidays[] = $d;
        }

        return $arHolidays;
    }
}