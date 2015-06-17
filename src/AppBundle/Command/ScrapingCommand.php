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
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $output->writeln('Scraping...');

        $client = new Client();
        $numberOfPosts = 0;
        $pageNumber = 0;
        while($numberOfPosts < 200) {
            $output->writeln('Page '.$pageNumber);
            $crawler = $client->request('GET', 'http://www.viedemerde.fr/?page='.$pageNumber++);
            $crawler->filter('.post.article')->each(function($node) use($em, &$numberOfPosts) {
                $additionalInfos = $node->filter('.date > .right_part > p:nth-child(2)')->text();

                $post = new Post();
                $post->setId($node->attr('id'))
                    ->setContent($node->filter('p')->text())
                    ->setAuthor(preg_replace('/^.*?\- par ([^(]+)\(?.*$/', '$1', $additionalInfos))
                    ->setPublishedAt(\DateTime::createFromFormat('d/m/Y', preg_replace('/^Le ([0-9\/]+).*$/', '$1', $additionalInfos)));
                $em->persist($post);

                ++$numberOfPosts;
            });
        }
        $em->flush();

        $output->writeln('Scraped.');
    }
}
