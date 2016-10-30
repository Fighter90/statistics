<?php

class Index extends Base
{
    const DEFAULT_PERIOD = 20;
    const DAY = 86400;
    protected $template = 'templates/index.php';

    protected function inputSource()
    {
        parent::inputSource();
        $clientHref = Client::getInstance();
        $dates = $clientHref->getDates();
        $countDays = self::DEFAULT_PERIOD;

        if (isset($_POST['days'])) {
            $countDays = (int)$_POST['days'];
            $countDays = $countDays > 0 ? $countDays : self::DEFAULT_PERIOD;
        }
        $periods = $this->calcDates($dates, $countDays);
        $this->params['dataRegistered'] = $periods ? $clientHref->getCountByPeriods($periods, true) : array();
        $this->params['dataAll'] = $periods ? $clientHref->getCountByPeriods($periods) : array();
        $this->params['days'] = $countDays;
    }

    /**
     * Формируем параметры для запроса данных
     * @param $dates
     * @param int $countDays
     * @return array
     */
    private function calcDates($dates, $countDays = self::DEFAULT_PERIOD)
    {
        $periods = array();

        if ($dates) {
            $currentDateTime = strtotime($dates['min_date']);
            $i = 1;
            $maxTime = strtotime($dates['max_date']);

            while ($maxTime >= $currentDateTime) {
                $periods[$i] = array();
                $periods[$i]['min'] = date("Y-m-d H:i:s", $currentDateTime);
                $currentDateTime += $countDays * self::DAY;

                if ($maxTime < $currentDateTime) {
                    unset($periods[$i]);
                } else {
                    $periods[$i]['max'] = date("Y-m-d H:i:s", $currentDateTime - 1);
                    $i++;
                }
            }
        }
        return $periods;
    }
}