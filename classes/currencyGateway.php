<?php

namespace classes;

use classes\Currency;
use \PDO as PDO;

class CurrencyGateway
{

    private $pdo;
    public $tableName = 'currency';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    
    public function insert(Currency $obj) : bool
	{
        $stmt = $this->pdo->prepare("INSERT INTO currency (date, exchange_rate, course_id) VALUES(:date, :exchange_rate, :course_id)");
        $params = [
            'date' => $obj->date->format('Y-m-d'),
            'exchange_rate' => $obj->exchangeRate,
            'course_id' => $obj->courseId
        ];
		return $stmt->execute($params);
	}
	
	public function getByDate(Currency $obj)
	{
        $stmt = $this->pdo->prepare("SELECT * FROM currency WHERE date = :date AND course_id = :courseId");
        $params = [
            'date' => $obj->date->format('Y-m-d'),
            'courseId' => $obj->courseId 
        ];
        $stmt->execute($params);
        $data = $stmt->fetch();
        return isset($data['exchange_rate']) ? $data : false;
    }
}