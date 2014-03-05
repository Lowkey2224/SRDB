<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 21.02.14
 * Time: 17:31
 */

namespace Loki\CharacterBundle\Service\Character;
use Loki\CharacterBundle\Entity\CharacterToAttribute;
use Loki\CharacterBundle\Repository\CharacterRepository;
use Loki\CharacterBundle\Repository\CharacterToAttributeRepository;
use Loki\CharacterBundle\Service\Attribute\Service as AttService;

class Service {

    private $attributeService;
    private $characterRepo;
    private $characterToAttributeRepo;

    public function __construct( $srv,  $repo,  $repo2)
    {
        $this->attributeService = $srv;
        $this->characterRepo = $repo;
        $this->characterToAttributeRepo = $repo2;
    }

    public function foo()
    {
        return "bar";
    }


} 