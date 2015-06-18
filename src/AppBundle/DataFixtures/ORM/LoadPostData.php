<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setId(8553267)
            ->setAuthor('speeeedy')
            ->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2015-05-19 18:11:34'))
            ->setContent("Aujourd'hui, dans une salle de classe, j'ai trouvé une trousse dans laquelle il y avait une clé USB, ne sachant pas à qui c'était, je regarde les dossiers de la clé. C'est comme ça que j'ai su que c'était l'une de mes profs, puisque j'ai pu la voir entièrement nue. VDM");
        $manager->persist($post);

        $post = new Post();
        $post->setId(8561754)
            ->setAuthor('charles2cb')
            ->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2015-06-03 18:11:33'))
            ->setContent("Aujourd'hui, je travaille dans un garage. Un client est arrivé, m'a tendu une photo de voiture hyper customisée de GTA V et m'a dit que j'avais une semaine pour la rendre comme ça. La voiture de la photo est une Porsche et sa voiture est une Peugeot. VDM");
        $manager->persist($post);

        $manager->flush();
    }
}
