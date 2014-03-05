<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 19.02.14
 * Time: 12:39
 */

namespace Loki\CharacterBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConnectionNotInDBType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                "level",
                "number",
                array(
                    "label" => "Stufe:",
                    "precision" => 0,
                    "required" => true,
                    "constraints" => array(new NotBlank()),

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
        return "loki_characterbundle_connectionNotInDB";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\ConnectionNotInDB',
            )
        );
    }
}