<?php

namespace GestionCvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class ProfilType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phone')
            ->add('logoFile', VichFileType::class, [
            'label'         => false,
            'required'      => false,
            'allow_delete'  => false,
            'download_link' => true,
        ])
            ->add('bannerFile', VichFileType::class, [
                'label'         => false,
                'required'      => false,
                'allow_delete'  => false,
                'download_link' => true,
            ])
            ->add('type')
            ->add('mobile')->add('fax')
            ->add('user');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionCvBundle\Entity\Profil'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestioncvbundle_profil';
    }


}
