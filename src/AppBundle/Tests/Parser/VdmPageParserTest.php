<?php
namespace AppBundle\Tests\Parser;

use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Parser\VdmPageParser;

class VdmPageParserTest extends \PHPUnit_Framework_TestCase
{
    private function assertPosts($posts) {
        $this->assertEquals('17/06/2015 10:27:00', $posts[0]->getPublishedAt()->format('d/m/Y H:i:s'));
        $this->assertEquals('tartefraise', $posts[0]->getAuthor());
        $this->assertEquals('Aujourd\'hui, pâtissière depuis quelques années, je lis la commande d\'une cliente. Elle veut une tarte aux fraises, mais sans crème, sans nappage et avec un fond de pâte le plus fin possible parce qu\'elle n\'aime pas trop ça. Une barquette de fraises, quoi. VDM', $posts[0]->getContent());

        $this->assertEquals('17/06/2015 05:48:00', $posts[1]->getPublishedAt()->format('d/m/Y H:i:s'));
        $this->assertEquals('E-miel', $posts[1]->getAuthor());
        $this->assertEquals('Aujourd\'hui, et depuis quelques semaines, je demande régulièrement par courriel une semaine de vacances à ma patronne, sans aucune réponse. En revanche, elle a répondu dans la minute lorsqu\'il fut sujet d\'heures supplémentaires. VDM', $posts[1]->getContent());
    }

    public function testGetPost()
    {
        $node = new Crawler(utf8_decode(file_get_contents(__DIR__.'/vdmPost0.html')));
        $posts[0] = VdmPageParser::getPost($node);

        $node = new Crawler(utf8_decode(file_get_contents(__DIR__.'/vdmPost1.html')));
        $posts[1] = VdmPageParser::getPost($node);

        $this->assertPosts($posts);
    }

    public function testGetPosts()
    {
        $crawler = new Crawler(file_get_contents(__DIR__.'/vdmPageParserTest.html'));
        $posts = VdmPageParser::getPosts($crawler);

        $this->assertPosts($posts);
    }
}
