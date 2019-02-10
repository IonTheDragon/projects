<?php
// src/Entity/Ip.php
namespace App\Entity;

class Ip
{
    protected $ip;
    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }
}