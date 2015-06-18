<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Goutte\Client;
use AppBundle\Parser\VdmPageParser;

class ScrapingCommand extends ContainerAwareCommand
{
    const NUMBER_OF_POSTS = 200;

    protected function configure()
    {
        $this
            ->setName('vdm:scrape')
            ->setDescription('Scrape and persist the first 200 VDMs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('Scraping...');

        $client = new Client();
        $numberOfPosts = 0;
        $pageNumber = 0;
        while($numberOfPosts < self::NUMBER_OF_POSTS) {
            $output->writeln('Page '.$pageNumber);
            $crawler = $client->request('GET', 'http://www.viedemerde.fr/?page='.$pageNumber++);
            $posts = VdmPageParser::getPosts($crawler);

            $i = 0;
            $length = count($posts);
            while($i < $length && $numberOfPosts++ < self::NUMBER_OF_POSTS) {
                $em->persist($posts[$i++]);
            }
        }
        $em->flush();

        $output->writeln('Scraped.');
    }
}
