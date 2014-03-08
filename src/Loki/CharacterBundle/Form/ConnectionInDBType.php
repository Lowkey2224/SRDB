<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 11:49
 */

namespace Loki\CharacterBundle\Form;


use Loki\CharacterBundle\Repository\CharacterRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConnectionInDBType extends AbstractType{
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
                'target',
                'entity',
                array(
                    'label' => 'Connection:',
                    'required' => true,
                    'class' => 'LokiCharacterBundle:Character',
                    'property' => 'name',
                    'empty_value' => 'Bitte Connection auswählen',
                    'query_builder' => function (CharacterRepository $er) {
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
        return "loki_characterbundle_connectionInDB";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\ConnectionInDB',
            )
        );
    }
} 