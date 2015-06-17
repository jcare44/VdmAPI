<?php
namespace AppBundle\Tests\Parser;

use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Parser\VdmPageParser;

class VdmPageParserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPosts()
    {
        $crawler = new Crawler(file_get_contents(__DIR__.'/vdmPageParserTest.html'));
        $posts = (new VdmPageParser($crawler))->getPosts();

        $this->assertEquals('17/06/2015', $posts[0]->getPublishedAt()->format('d/m/Y'));
        $this->assertEquals('tartefraise', $posts[0]->getAuthor());
        $this->assertEquals('Aujourd\'hui, pâtissière depuis quelques années, je lis la commande d\'une cliente. Elle veut une tarte aux fraises, mais sans crème, sans nappage et avec un fond de pâte le plus fin possible parce qu\'elle n\'aime pas trop ça. Une barquette de fraises, quoi. VDM', $posts[0]->getContent());

        $this->assertEquals('17/06/2015', $posts[1]->getPublishedAt()->format('d/m/Y'));
        $this->assertEquals('E-miel', $posts[1]->getAuthor());
        $this->assertEquals('Aujourd\'hui, et depuis quelques semaines, je demande régulièrement par courriel une semaine de vacances à ma patronne, sans aucune réponse. En revanche, elle a répondu dans la minute lorsqu\'il fut sujet d\'heures supplémentaires. VDM', $posts[1]->getContent());
    }
}
