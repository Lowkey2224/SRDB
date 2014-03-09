<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 09.03.14
 * Time: 18:37
 */

namespace Loki\CharacterBundle\Form;


use Loki\CharacterBundle\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SpecializationType extends AbstractType{

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
            ->add(
                'skill',
                'entity',
                array(
                    'label' => 'Fertigkeit:',
                    'required' => true,
                    'class' => 'LokiCharacterBundle:Skill',
                    'property' => 'name',
                    'empty_value' => 'Bitte Fertigkeit auswählen',
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
        return "loki_characterbundle_specialization";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\Specialization',
            )
        );
    }

} 