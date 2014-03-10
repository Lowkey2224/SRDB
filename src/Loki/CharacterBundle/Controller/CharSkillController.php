<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 10.03.14
 * Time: 19:25
 */

namespace Loki\CharacterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Loki\CharacterBundle\Entity\CharacterSkillToSpecialization;
use Loki\CharacterBundle\Form\CharacterSkillToSpecializationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CharSkillController
 * @Route("/specialization")
 * @package Loki\CharacterBundle\Controller
 */
class CharSkillController extends Controller{

    /**
     * @Route("/edit/{characterId}/{skillId}/{specializationId}", name="loki_character_charskill_edit", requirements={"specializationId" = "\d+"}, defaults={ "specializationId" = 0})
     * @Template()
     * @param $characterId
     * @param $skillId
     * @param $specializationId
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editSpecializationAction($characterId, $skillId, $specializationId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $SkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $skill = $SkillRepo->findOneById($skillId);
        $char = $charRepo->findOneById($characterId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn() || is_null($char) || is_null($skill)) {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $charSkillToSpecRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterSkillToSpecialization");
        if (is_null($charSkillToSpecRepo->findOneById($specializationId))) {
            $charskillToSpec = new CharacterSkillToSpecialization();
            $charskillToSpec->setSkill($skill);
        } else {
            $charskillToSpec = $charSkillToSpecRepo->findOneById($specializationId);
        }

        if (!$userService->isAllowedToEdit($this->getUser(), $char, $charskillToSpec)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $form = $this->createForm(new CharacterSkillToSpecializationType(), $charskillToSpec,
            array('attr' => array('skill' => $skillId)));
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if ($form->isValid()) {
                $charskillToSpec = $charSkillToSpecRepo->persist($charskillToSpec);
                $this->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Spezialisierung ' . $charskillToSpec->getSpecialization()->getName() . ' wurde für ' . $char->getName(
                        ) . ' gespeichert.'
                    );

                return $this->redirect(
                    $this->generateUrl(
                        'loki_character_show_character',
                        array('characterId' => $characterId)
                    )
                );
            } else {
                $errorHandler = $this->get('loki_character.errorHandler');
                $errorArray = $errorHandler->getErrorMessages($form);
                foreach ($errorArray as $error) {
                    $this->get('session')->getFlashBag()->add('form-error', $error);
                }
            }
        }

        return (array(
            'form' => $form->createView(),
            'spec' => $charskillToSpec,
            'character' => $char,
        ));
    }

} 