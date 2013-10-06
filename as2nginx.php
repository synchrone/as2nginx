#!/usr/bin/env php
<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console as Console;

$application = new Console\Application('as2nginx', '1.0.0');
$application->add(new Theon\Nginx\Acl('acl'));
$application->add(new Theon\Nginx\Geoswitch('geoswitch'));
$application->setCatchExceptions(false);
try
{
    $application->run();
}
catch (Exception $e)
{
    openlog('as2nginx', LOG_NDELAY | LOG_PID | LOG_PERROR, LOG_USER);
    syslog(LOG_ERR, sprintf('%s [ %s ]: %s',
        get_class($e),
        $e->getCode(),
        strip_tags($e->getMessage())
    ));
}