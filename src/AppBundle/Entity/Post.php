<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PostRepository")
 * @SWG\Model(id="Post")
 */
class Post implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @SWG\Property(name="id", type="int")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @SWG\Property(name="content", type="string")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     * @SWG\Property(name="publishedAt", type="datetime")
     */
    private $publishedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @SWG\Property(name="author", type="string")
     */
    private $author;


    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->author,
            'publishedAt' => $this->publishedAt->format('Y-m-d H:i:s')
        );
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     * @return Post
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
