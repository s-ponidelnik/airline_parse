<?php
/**
 * Created by PhpStorm.
 * User: sponidelnik
 * Date: 19.07.2018
 * Time: 22:48
 */

class parserCurl
{
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => "http://www.airlinecodes.co.uk/airlcoderes.asp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_COOKIE => "JSESSIONID=DCF7819A8E679E7E96236F02C8512BDE",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));
    }

    public function close()
    {
        curl_close($this->curl);
    }

    public function exec()
    {
        return curl_exec($this->curl);
    }

    public function error()
    {
        return (curl_errno($this->curl) ? curl_errno($this->curl) : null);
    }

    public function setIata($iata)
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "iatacode=" . $iata . "&submit=submit");
    }
}