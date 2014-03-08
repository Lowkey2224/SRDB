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

class BackEndController extends Controller{

    /**
     * Action for adding new Characters
     * @Route("/edit/$characterId")

     * @Template()
     */
    public function editCharacterAction($characterId = 0)
    {
        $userService = $this->get('loki_character.user');
        if(!$userService->isLoggedIn())
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = is_null($charRepo->findOneById($characterId))?new Character():$charRepo->findOneById($characterId);
        $userService->isAllowedToEdit($this->getUser(), $char);

        $form = $this->createForm(new CharacterType(), $char);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {

                $this->get('loki_character.attribute')->initializeAttributes();
                $char->setUser($this->getUser());
                $entry = $charRepo->persist($char);
                if (is_null($entry)) {
                    $this->get('session')
                        ->getFlashBag()
                        ->add('error', 'Eintrag existiert bereits');
                    return $this->redirect(
                        $this->generateUrl('loki_character_show_character_for_user', array("userId" => $this->getUser()->getId()))
                    );
                } else {
                    $this->get('session')
                        ->getFlashBag()
                        ->add('success', 'Eintrag gespeichert.');

                    if(is_null($char->getAttributes())|| $char->getAttributes()->isEmpty()){
                        $this->addAttributesToCharacter($entry,
                            $this->getDoctrine()->getRepository('LokiCharacterBundle:CharacterToAttribute'),
                            $this->getDoctrine()->getRepository('LokiCharacterBundle:Attribute')
                    );
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
        }

        return(array(
            'form' => $form->createView(),
        ));
    }



    /**
     * Action for adding new Characters
     * @Route("/add/skill")

     * @Template()
     */
    public function addSkillAction()
    {
        if(!$this->get('loki_character.user')->isLoggedIn())
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $skill = new Skill();
        $form = $this->createForm(new SkillType(), $skill);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            $skillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Skill");
            if($form->isValid())
            {
                $skill = $skillRepo->persist($skill);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
                return $this->redirect(
                    $this->generateUrl('loki_character_index')
                );
            }
        }

        return(array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $characterId
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/add/skill/{characterId")
     * @Template()
     */
    public function addSkillToCharacterAction($characterId)
    {
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->findOneById($characterId);
        if(!$this->get('loki_character.user')->isLoggedIn() || is_null($char))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $charSkill = new CharacterToSkill();
        $form = $this->createForm(new CharacterToSkillType(), $charSkill);
        $request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->submit($request);
            $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
            if($form->isValid())
            {
                $charSkill->setCharacter($char);
                $charToSkillRepo->persist($charSkill);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
                return $this->redirect(
                    $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
                );
            }

        }
        return(array(
            'form' => $form->createView(),
            'character' => $char
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
        $charRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character");
        $char = $charRepo->findOneById($characterId);
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $charSkill = $charToSkillRepo->findOneById($skillId);
        if(!$this->get('loki_character.user')->isLoggedIn() || is_null($char) || is_null($charSkill) )
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $charToSkillRepo->delete($charSkill);
        $this->get('session')
            ->getFlashBag()
            ->add('success', 'Eintrag gelöscht.');
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
        $charToSkillRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToSkill");
        $charskill = $charToSkillRepo->findOneById($skillId);
        if(!$this->get('loki_character.user')->isLoggedIn()||is_null($char))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        if(is_null($charskill))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_add_skill_to_character', array("characterId" => $characterId))
            );
        }
        $form = $this->createForm(new CharacterToSkillType(), $charskill);
        $request = $this->getRequest();
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $charskill = $charToSkillRepo->persist($charskill);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
                return $this->redirect($this->generateUrl(
                       'loki_character_show_character', array('characterId' => $characterId)
                    ));
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
        if(!$this->get('loki_character.user')->isLoggedIn())
        {
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }
        $char = $this->getDoctrine()->getRepository("LokiCharacterBundle:Character")->findOneById($characterId);
        $charToAttributeRepo = $this->getDoctrine()->getRepository("LokiCharacterBundle:CharacterToAttribute");
        $attr = $this->getCharacterAttributeByAttributeId($char,$attributeNumber,$charToAttributeRepo,
            $this->getDoctrine()->getRepository("LokiCharacterBundle:Attribute")
        );
        if(is_null($attr))
        {
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );
        }
        $form = $this->createForm(new CharacterToAttributeType(), $attr);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if($form->isValid())
            {
                $attr = $charToAttributeRepo->persist($attr);
                $this->get('session')
                    ->getFlashBag()
                    ->add('success', 'Eintrag gespeichert.');
            }
            return $this->redirect(
                $this->generateUrl('loki_character_show_character', array("characterId" => $characterId))
            );

        }

        return(array(
            'attribute' => $attr->getAttribute(),
            'character' => $char,
            'form' => $form->createView(),
        ));

    }



    private function addAttributesToCharacter($character, $characterToAttributeRepository, $attrRepo)
    {
        $repo = $characterToAttributeRepository;
        $attr = array();
        for($i = 1 ; $i<=8; $i++)
        {
            $attr[$i] = new CharacterToAttribute();
            $attr[$i]->setLevel(1);
            $attr[$i]->setCharacter($character);
        }
        $attr[1]->setAttribute($attrRepo->getConstitution());
        $attr[2]->setAttribute($attrRepo->getQuickness());
        $attr[3]->setAttribute($attrRepo->getStrength());
        $attr[4]->setAttribute($attrRepo->getCharisma());
        $attr[5]->setAttribute($attrRepo->getIntelligence());
        $attr[6]->setAttribute($attrRepo->getWillpower());
        $attr[7]->setAttribute($attrRepo->getEssence());
        $attr[8]->setAttribute($attrRepo->getMagic());
        for($i = 1 ; $i<=8; $i++)
        {

            $repo->persist($attr[$i]);
        }
    }

    private function getCharacterAttributeByAttributeId($char, $attrId, $charToAttrrepo, $attrRepo)
    {
        $attr = null;
        $attribute = $attrRepo->findOneById($attrId);
        $attr = $charToAttrrepo->findByOneCharacterAndAttribute($char, $attribute);
        return $attr;
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
    private function warmup($charId,$charRepo, $otherId, $otherRepo, $user)
    {
        $userService = $this->get('loki_character.user');
        if(!$userService->isLoggedIn())
        {
            $this->get('session')->getFlashBag()
                ->add('error', 'Bitte loggen sie sich zuerst ein!');
            return $this->redirect(
                $this->generateUrl('loki_character_index')
            );
        }

        $connection = is_null($otherId)?new ConnectionNotInDB():$otherRepo->findOneById($otherId);
        $char = $charRepo->findOneById($charId);
        if(is_null($connection) || is_null($char))
        {
            $this->get('session')->getFlashBag()
                ->add('error', 'Das ist nicht der Eintrag den sie suchen');
            return $this->redirect($this->generateUrl(
                    "loki_show_character", array("characterId" => $charId)
                ));
        }
        if(!$userService->isAllowedToEdit($user, $char))
        {
            $this->get('session')->getFlashBag()
                ->add('error', 'Das ist nicht der Eintrag den sie suchen');
            return $this->redirect($this->generateUrl(
                    "loki_character_index"));
        }
        return true;
    }

} 