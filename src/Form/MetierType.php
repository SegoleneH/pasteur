<?php

namespace App\Form;

use App\Entity\Metier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez le nom du métier',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez le nom du métier',
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez la description du métier',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez la description du métier',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Metier::class,
        ]);
    }
}
