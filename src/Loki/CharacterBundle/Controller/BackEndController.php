<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 12.02.14
 * Time: 16:25
 */

namespace Loki\CharacterBundle\Controller;


use Loki\CharacterBundle\Entity\Attribute;
use Loki\CharacterBundle\Entity\Character;
use Loki\CharacterBundle\Entity\CharacterToAttribute;
use Loki\CharacterBundle\Entity\CharacterToSkill;
use Loki\CharacterBundle\Form\CharacterToAttributeType;
use Loki\CharacterBundle\Form\CharacterToSkillType;
use Loki\CharacterBundle\Form\CharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BackEndController extends Controller
{

    /**
     * Action for adding new Characters
     * @Route("/edit/$characterId")
     * @Template()
     */
    public function editCharacterAction($characterId = 0)
    {
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn()) {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }


        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->find($characterId);
        $new = false;
        if (is_null($char)) {
            $char = new Character();
            $new = true;
        }
        if (!$userService->isAllowedToEdit($this->getUser(), $char)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }

        $form = $this->createForm(new CharacterType(), $char);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $char->setUser($this->getUser());
                $entry = $charRepo->persist($char);
                if($new)
                {
                    $this->get('loki_character.character')->addAttributesToCharacter($char);
                }
                if (is_null($entry)) {
                    $this->get('session')
                        ->getFlashBag()
                        ->add('error', 'Das sollte nicht passieren. Character wurde nicht gespeichert!');

                    return $this->redirect(
                        $this->generateUrl(
                            'loki_character_show_character_for_user',
                            array("userId" => $this->getUser()->getId())
                        )
                    );
                } else {
                    $this->get('session')
                        ->getFlashBag()
                        ->add('success', 'Character ' . $char->getName() . ' wurde gespeichert.');
                }

                return $this->redirect(
                    $this->generateUrl('loki_character_show_character', array("characterId" => $entry->getId()))
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
        ));
    }

    /**
     * @param $characterId
     * @param $skillId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/delete/{characterId}/skill/{skillId}")
     */
    public function deleteCharacterSkillAction($characterId, $skillId)
    {
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn()) {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }

        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->find($characterId);
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $charSkill = $charToSkillRepo->find($skillId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isAllowedToEdit($this->getUser(), $char)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $charToSkillRepo->delete($charSkill);
        $this->get('session')
            ->getFlashBag()
            ->add(
                'success',
                'Skill ' . $charSkill->getSkill()->getName() . ' wurde für ' . $char->getName() . ' gelöscht.'
            );

        return $this->redirect(
            $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
        );
    }

    /**
     * @Route("/edit/{characterId}/skill/{skillId}")
     * @Template()
     * @Security("is_granted('ROLE_USER')")
     */
    public function editCharacterSkillAction($characterId, $skillId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->find($characterId);
        $userService = $this->get('loki_character.user');
        if (is_null($char)) {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $charskill = $charToSkillRepo->find($skillId);
        if (is_null($charskill)) {
            $charskill = new CharacterToSkill();
            $charskill->setCharacter($char);
        }
        if (!$userService->isAllowedToEdit($this->getUser(), $char, $charskill)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $form = $this->createForm(new CharacterToSkillType(), $charskill);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if ($form->isValid()) {
                $charskill = $charToSkillRepo->persist($charskill);
                $this->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'SKill ' . $charskill->getSkill()->getName() . ' wurde für ' . $char->getName(
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
            'charSkill' => $charskill,
            'character' => $char,
        ));

    }

    /**
     * Action for editing the levels of each Attribute
     * @Route("/edit/{characterId}/attribute/{attributeNumber}")
     * @Template()
     */
    public function editCharacterAttributeAction($characterId, $attributeNumber)
    {
        $char = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character")->find($characterId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn() || is_null($char)) {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }

        $charToAttributeRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToAttribute");
        $attr = $charToAttributeRepo->findOneBy(
            array(
                'character' => $char,
                'attribute' => $this->getDoctrine()->getRepository("LokiCharacterBundle:Attribute")->find(
                        $attributeNumber
                    )
            )
        );
        if (!$userService->isAllowedToEdit($this->getUser(), $char, $attr)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        if (is_null($attr)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $form = $this->createForm(new CharacterToAttributeType(), $attr);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if ($form->isValid()) {
                $charToAttributeRepo->persist($attr);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
            } else {
                $errorHandler = $this->get('loki_character.errorHandler');
                $errorArray = $errorHandler->getErrorMessages($form);
                foreach ($errorArray as $error) {
                    $this->get('session')->getFlashBag()->add('form-error', $error);
                }
            }

            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );

        }

        return (array(
            'attribute' => $attr->getAttribute(),
            'character' => $char,
            'form' => $form->createView(),
        ));
    }

} 