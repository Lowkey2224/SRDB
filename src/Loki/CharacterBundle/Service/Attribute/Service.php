<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 14.02.14
 * Time: 13:54
 */

namespace Loki\CharacterBundle\Service\Attribute;

class Service {

    private $repo;

    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    public function initializeAttributes()
    {
        $_tmpCon = $this->repo->findOneById(1);
        if(is_null($_tmpCon) || "Konstitution" != $_tmpCon->getName())
        {
            $con = new Attribute();
            $con->setName("Konstitution");
            $con->setId(1);
            $qck = new Attribute();
            $qck->setName("Schnelligkeit");
            $qck->setId(2);
            $str = new Attribute();
            $str->setName("Stärke");
            $str->setId(3);
            $cha = new Attribute();
            $cha->setName("Charisma");
            $cha->setId(4);
            $int = new Attribute();
            $int->setName("Intelligenz");
            $int->setId(5);
            $will = new Attribute();
            $will->setName("Willenskraft");
            $will->setId(6);
            $ess = new Attribute();
            $ess->setName("Essenz");
            $ess->setId(7);
            $mag = new Attribute();
            $mag->setName("Magie");
            $mag->setId(8);
            $this->repo->persist($con);
            $this->repo->persist($qck);
            $this->repo->persist($str);
            $this->repo->persist($cha);
            $this->repo->persist($int);
            $this->repo->persist($will);
            $this->repo->persist($ess);
            $this->repo->persist($mag);
        }
    }


} 