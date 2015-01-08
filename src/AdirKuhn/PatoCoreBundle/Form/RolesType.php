<?php

namespace AdirKuhn\PatoCoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RolesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entity')
            ->add('role', 'choice', array(
                'choices' => array('R', 'W', 'D', 'U'),
                'multiple' => true,
            ))
            ->add('user', 'entity', array(
                'class' => 'AdirKuhn\PatoCoreBundle\Entity\User',
                'read_only' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdirKuhn\PatoCoreBundle\Entity\Roles'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adirkuhn_patocorebundle_roles';
    }
}
