<?php namespace Theon\Nginx;
use Symfony\Component\Console;
use Theon\Ripe\AnnouncedPrefixesCommand;

class Acl extends AnnouncedPrefixesCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setDescription('Generates nginx ACL for Internet AS');
        $this->setHelp('Generates nginx ACL for Internet AS');
    }

    protected function execute(Console\Input\InputInterface $input,
                               Console\Output\OutputInterface $output)
    {
        $as = $this->GetAnnouncedPrefixes((int)$input->getArgument('as'));

        foreach($as as $network)
        {
            $output->write(sprintf('allow %s;'.PHP_EOL,$network['prefix']));
        }
    }
}