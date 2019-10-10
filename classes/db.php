<?php

namespace classes;

use \PDO as PDO;

class Db
{
	private $host;
	private $db;
	private $user;
	private $pass;
	private $charset;
	private $pdo;
	private $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
	
	function __construct($host, $db, $user, $pass, $charset)
	{
		$this->host = $host;
		$this->db = $db;
		$this->charset = $charset;
		$this->user = $user;
		$this->pass = $pass;
	}
	
	public function connect()
	{	
		try
		{
			$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;";
			$pdo = new PDO($dsn, $this->user, $this->pass, $this->opt);
			return $pdo;
		}
		catch(PDOException $exception)
		{
			return false;
		}
	}
}