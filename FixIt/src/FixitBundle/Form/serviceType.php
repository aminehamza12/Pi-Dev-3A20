<?php

namespace FixitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class serviceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type',ChoiceType::class,array('choices'=>array('Service Seeking'=>'Seeking','Service Providing'=>'Providing')))
            ->add('title')
            ->add('description')
            ->add('paymentType',ChoiceType::class,array('choices'=>array('Hour'=>'Hour','Day'=>'Day','flat rate'=>'flat rate')))
            ->add('price')
            ->add('picture',FileType::class, array('data_class' => null))
            ->add('user',HiddenType::class)
            ->add('category')
            ->add('address',HiddenType::class)
//            ->add('addDate',HiddenType::class)
            ->add('views',HiddenType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FixitBundle\Entity\service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fixitbundle_service';
    }


}
