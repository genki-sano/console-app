<?php
declare(strict_types = 1);

namespace ConsoleApp\Console\Command;

use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends AbstractCommand
{
    /** @var string command name */
    protected $command;
    /** @var string command description */
    protected $description;

    /**
     * Execute the console command.
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    abstract protected function action(InputInterface $input, OutputInterface $output);

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->action($input, $output);
    }
}