<?php

namespace AdirKuhn\CashFlowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountsType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('type', 'hidden', array(
                'label_attr' => array('style' => 'display: none;')
            ))
            ->add('status', 'choice', array(
                'choices' => array(
                    0 => 'Pago',
                    1 => 'Pagamento Pendente'
                ),
                'preferred_choices' => array(1),
            ))
            ->add('description')
            ->add('createdAt', null, array(
                'attr' => array('style'=>'display: none;'),
                'label_attr' => array('style'=>'display: none;')
            ))
            ->add('dueDate')
            //->add('paidAt')
            ->add('value')
            ->add('Company', 'entity', array(
                'class' => 'ClientsBundle:Company',
                'property' => 'name',
                'placeholder' => 'Selecione uma Empresa para associar',
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
            'data_class' => 'AdirKuhn\CashFlowBundle\Entity\Accounts'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adirkuhn_cashflowbundle_accounts_receivable';
    }
}
