<?php

namespace CloudSource\PatoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CaixasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nome', 'text', array(
                'label' => 'Nome do Caixa',
                'required' => true,
                'attr' => array(
                    'class' => 'span6',
                    'placeholder' => 'Ex. Caixa da Empresa / Caixa Pessoal'
                )
            ))

            ->add('descricao', 'textarea', array(
                'label' => 'Uma descrição para este caixa',
                'required' => true,
                'attr' => array(
                    'class' => 'span6',
                )
            ))

            ->add('salvar', 'submit', array(
                'label' => 'Salvar',
                'attr' => array('class' => 'btn btn-info btn-large pull-right')
            ));
    }

    public function getName()
    {
        return 'caixas';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'CloudSource\PatoBundle\Entity\Caixas'
        );
    }
}