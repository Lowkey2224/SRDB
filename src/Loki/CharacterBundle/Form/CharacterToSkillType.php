<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 14.02.14
 * Time: 16:25
 */

namespace Loki\CharacterBundle\Form;


use Loki\CharacterBundle\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CharacterToSkillType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataLocked(false);
        $builder->add(
            "level",
            "number",
            array(
                "label" => "Stufe:",
                "precision" => 0,
                "required" => true,
                "constraints" => array(new NotBlank()),

            )
        )
            ->add(
                'skill',
                'entity',
                array(
                    'label' => 'Skill:',
                    'required' => true,
                    'class' => 'LokiCharacterBundle:Skill',
                    'property' => 'name',
                    'empty_value' => 'Bitte Skill auswählen',
                    'query_builder' => function (SkillRepository $er) {
                            return $er->createQueryForFindAll();
                        },
                )
            )
            ->add('submit', 'submit', array(
                    'label' => 'Speichern',
                )
            );


    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "loki_characterbundle_characterToSkill";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\CharacterToSkill',
            )
        );
    }
} 