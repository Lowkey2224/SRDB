<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 12.02.14
 * Time: 16:25
 */

namespace Loki\CharacterBundle\Controller;


use Doctrine\Common\Persistence\ObjectRepository;
use Loki\CharacterBundle\Entity\Attribute;
use Loki\CharacterBundle\Entity\Character;
use Loki\CharacterBundle\Entity\CharacterToAttribute;
use Loki\CharacterBundle\Entity\CharacterToSkill;
use Loki\CharacterBundle\Entity\ConnectionNotInDB;
use Loki\CharacterBundle\Entity\Skill;
use Loki\CharacterBundle\Form\CharacterToAttributeType;
use Loki\CharacterBundle\Form\CharacterToSkillType;
use Loki\CharacterBundle\Form\CharacterType;
use Loki\CharacterBundle\Form\ConnectionNotInDBType;
use Loki\CharacterBundle\Form\SkillType;
use Loki\CharacterBundle\Repository\MyBaseRepository;
use Loki\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        $char = $charRepo->findOneById($characterId);
        if (is_null($char)) {
            $char = new Character();
            $this->get('loki_character.character')->addAttributesToCharacter($char);
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
                        ->add('success', 'Character '.$char->getName().' wurde gespeichert.');
                }

                return $this->redirect(
                    $this->generateUrl('loki_character_show_character', array("characterId" => $entry->getId()))
                );
            }

        } else {
            $errorHandler = $this->get('hallo_errorhandler');
            $errorArray = $errorHandler->getErrorMessages($form);
            foreach ($errorArray as $error) {
                $this->get('session')->getFlashBag()->add('form-error', $error);
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
        $char = $charRepo->findOneById($characterId);
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $charSkill = $charToSkillRepo->findOneById($skillId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isAllowedToEdit($this->getUser(), $char)) {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $charToSkillRepo->delete($charSkill);
        $this->get('session')
            ->getFlashBag()
            ->add('success', 'Skill '.$charSkill->getSkill()->getName().' wurde für '.$char->getName().' gelöscht.');

        return $this->redirect(
            $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
        );
    }

    /**
     * @Route("/edit/{characterId}/skill/{skillId}")
     * @Template()
     */
    public function editCharacterSkillAction($characterId, $skillId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->findOneById($characterId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn() || is_null($char)) {
            return $this->redirect($this->generateUrl('loki_character_index'));
        }
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        if (is_null($charToSkillRepo->findOneById($skillId))) {
            $charskill = new CharacterToSkill();
            $charskill->setCharacter($char);
        } else {
            $charskill = $charToSkillRepo->findOneById($skillId);
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
                    ->add('success', 'SKill '.$charskill->getSkill()->getName().' wurde für '.$char->getName().' gespeichert.');

                return $this->redirect(
                    $this->generateUrl(
                        'loki_character_show_character',
                        array('characterId' => $characterId)
                    )
                );
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
        $char = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character")->findOneById($characterId);
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn() || is_null($char)) {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }

        $charToAttributeRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToAttribute");
        $attr = $charToAttributeRepo->findOneBy(array('character' => $char,
            'attribute' => $this->getDoctrine()->getRepository("LokiCharacterBundle:Attribute")->findOneById($attributeNumber)
        ));
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
                $attr = $charToAttributeRepo->persist($attr);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
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

    /**
     * Prueft ob der aktuelle Nutzer eingeloggt ist & die berechtigung hat um den eintrag von
     * $otherId zu bearbeiten. Falls nicht wird ein dementsprechender redirect zurückgegeben.
     * Wenn alles Okay ist wird true zurückgegeben.
     * @param $charId int Die ID des Characters.
     * @param $charRepo ObjectRepository Das Repository für Charactere
     * @param $otherId int Die ID des anderen Eintrags
     * @param $otherRepo ObjectRepository Das Repository zum anderen Eintrag.
     * @param $user User der aktuelle Benutzer
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function warmup($charId, $charRepo, $otherId, $otherRepo, $user)
    {
        $userService = $this->get('loki_character.user');
        if (!$userService->isLoggedIn()) {
            $this->get('session')->getFlashBag()
                ->add('error', 'Bitte loggen sie sich zuerst ein!');

            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }

        $connection = is_null($otherId) ? new ConnectionNotInDB() : $otherRepo->findOneById($otherId);
        $char = $charRepo->findOneById($charId);
        if (is_null($connection) || is_null($char)) {
            $this->get('session')->getFlashBag()
                ->add('error', 'Das ist nicht der Eintrag den sie suchen');

            return $this->redirect(
                $this->generateUrl(
                    "loki_show_character",
                    array("characterId" => $charId)
                )
            );
        }
        if (!$userService->isAllowedToEdit($user, $char)) {
            $this->get('session')->getFlashBag()
                ->add('error', 'Das ist nicht der Eintrag den sie suchen');

            return $this->redirect(
                $this->generateUrl(
                    "loki_character_index"
                )
            );
        }

        return true;
    }

} 