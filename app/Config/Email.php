<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail  = 'shenmikappai@gmail.com';
    public $fromName   = 'Shenmi - Soporte';
    public $recipients = '';

    public $protocol     = 'smtp';
    public $SMTPHost     = 'smtp.gmail.com';
    public $SMTPUser     = 'shenmikappai@gmail.com';
    public $SMTPPass     = 'jxrg auqv fbcl manv';
    public $SMTPPort     = 587;
    public $SMTPCrypto   = 'tls';

    public $mailType     = 'html';
    public $charset      = 'utf-8';
    public $newline      = "\r\n";
    public $wordWrap     = true;
}
