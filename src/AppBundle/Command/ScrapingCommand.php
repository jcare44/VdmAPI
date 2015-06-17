<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Goutte\Client;
use AppBundle\Entity\Post;

class ScrapingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vdm:scrape')
            ->setDescription('Scrape and persist the first 200 VDMs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$logger = $this->getContainer()->get('logger');
        $doctrine = $this->getContainer()->get('doctrine');

        $output->writeln('Scraping...');

        $client = new Client();
        $crawler = $client->request('GET', 'http://www.viedemerde.fr/');
        $crawler->filter('.post.article')->each(function($node) use($output) {
            $output->writeln($node->filter('p')->text());
            $additionalInfos = $node->filter('.date > .right_part > p:nth-child(2)')->text();
            $output->writeln(preg_replace('/^Le ([0-9\/]+).*$/', '$1', $additionalInfos));
            $output->writeln(preg_replace('/^.*?\- par ([^(]+)\(?.*$/', '$1', $additionalInfos));
        });
    }
}
