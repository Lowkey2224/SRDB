<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 19:15
 */

namespace Loki\CharacterBundle\Controller;

use Loki\CharacterBundle\Entity\Skill;
use Loki\CharacterBundle\Form\SkillType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SkillController extends Controller{

    /**
     * @Template()
     * @return array
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

}
