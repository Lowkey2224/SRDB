<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 10.03.14
 * Time: 19:19
 */

namespace Loki\CharacterBundle\Form;


use Loki\CharacterBundle\Repository\SpecializationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CharacterSkillToSpecializationType  extends AbstractType{
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
                'specialization',
                'entity',
                array(
                    'label' => 'Spezialisierung:',
                    'required' => true,
                    'class' => 'LokiCharacterBundle:Specialization',
                    'property' => 'name',
                    'empty_value' => 'Bitte Spezialisierung auswählen',
                    'query_builder' => function (SpecializationRepository $er) use ($options){
                            $_tmp = $er->createQueryForFindBySkill($options['attr']['skillId'])->getQuery()->getResult();
                            return $er->createQueryForFindBySkill($options['attr']['skillId']);
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
        return "loki_characterbundle_characterSkillToSpecialization";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\CharacterSkillToSpecialization',
            )
        );
    }

} 