<?php
declare(strict_types = 1);

namespace ConsoleApp\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Application
 */
final class Application extends ConsoleApplication
{
    /** @var ContainerInterface|ServiceManager */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface|ServiceManager $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $config = $this->container->get('config');

        parent::__construct($config['name'], $config['version']);
    }

    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->setAutoExit(false);
        $config = $this->container->get('config');
        foreach ($config['commands'] as $command) {
            $this->add($this->container->get($command));
        }

        return parent::run($input, $output);
    }
}