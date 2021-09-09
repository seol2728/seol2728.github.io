<?php
class DateTimeExtra extends DateTime {
    public function weekofmonth() {
        $thursday = $this->thursday();

        if ( $thursday->format('n') != $this->format('n') ) {
            $date = $thursday;
        }
        else {
            $date = $this;
        }

        $firstday = clone $date;
        $firstday->sub(new DateInterval('P'.($date->format('j') - 1).'D'));
        $thursday_of_firstday = $firstday->thursday();
        if ( $thursday_of_firstday->format('n') != $firstday->format('n') ) {
            // 이번 달 첫번째 날을 포함한 주의 목요일의 월과 첫번째 날의 월이
            // 다른 경우는 첫번째 날이 이전 달의 마지막 주에 포함되어 있다는
            // 것이므로 월의 주차 기준이 되는 주를 한 주 뒤로 미룬다.
            $firstday->add(new DateInterval('P1W'));
        }

        $month = $date->format('n');
        $weekofmonth = $date->format('W') - $firstday->format('W') + 1;

        return array(intval($month), intval($weekofmonth));
    }

    private function thursday() {
        $thursday = clone $this;
        $dayofweek = $this->format('N');

        if ( $dayofweek < 4 ) {
            $thursday->add(new DateInterval('P'.(4 - $dayofweek).'D'));
        }

        if ( $dayofweek > 4 ) {
            $thursday->sub(new DateInterval('P'.($dayofweek - 4).'D'));
        }

        return $thursday;
    }
}
?>
