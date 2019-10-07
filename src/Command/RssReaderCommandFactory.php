<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Command;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class RssReaderCommandFactory
 */
final class RssReaderCommandFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return RssReaderCommand
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): RssReaderCommand
    {
        return new RssReaderCommand();
    }
}