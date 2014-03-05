<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 13.02.14
 * Time: 15:45
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;


class UserPasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'plainPassword',
            'repeated',
            array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            )
        )
            ->add('submit', 'submit', array('label' => 'Speichern'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Loki\UserBundle\Entity\User'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'loki_userbundle_userpasswordtype';
    }

}