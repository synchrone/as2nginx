<?php namespace Theon\Nginx;
use Symfony\Component\Console;
use Theon\Ripe\AnnouncedPrefixesCommand;

class Geoswitch extends AnnouncedPrefixesCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setDescription('Generates nginx Geoswitch-to-zone mapping for Internet AS');
        $this->setHelp('Generates nginx Geoswitch-to-zone mapping for Internet AS');
        $this->addArgument('zone', Console\Input\InputArgument::REQUIRED);
    }

    protected function execute(Console\Input\InputInterface $input,
                               Console\Output\OutputInterface $output)
    {
        $as = $this->GetAnnouncedPrefixes((int)$input->getArgument('as'));

        foreach($as as $network)
        {
            $output->write(sprintf('%s %s;'.PHP_EOL,$network['prefix'], $input->getArgument('zone')));
        }
    }
}