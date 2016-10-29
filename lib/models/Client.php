<?php

class Client extends Main
{
    protected $table = 'client';

    protected static $instance = null;

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Client();
        }
        return static::$instance;
    }

    public function getDates()
    {
        $sql = $this->pdo->prepare("SELECT MIN(datetime) as min_date, MAX(datetime) as max_date FROM " . $this->table);
        $sql->execute();
        $element = $sql->fetch(PDO::FETCH_ASSOC);
        return $element;
    }

    public function getCountByPeriods($data, $isRegistered = false)
    {
        $rows = array();

        if ($isRegistered) {
            $queryCommon = "SELECT COUNT(id) as count_elements, ? as period FROM {$this->table}
WHERE status = 'registered' AND datetime BETWEEN ? AND ?";
        } else {
            $queryCommon = "SELECT COUNT(id) as count_elements, ? as period FROM {$this->table}
WHERE datetime BETWEEN ? AND ?";
        }

        if ($data) {
            $dataForQuery = array();
            $query = array();

            foreach ($data as $period => $params) {
                $dataForQuery[] = $period;
                $dataForQuery[] = $params['min'];
                $dataForQuery[] = $params['max'];
                $query[] = $queryCommon;
            }
            $sql = $this->pdo->prepare(implode(' UNION ', $query));
            $sql->execute($dataForQuery);
            $sql->setFetchMode(PDO::FETCH_ASSOC);

            while ($row = $sql->fetch()) {
                $rows[$row['period']] = $row['count_elements'];
            }
        }
        return $rows;
    }
}