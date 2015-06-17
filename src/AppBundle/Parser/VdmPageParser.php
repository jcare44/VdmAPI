<?php
namespace AppBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;

class VdmPageParser {
    private $crawler;

    public function __construct(Crawler $crawler) {
        if($crawler === null) {
            throw new Exception('Null forbiden.');
        }

        $this->crawler = $crawler;
    }

    /**
     * Crawl the given page for posts and return them
     *
     * @return Post[] The posts in the given page
     */
    public function getPosts() {
        return $this->crawler->filter('.post.article')->each(function($node) {
            return (new VdmPostParser($node))->getPost();
        });
    }
}
