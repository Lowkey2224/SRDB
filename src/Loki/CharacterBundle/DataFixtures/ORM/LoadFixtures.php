<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 21.02.14
 * Time: 15:22
 */

namespace Loki\CharacterBundle\DataFixtures;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures implements  FixtureInterface{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $objects = \Nelmio\Alice\Fixtures::load(__DIR__.'/fixtures.yml', $manager,
            array('locale' => 'de_DE')
        );

        // optionally persist them into the doctrine object manager
        // you can also do that yourself or persist them in another way
        // if you do not use doctrine
        $persister = new \Nelmio\Alice\ORM\Doctrine($manager);
        $persister->persist($objects);

    }
}