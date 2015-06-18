<?php
namespace Acme\StoreBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testFindByPage()
    {
        $posts = $this->em
            ->getRepository('AppBundle:Post')
            ->findByPage();

        $this->assertEquals(2, count($posts));

        $this->assertEquals(8553267, $posts[0]->getId());
        $this->assertEquals("Aujourd'hui, dans une salle de classe, j'ai trouvé une trousse dans laquelle il y avait une clé USB, ne sachant pas à qui c'était, je regarde les dossiers de la clé. C'est comme ça que j'ai su que c'était l'une de mes profs, puisque j'ai pu la voir entièrement nue. VDM", $posts[0]->getContent());
        $this->assertEquals('speeeedy', $posts[0]->getAuthor());
        $this->assertEquals('2015-05-19 18:11:34', $posts[0]->getPublishedAt()->format('Y-m-d H:i:s'));

        $this->assertEquals(8561754, $posts[1]->getId());
        $this->assertEquals("Aujourd'hui, je travaille dans un garage. Un client est arrivé, m'a tendu une photo de voiture hyper customisée de GTA V et m'a dit que j'avais une semaine pour la rendre comme ça. La voiture de la photo est une Porsche et sa voiture est une Peugeot. VDM", $posts[1]->getContent());
        $this->assertEquals('charles2cb', $posts[1]->getAuthor());
        $this->assertEquals('2015-06-03 18:11:33', $posts[1]->getPublishedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
