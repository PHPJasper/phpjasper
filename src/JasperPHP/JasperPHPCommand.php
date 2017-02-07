<?php
namespace JasperPHP;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JasperPHPCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('process')
             ->setDescription('Description of process', '1.0')
             ->setHelp('Help of process');
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }

}