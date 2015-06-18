<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Goutte\Client;
use AppBundle\Parser\VdmPageParser;

/**
 * Purge the DB, scrape and persist the first 200 VDMs
 */
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
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        //Confirmation before purging database
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Your database will be purged, continue ? (y/n)', false);

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        //Purge DB
        $doctrine
            ->getRepository('AppBundle:Post')
            ->deleteAll();
        $output->writeln('Database purged.');

        $output->writeln('Scraping...');

        $client = new Client();
        $numberOfPosts = 0;
        $pageNumber = 0;
        //Scrape the pages until self::NUMBER_OF_POSTS is reached
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
