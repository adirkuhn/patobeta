<?php

namespace CloudSource\PatoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EmpresasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            //->add('id', 'hidden')

            ->add('razaoSocial', 'text', array(
                'label' => 'Razão Social',
                'required' => false,
                'attr' => array('class' => 'span6')
            ))

            ->add('nomeFantasia', 'text', array(
                'label' => 'Nome Fantasia *',
                'required' => true,
                'attr' => array('class' => 'span6')
            ))

            ->add('cnpj', 'text', array(
                'label' => 'CNPJ',
                'required' => false,
                'attr' => array('class' => 'span3')
            ))

            ->add('email', 'text', array(
                'label' => 'Email',
                'required' => false,
                'attr' => array('class' => 'span6 add-on')
            ))

            ->add('site', 'text', array(
                'label' => 'Site',
                'required' => false,
                'attr' => array('class' => 'span6')
            ))

            ->add('endereco', 'text', array(
                'label' => 'Endereço',
                'required' => false,
                'attr' => array('class' => 'span6')
            ))

            ->add('enderecoComplemento', 'text', array(
                'label' => 'Complemento',
                'required' => false,
                'attr' => array('class' => 'span6')
            ))

            ->add('bairro', 'text', array(
                'label' => 'Bairro',
                'required' => false,
                'attr' => array('class' => 'span6')
            ))

            ->add('estado', 'entity', array(
                'mapped' => false,
                'class' => 'PatoBundle:Estados',
                'property' => 'estado',
                'empty_value' => 'Selecione um estado',
                'label' => 'Estado',
                'required' => false,
                'attr' => array('class' => 'span3')
            ))

            ->add('cidade', 'entity', array(
                'class' => 'PatoBundle:Cidades',
                'property' => 'cidade',
                'empty_value' => 'Selecione um estado primeiro',
                'label' => 'Cidade',
                'attr' => array('class' => 'span3', 'disabled' => 'disabled')
            ))

            // ->add('cancelar', 'button', array(
            //     'label' => 'Cancelar',
            //     'attr' => array(
            //         'class' => 'btn btn-warning btn-large pull-left',
            //         'onclick' => 'window.history.back();'
            //     )
            // ))

            ->add('salvar', 'submit', array(
                'label' => 'Salvar',
                'attr' => array('class' => 'btn btn-info btn-large pull-right')
            ));
    }

    public function getName()
    {
        return 'empresas';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'CloudSource\PatoBundle\Entity\Empresas'
        );
    }
}