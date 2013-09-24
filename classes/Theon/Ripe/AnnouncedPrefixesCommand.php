<?php namespace Theon\Ripe;

use Symfony\Component\Console as Console;
use Ripe\Stat\Client as RipeClient;

class AnnouncedPrefixesCommand extends Console\Command\Command
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addArgument('as', Console\Input\InputArgument::REQUIRED);
    }

    protected function GetAnnouncedPrefixes($as)
    {
        $ripe = RipeClient::factory();
        $prefixes = $ripe->GetAnnouncedPrefixes(array('resource' => $as));
        return $prefixes['data']['prefixes'];
    }
}