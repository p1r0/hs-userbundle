<?php

namespace Heapstersoft\Base\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('plainPassword', 'password', array(
                'label'=>'Password'
            ))
            //->add('salt')
            ->add('name')
            ->add('email')
            //->add('roles')
            //->add('isActive')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Heapstersoft\Base\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'heapstersoft_base_userbundle_usertype';
    }
}
