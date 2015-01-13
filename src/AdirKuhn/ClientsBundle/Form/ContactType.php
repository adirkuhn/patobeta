<?php

namespace AdirKuhn\ClientsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
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
            ->add('phone')
            ->add('cellphone')
            ->add('address')
            ->add('district')
            ->add('city')
            ->add('comments')
            ->add('company', 'entity',array(
                'class' => 'ClientsBundle:Company',
                'property' => 'name',
                'placeholder' => 'Selecione uma empresa',
                'empty_value' => null,
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdirKuhn\ClientsBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adirkuhn_clientsbundle_contact';
    }
}
