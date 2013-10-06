<?php namespace Theon\Nginx;
use Symfony\Component\Console;
use Theon\Ripe\AnnouncedPrefixesCommand;

class Acl extends AnnouncedPrefixesCommand
{
    public function __construct($name = null)
    {
        $this->setDescription('Generates nginx ACL for Internet AS');
        $this->setHelp('Generates nginx ACL for Internet AS');

        parent::__construct($name);
    }

    protected function execute(Console\Input\InputInterface $input,
                               Console\Output\OutputInterface $output)
    {
        parent::execute($input, $output);

        $as = $this->GetAnnouncedPrefixes((int)$input->getOption('as'));
        $output = $this->GetFileOutput() ?: $output;

        foreach($as as $network)
        {
            $output->write(sprintf('allow %s;'.PHP_EOL,$network['prefix']));
        }

        $this->ReloadNginx();
    }
}