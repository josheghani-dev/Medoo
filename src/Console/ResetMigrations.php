<?php

namespace Medoo\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.0
 * @package Medoo Console | ResetMigrations
 * */

class ResetMigrations extends Command
{

    public function configure()
    {
        $this->setName('migrate:reset')
             ->setDescription('Reset and re-run all migrations')
             ->addOption('migration','m', InputOption::VALUE_REQUIRED,'call one migration');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        if($input->getOption('migration')){
            $class = "Medoo\\Migrations\\".$input->getOption('migration');
            $migration = new $class;
            $migration->down();
            $migration->up();
        } else {
            $migrations = getMigrations();
            $i = 0;
            while ($i <= count($migrations) - 1){
                $newclass = "Medoo\\Migrations\\".$migrations[$i];
                $class = new $newclass();
                $class->down();
                $class->up();
                $i++;
            }
        }
    }

}