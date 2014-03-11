<?php

namespace Loki\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Loki\CharacterBundle\Entity\Character;

class FrontEndController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $charRepo =$this->getDoctrine()->getRepository('LokiCharacterBundle:Character');
        $chars = $charRepo->findAll();
        return array("characters" => $chars);
    }

    /**
     * @Route("/loginFailed")
     * @Template()
     */
    public function loginFailureAction()
    {
        $this->get('session')
            ->getFlashBag()
            ->add('error', 'Login Fehlgeschlagen!');
        return $this->redirect(
            $this->generateUrl('loki_character_index')
        );
    }

    /**
     * @param $userId foo bar vbaz
     * @return Response
     * @Route("/show/user/{userId}")
     */
    public function showForUserAction($userId = 0)
    {
        if($this->get('loki_character.user')->isLoggedIn())
        {
            $userRepo = $this->getDoctrine()->getRepository('LokiUserBundle:User');
            $user = (is_null($userRepo->findOneById($userId)))?$this->getUser():$userRepo->findOneById($userId);

            $charRepo =$this->getDoctrine()->getRepository('LokiCharacterBundle:Character');
            $chars = $charRepo->findByUser($user);

            return $this->render(
                'LokiCharacterBundle:FrontEnd:index.html.twig',
                array('characters' => $chars)
            );
        } else{
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
    }

//require={"name"="\d+"}
    /**
     * @Route("/show/{$characterId}/$showAll")
     * @Template()
     */
    public function showAction($characterId, $showAll= 0)
    {
        $userService = $this->get('loki_character.user');

        if (!$userService->isLoggedIn()) {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $charRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Character');
        $character = $charRepo->findOneById($characterId);
        if(is_null($character) || !($character instanceof Character))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
//                $owner = $em->getRepository("LokiCharacterBundle:User")->find($char->g);
            return array(
                'char' => $character,


                "spells" => array(),
                "kipowers" => array(),
                "cyberware" => array(),
                "editable" => $userService->isAllowedToEdit($this->getUser(), $character),
                'showAll' => $showAll,
            );



    }

    public function showCharAction($character)
    {
        $char = $character;
        return $this->render(
            'LokiCharacterBundle:FrontEnd:showCharacter.html.twig',
            array(
                'char' => $char,
                "editable" => $this->get('loki_character.user')->isAllowedToEdit($this->getUser(), $char),
                "username" => $char->getUser()->getUsername(),
            )
        );
    }

    public function showAttributesAction($character, $showAll= 0)
    {
        return $this->render(
            'LokiCharacterBundle:FrontEnd:showAttributes.html.twig',
            array(
                'char' => $character,
                "attributes" => $character->getAttributes(),
                "editable" => $this->get('loki_character.user')->isAllowedToEdit($this->getUser(), $character),
                'showAll' => ($showAll == 1)?true:false,
            )
        );
    }

    public function showSkillsAction(Character $character)
    {
        return $this->render(
            'LokiCharacterBundle:FrontEnd:showSkills.html.twig',
            array(
                'char' => $character,
                "skills" => $character->getSkills(),
                "editable" => $this->get('loki_character.user')->isAllowedToEdit($this->getUser(), $character),
            )
        );
    }

    public function showEquipAction($character)
    {
        return $this->render(
            'LokiCharacterBundle:FrontEnd:showEquip.html.twig',
            array(
                'char' => $character,
                "equip" => $character->getItems(),
                "editable" => $this->get('loki_character.user')->isAllowedToEdit($this->getUser(), $character),
            )
        );
    }

    public function showConnectionsAction($character)
    {
        return $this->render(
            'LokiCharacterBundle:FrontEnd:showConnections.html.twig',
            array(
                'char' => $character,
                "connections" => $character->getConnectionsInDB(),
                "connectionsNotInDB" => $character->getConnectionsNotInDB(),
                "editable" => $this->get('loki_character.user')->isAllowedToEdit($this->getUser(), $character),
            )
        );
    }





}
