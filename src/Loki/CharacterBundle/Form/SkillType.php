<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 14.02.14
 * Time: 15:52
 */

namespace Loki\CharacterBundle\Form;


use Loki\CharacterBundle\Repository\AttributeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SkillType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataLocked(false);
        $builder->add(
            "name",
            "text",
            array(
                "label" => "Name:",
                "required" => true,
                "constraints" => array(new NotBlank()),

            )
        )
            ->add('type',
                'choice',
                array(
                    'choices'   => array(1 => "Aktionsskill", 2 => "Wissenskill", 3 => "Sprachen"),
                    'preferred_choices' => array(1),
                    'expanded' => true,
                    'required'  => true,
                )
            )
            ->add(
                'attribute',
                'entity',
                array(
                    'label' => 'Attribut:',
                    'required' => true,
                    'class' => 'LokiCharacterBundle:Attribute',
                    'property' => 'name',
                    'empty_value' => 'Bitte Attribut auswählen',
                    'query_builder' => function (AttributeRepository $er) {
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
        return "loki_characterbundle_skill";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\Skill',
            )
        );
    }
}