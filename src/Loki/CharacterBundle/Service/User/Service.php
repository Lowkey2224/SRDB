<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 12.02.14
 * Time: 16:13
 */
namespace Loki\CharacterBundle\Service\User;

use Loki\CharacterBundle\Entity\Character;

class Service {

    private $securityContext;

    public function __construct($context)
    {
        $this->securityContext = $context;
    }

    public function isLoggedIn()
    {
        return $this->securityContext->isGranted('ROLE_USER');
    }

    public function isAdmin()
    {
        return ($this->securityContext->isGranted('ROLE_ADMIN')
        || $this->securityContext->isGranted('ROLE_SUPERADMIN'));
    }

    public function isAllowedToEdit($user, $character, $childEntity = null)
    {
//        if($this->securityContext->isGranted('ROLE_ADMIN'))
//            return true;
        if (!($character instanceof Character))
            return false;
        if (is_null($character->getUser()) || $character->getUser() == $user)
            return true;
        if(!is_null($childEntity) && ($childEntity->getCharacter() == $character))
        {
            return true;
        }
        return false;
    }


} 