<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 11:51
 */

namespace Loki\CharacterBundle\Controller;


use Loki\CharacterBundle\Entity\ConnectionInDB;
use Loki\CharacterBundle\Entity\ConnectionNotInDB;
use Loki\CharacterBundle\Form\ConnectionInDBType;
use Loki\CharacterBundle\Form\ConnectionNotInDBType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ConnectionController extends Controller{
    /**
     * @Route("/add/{characterId}/connection/{connectionId}/{inDB}")
     * @Template()
     */
    public function editConnectionForCharacterAction($characterId, $connectionId, $inDB)
    {
        if($inDB==1)
        {
            $connectionRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:ConnectionInDB");
            $connection = is_null($connectionRepo->findOneById($connectionId))?new ConnectionInDB():$connectionRepo->findOneById($connectionId);
            $form = $this->createForm(new ConnectionInDBType(), $connection);
            return $this->editConnection($connection, $form, true, $connectionRepo, $characterId);
        }elseif($inDB == 0){
            $connectionRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:ConnectionNotInDB");
            $connection = is_null($connectionId)?new ConnectionNotInDB():$connectionRepo->findOneById($connectionId);
            $form = $this->createForm(new ConnectionNotInDBType(), $connection);
            return $this->editConnection($connection, $form, false, $connectionRepo, $characterId);

        }else{
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
    }

    /**
     * @Route("/delete/{characterId}/connection/{connectionId}/{inDB}")
     * @Template()
     */
    public function deleteConnectionForCharacterAction($characterId, $connectionId, $inDB)
    {
        if($inDB==1)
        {
            $connectionRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:ConnectionInDB");
            return $this->deleteConnection($connectionId, $connectionRepo, $characterId);
        }elseif($inDB == 0){
            $connectionRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:ConnectionNotInDB");
            return $this->deleteConnection($connectionId, $connectionRepo, $characterId);

        }else{
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
    }

    private function deleteConnection($connectionId, $connectionRepo, $characterId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->findOneById($characterId);
        $user = $this->getUser();
        $userService = $this->get('loki_character.user');
        if(!$userService->isAllowedToEdit($user,$char))
        {
            $charRepo->delete($connectionRepo->findOneById($connectionId));
            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Eintrag gelöscht.');
        }else{
            $charRepo->delete($connectionRepo->findOneById($connectionId));
            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Uups, Etwas lief falsch, du hättest dort nicht sein sollen.');
        }
        return $this->redirect(
            $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
        );
    }

    private function editConnection($connection, $form, $inDB, $connectionRepository, $characterId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $user = $this->getUser();
        $request = $this->getRequest();
        $char = $charRepo->findOneById($characterId);
        $userService = $this->get('loki_character.user');
        if(!$userService->isAllowedToEdit($user,$char))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        if($request->getMethod()=="POST")
        {
            $form->submit($request);
            if($form->isValid())
            {
                $connection->setOwner($char);
                $connectionRepository->persist($connection);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
                return $this->redirect(
                    $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
                );
            }
        }

        return $this->render(
            'LokiCharacterBundle:Connection:editConnectionForCharacter.html.twig',
            array(
                'form' => $form->createView(),
                'character' => $char,
                'connection' => $connection,
                'inDB' => $inDB,
            ));
    }
} 