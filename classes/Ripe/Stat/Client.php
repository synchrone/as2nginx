<?php namespace Ripe\Stat;
use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Service\Client as GuzzleClient;

/**
 * Class Client
 * @package Ripe\Stat
 *
 * @method \Guzzle\Service\Command\CommandInterface GetAnnouncedPrefixes(array)
 */
class Client extends GuzzleClient
{
    /**
     * @param array $config
     * @return self
     */
    public static function factory($config = array())
    {
        $instance = parent::factory($config);
        $description = ServiceDescription::factory(__DIR__.DIRECTORY_SEPARATOR.'description.json');
        $instance->setDescription($description);
        return $instance;
    }
}