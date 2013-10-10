<?php namespace Theon\Ripe;

use Symfony\Component\Console as Console;
use Ripe\Stat\Client as RipeClient;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnnouncedPrefixesCommand extends Console\Command\Command
{
    /**
     * @var Console\Input\InputInterface
     */
    protected $input;
    protected $output;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addOption('as', null, InputOption::VALUE_REQUIRED, 'AS number');
        $this->addOption('out', null, InputOption::VALUE_OPTIONAL, 'Output file');
        $this->addOption('pidfile', null, InputOption::VALUE_OPTIONAL, 'nginx pid-file', '/var/run/nginx.pid');
        $this->addOption('noreload', null, InputOption::VALUE_NONE, 'Do not reload nginx');
        $this->addOption('noipv6', null, InputOption::VALUE_NONE, 'Omit IPv6 addresses');
    }
    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    protected function GetAnnouncedPrefixes($as)
    {
        $ripe = RipeClient::factory();
        $prefixes = $ripe->GetAnnouncedPrefixes(array('resource' => $as))->toArray();

        if($this->input->getOption('noipv6'))
        {
            $prefixes = $this->FilterIPv6($prefixes);
        }

        return $prefixes['data']['prefixes'];
    }

    private function FilterIPv6($prefixes)
    {
        $prefixes['data']['prefixes'] = array_filter($prefixes['data']['prefixes'],
            function($n)
            {
                return strpos($n['prefix'], ':') === false;
            });

        return $prefixes;
    }

    protected function GetFileOutput()
    {
        if($out = $this->input->getOption('out'))
        {
            return new Console\Output\StreamOutput(fopen($out,'w'));
        }
        return null;
    }

    protected function ReloadNginx()
    {
        if($this->input->getOption('noreload')){return;}

        $pidfile = $this->input->getOption('pidfile');

        if(!($pid = (int)file_get_contents($pidfile))){
            throw new \Exception('Could not read nginx pid from '.$pidfile);
        }

        defined('SIGHUP') or define('SIGHUP',1);
        if(!posix_kill($pid, SIGHUP)){
            throw new \Exception('Could not send SIGHUP to '.$pid);
        }
    }
}