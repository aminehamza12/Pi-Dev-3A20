<?php

namespace BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BlogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('description')->add('content')
            ->add('notificationEnable',ChoiceType::class,[
                'choices'=>[
                    'Yes'=> 'true',
                    'No'=> 'false',
                ]
            ])
            ->add('commentEnable',ChoiceType::class,[
                'choices'=>[
                    'Yes'=> 'true',
                    'No'=> 'false',
                ]
            ])
            ->add('blogCategorie',EntityType::class,[
                'class'=>'BlogBundle:BlogCategorie',
                'choice_label'=>'name',
            ])
            ->add('imageFile', VichFileType::class, [
            'label'         => false,
            'required'      => false,
            'allow_delete'  => false,
            'download_link' => true,
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Blog'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_blog';
    }


}
