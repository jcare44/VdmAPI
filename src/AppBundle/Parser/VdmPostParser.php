<?php
namespace AppBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\Post;

class VdmPostParser {
    private $node;

    public function __construct(Crawler $node) {
        if($node === null) {
            throw new Exception('Null forbiden.');
        }

        $this->node = $node;
    }

    /**
     * Parse the given page post element
     *
     * @return Post The parsed post
     */
    public function getPost() {
        $additionalInfos = $this->node->filter('.date > .right_part > p:nth-child(2)')->text();

        $post = new Post();
        $post->setId($this->node->attr('id'))
            ->setContent($this->node->filter('p')->text())
            ->setAuthor(preg_replace('/^.*?\- par ([^(]+)\(?.*$/', '$1', $additionalInfos))
            ->setPublishedAt(\DateTime::createFromFormat('d/m/Y', preg_replace('/^Le ([0-9\/]+).*$/', '$1', $additionalInfos)));

        return $post;
    }
}
