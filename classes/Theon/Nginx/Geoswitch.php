<?php namespace Theon\Nginx;
use Symfony\Component\Console;
use Theon\Ripe\AnnouncedPrefixesCommand;

class Geoswitch extends AnnouncedPrefixesCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addOption('zone', null, Console\Input\InputOption::VALUE_REQUIRED, 'nginx zone name');
        $this->setDescription('Generates nginx Geoswitch-to-zone mapping for Internet AS');
        $this->setHelp('Generates nginx Geoswitch-to-zone mapping for Internet AS');
    }

    protected function execute(Console\Input\InputInterface $input,
                               Console\Output\OutputInterface $output)
    {
        parent::execute($input, $output);

        $as = $this->GetAnnouncedPrefixes((int)$input->getOption('as'));
        $output = $this->GetFileOutput() ?: $output;

        foreach($as as $network)
        {
            $output->write(sprintf('%s %s;'.PHP_EOL,$network['prefix'], $input->getOption('zone')));
        }

        $this->ReloadNginx();
    }
}