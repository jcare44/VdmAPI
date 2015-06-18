<?php
namespace AppBundle\Parser;

use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\Post;

class VdmPageParser {
    /**
     * Crawl the given page for posts and return them
     *
     * @param Crawler $crawler The crawler containing a vdm page
     * @return Post[]          The posts in the given page
     */
    public static function getPosts(Crawler $crawler) {
        return $crawler->filter('.post.article')->each(function($node) {
            return self::getPost($node);
        });
    }

    /**
     * Parse the given page post element
     *
     * @param Crawler $node The crawler containing a vdm post
     * @return Post         The parsed post
     */
    public static function getPost(Crawler $node) {
        $additionalInfos = $node->filter('.date > .right_part > p:nth-child(2)')->text();

        $post = new Post();
        $post->setId($node->attr('id'))
            ->setContent($node->filter('p')->text())
            ->setAuthor(trim(preg_replace('/^.*?\- par ([^(]+)\(?.*$/', '$1', $additionalInfos)))
            ->setPublishedAt(\DateTime::createFromFormat('d/m/Y H:i:s', preg_replace('/^Le ([0-9\/]+) à ([0-9\:]{5}).*$/', '$1 $2:00', $additionalInfos)));

        return $post;
    }
}
