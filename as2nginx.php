#!/usr/bin/env php
<?php
// console.php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console as Console;

$application = new Console\Application('as2nginx', '1.0.0');
$application->add(new Theon\Nginx\Acl('acl'));
$application->add(new Theon\Nginx\Geoswitch('geoswitch'));
$application->run();