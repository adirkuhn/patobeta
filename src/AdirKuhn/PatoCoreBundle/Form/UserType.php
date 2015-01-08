<?php

namespace AdirKuhn\PatoCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'As senhas devem ser iguais.',
                'required' => true,
                'first_options'  => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repetir senha'),
            ))
            ->add('salt', 'hidden')
            ->add('isActive', null, array(
                'required' => false,
            ))
            ->add('isAdmin', null, array(
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'AdirKuhn\PatoCoreBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adirkuhn_patocorebundle_user';
    }
}
