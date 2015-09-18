<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 19:15
 */

namespace Loki\CharacterBundle\Controller;

use Loki\CharacterBundle\Entity\Skill;
use Loki\CharacterBundle\Entity\Specialization;
use Loki\CharacterBundle\Form\SkillType;
use Loki\CharacterBundle\Form\SpecializationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SkillController extends Controller{

    /**
     * @return array
     * @Template()
     */
    public function indexAction()
    {
        $userService = $this->get('loki_character.user');
        if(!$userService->isLoggedIn())
        {

            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $isAdmin = $userService->isAdmin();
        $skillRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Skill');
        //For Type Reference see Skill Enitiy
        $actions = $skillRepo->findByType(1);
        $know = $skillRepo->findByType(2);
        $lingua = $skillRepo->findByType(3);
        return array(
            'actionSkills' => $actions,
            'knowledgeSkills' => $know,
            'languageSkills' => $lingua,
            'editable' => true,
            'isAdmin' => $isAdmin,
        );
    }


    /**
     * @param $skillId
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function editAction($skillId)
    {
        $userService = $this->get('loki_character.user');
        if(!$userService->isLoggedIn())
        {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $skillRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Skill');
        $skill = is_null($skillRepo->findOneById($skillId))? new Skill():$skillRepo->findOneById($skillId);
        $form = $this->createForm(new SkillType(), $skill);
        $request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->submit($request);
            if($form->isValid())
            {
                $skillRepo->persist($skill);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Fertigkeit '.$skill->getName().' wurde gespeichert.');
                return $this->redirect(
                    $this->generateUrl('loki_character_skill_index')
                );
            }
        }
        return array(
            'form' => $form->createView(),
            'skill' => $skill,
        );
    }

    /**
     * @param $skillId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($skillId)
    {
        $userService = $this->get('loki_character.user');
        $isAdmin = $userService->isAdmin();
        if(!$isAdmin)
        {
            return $this->redirect(
                $this->generateUrl('loki_character_skill_index')
            );
        }
        $skillRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Skill');
        $skill = $skillRepo->findOneById($skillId);
        if(!is_null($skill))
        {
            $skillRepo->delete($skill);
            $this->get('session')->getFlashbag()
            ->add('success', 'Fertigkeit '. $skill->getName(). ' wurde gelöscht');
        }
        return $this->redirect(
            $this->generateUrl('loki_character_skill_index')
        );
    }


    /**
     * @param $skillId
     * @param $specId
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function editSpecializationAction($skillId, $specId)
    {
        $userService = $this->get('loki_character.user');
        if(!$userService->isLoggedIn())
        {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $skill = $this->getDoctrine()->getRepository('LokiCharacterBundle:Skill')->findOneById($skillId);
        $specRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Specialization');
        $spec = is_null($specRepo->findOneById($specId))? new Specialization():$specRepo->findOneById($specId);
        $spec->setSkill($skill);
        $form = $this->createForm(new SpecializationType(), $spec);
        $request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->submit($request);
            if($form->isValid())
            {
                $specRepo->persist($spec);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Spezialisierung '.$spec->getName().' wurde gespeichert.');
                return $this->redirect(
                    $this->generateUrl('loki_character_skill_index')
                );
            }
        }
        return array(
            'form' => $form->createView(),
            'spec' => $spec,
        );
    }


    public function deleteSpecializationAction($specId)
    {
        $userService = $this->get('loki_character.user');
        $isAdmin = $userService->isAdmin();
        if(!$isAdmin)
        {
            return $this->redirect(
                $this->generateUrl('loki_character_skill_index')
            );
        }
        $specRepo = $this->getDoctrine()->getRepository('LokiCharacterBundle:Specialization');
        $spec = $specRepo->findOneById($specId);
        if(!is_null($spec))
        {
            $specRepo->delete($spec);
            $this->get('session')->getFlashbag()
                ->add('success', 'Spezialisierung '. $spec->getName(). ' wurde gelöscht');
        }
        return $this->redirect(
            $this->generateUrl('loki_character_skill_index')
        );
    }

}
