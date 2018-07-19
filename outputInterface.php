<?php
/**
 * Created by PhpStorm.
 * User: sponidelnik
 * Date: 19.07.2018
 * Time: 23:12
 */

interface outputInterface
{
    public function write($string);

    public function info($string);

    public function fail($string);

    public function success($string);

    public function line();

    public function tab();

}