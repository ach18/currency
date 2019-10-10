<?php

use classes\Db;
use classes\Currency;
use classes\CurrencyGateway;

if(isset($_GET['date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['date']))
	$date = htmlspecialchars($_GET['date']);
else
{
	header('HTTP/1.1 400 Bad Request', true, 400);
	exit('Bad Request');
}

$date = DateTime::createFromFormat('Y-m-d', $date);
$currency = new Currency();
$currency->courseId = 'R01235';
$currency->date = $date;

$db = new Db('127.0.0.1','test','root','','utf8');
$pdo = $db->connect();

$currencyGateway = new CurrencyGateway($pdo);
$exchangeRate = $currencyGateway->getByDate($currency);

if($exchangeRate)
{
	header('HTTP/1.1 200 OK', true, 200);
	echo json_encode($exchangeRate);
}
else
{
	$requestParam = [
		'date_req' => $currency->date->format('d/m/Y')
	];
	$connectionString = "http://www.cbr.ru/scripts/XML_daily.asp?" . http_build_query($requestParam);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $connectionString);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$xmlStr = curl_exec($curl);
	curl_close($curl);
	$xmlObj = new SimpleXMLElement($xmlStr);
	if(!isset($xmlObj->Valute) || ($xmlObj['Date'] != $currency->date->format('d.m.Y')))
	{
		header('HTTP/1.1 400 Bad Request', true, 400);
		exit('Bad Request');
	}
	
	foreach($xmlObj as $key)
	{
		if($key['ID'] == $currency->courseId)
			$exchangeRate = $key->Value;
	}
	
	$rateStr = str_replace(',', '.', $exchangeRate);
	$currency->exchangeRate = floatval($rateStr);
	$currencyGateway->insert($currency);

	$exchangeRate = $currencyGateway->getByDate($currency);
	if($exchangeRate)
	{
		header('HTTP/1.1 200 OK', true, 200);
		echo json_encode($exchangeRate);
	}
}