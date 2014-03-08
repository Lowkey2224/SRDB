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

        if (!is_numeric($characterId) || !$userService->isLoggedIn()) {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $id = intval($characterId);
        $em = $this->getDoctrine();
        $charRepo = $em->getRepository('LokiCharacterBundle:Character');
        $char = $charRepo->findOneById($id);
        if(is_null($char) || !($char instanceof Character))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
//                $owner = $em->getRepository("LokiCharacterBundle:User")->find($char->g);
            return array(
                'char' => $char,
                "username" => $char->getUser()->getUsername(),
                "attributes" => $char->getAttributes(),
                "skills" => $char->getSkills(),
                "equip" => $char->getItems(),
                "connections" => $char->getConnectionsInDB(),
                "connectionsNotInDB" => $char->getConnectionsNotInDB(),
                "spells" => array(),
                "kipowers" => array(),
                "cyberware" => array(),
                "editable" => $userService->isAllowedToEdit($this->getUser(), $char),
                'showAll' => ($showAll == 1)?true:false,
            );



    }



}
