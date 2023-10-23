<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => ['placeholder' => 'Le nom de votre catégorie '],

                'help' => 'Saisissez le nom de votre nouvelle catégorie',
                'help_attr' => ['class' => 'helpForm'],
            ])
            ->add('description', null, [
                'attr' => ['placeholder' => 'Votre description ici'],

                'help' => 'Saisissez une brève description de la catégorie à créer',
                'help_attr' => ['class' => 'helpForm'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
