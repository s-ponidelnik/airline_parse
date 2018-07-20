<?php
/**
 * Created by PhpStorm.
 * User: sponidelnik
 * Date: 19.07.2018
 * Time: 21:17
 */

include_once 'parserCurl.php';
include_once 'console.php';
include_once 'airlineParser.php';
$curl = new parserCurl();
$airlineParser = new airlineParser($curl);
$airlineParser->parse(console::getInstance());
$airlineParser->saveJson('airlines_updated');
$airlineParser->saveSql('airlines');


