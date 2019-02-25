<?php

namespace FixitBundle\Form;

use FixitBundle\Entity\CategoryProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class productType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('quantity')
            ->add('price')
            ->add('tel')
            ->add('delivery')
            ->add('description')
            ->add('adress')
            ->add('category','Symfony\Bridge\Doctrine\Form\Type\EntityType',array('class'=>CategoryProduct::class,
                'choice_label'=>'name'
            ))
            ->add('user',HiddenType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FixitBundle\Entity\product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fixitbundle_product';
    }


}
