<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 13.02.14
 * Time: 15:41
 */


use Loki\UserBundle\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            'text',
            array(
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle'
            )
        )
            ->add(
                'email',
                'email',
                array(
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle'
                )
            )
            /*->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))*/
            ->add(
                'enabled',
                'checkbox',
                array(
                    'value' => true,
                    'required' => false,
                    'attr' => array('class' => 'checkbox'),
                    'label_attr' => array('class' => 'checkbox')
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
        return 'Loki_userbundle_usertype';
    }
}
