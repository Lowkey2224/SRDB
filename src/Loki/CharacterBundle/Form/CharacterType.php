<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 13.02.14
 * Time: 09:49
 */

namespace Loki\CharacterBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CharacterType extends AbstractType{

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
                "race",
                "text",
                array(
                    "label" => "Rasse:",
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add(
                "occupation",
                "text",
                array(
                    "label" => "Profession:",
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add(
                "description",
                "textarea",
                array(
                    "label" => "Beschreibung:",
                    'attr' => array(
                        'class' => 'form-control',
                        'rows' => 3,
                    ),
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add(
                "reputation",
                "number",
                array(
                    "label" => "Reputation:",
                    "precision" => 0,
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add(
                "goodKarma",
                "number",
                array(
                    "label" => "Gutes Karma:",
                    "precision" => 0,
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add(
                "karmapool",
                "number",
                array(
                    "label" => "karmapool:",
                    "precision" => 0,
                    "required" => true,
                    "constraints" => array(new NotBlank()),

                )
            )
            ->add('type',
                'choice',
                array(
                    'label' => 'Typ:',
                    'choices'   => array(1 => 'SC', 2 => 'NSC'),
                    'preferred_choices' => array(1),
                    'expanded' => true,
                    'required'  => true,
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
        return "loki_characterbundle_character";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\CharacterBundle\Entity\Character',
            )
        );
    }
}