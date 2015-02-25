<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Helper\ProgressHelper;

class ClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('enigmatic:clear')
            ->setDescription('Vidage des caches, génération des Assets')
            ->addOption('full', null, InputOption::VALUE_NONE, 'Si définie, le repertoire de cache sera vidé')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $this->getContainer()->getParameter('kernel.environment');

        $clean_cache = $input->getOption('full');

        $output->writeln('<comment>Clean cache on <info>'.$env.'</info> environnment ...</comment>');

        $progress = $this->getHelperSet()->get('progress');
        $progress->start($output, ($clean_cache === true)?6:5);


        if ($clean_cache) {
            exec('rm -Rf web/cache/*');
            $output_fin[] = '<comment>Clean web cache directory : </comment><info>OK</info>';
//            exec('rm -Rf app/cache/*');
//            $output_fin[] = '<comment>Clean app cache directory : </comment><info>OK</info>';
            $progress->advance();
        }

        // Génération des assets
        exec('php app/console assets:install web --symlink --env='.$env);
        $output_fin[] = '<comment>Install asset : </comment><info>Ok</info>';
        $progress->advance();

        // Vidage des caches Symfony
        exec('php app/console cache:clear --no-warmup --env='.$env);
        $output_fin[] = '<comment>Clean cache Symfony : </comment><info>OK</info>';
        $progress->advance();

        // Vidage des caches APC
        exec('php app/console apc:clear --env='.$env);
        $output_fin[] = '<comment>Clean cache APC : </comment><info>OK</info>';
        $progress->advance();

        exec('php app/console assetic:dump --env='.$env);
        $output_fin[] = '<comment>Generated asset caches files : </comment><info>OK</info>';
        $progress->advance();

        // Rebuilding caches Symfony
        exec('php app/console cache:warmup --env='.$env);
        $output_fin[] = '<comment>Rebuild cache Symfony : </comment><info>OK</info>';
        $progress->advance();

        $progress->finish();

        foreach ($output_fin as $o) {
            $output->writeln($o);
        }
    }
}