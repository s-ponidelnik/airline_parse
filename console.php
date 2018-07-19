<?php

/**
 * Created by PhpStorm.
 * User: sponidelnik
 * Date: 19.07.2018
 * Time: 22:45
 */

include_once 'outputInterface.php';

final class console implements outputInterface
{
    private static
        $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function info($string)
    {
        $this->write("\e[33m" . $string . "\e[0m");
    }

    public function write($string)
    {
        print $string;
    }

    public function fail($string)
    {
        $this->write("\e[0;31m" . $string . "\e[0m");
    }

    public function success($string)
    {
        $this->write("\e[0;32m" . $string . "\e[0m");
    }

    public function line()
    {
        $this->write("\n");
    }

    public function tab()
    {
        $this->write("  ");
    }

    private function __clone()
    {
    }
}