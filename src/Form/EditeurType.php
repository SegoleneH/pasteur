<?php

namespace App\Form;

use App\Entity\Editeur;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'labelForm'],

                'help' => 'Entrez ici votre nom de famille.',

                'attr' => ['placeholder' => 'Votre nom ici'],

                'invalid_message' => 'Veuillez entrer un nom.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'label_attr' => ['class' => 'labelForm'],

                'help' => 'Entrez ici votre prénom.',

                'attr' => ['placeholder' => 'Votre prénom ici'],

                'invalid_message' => 'Veuillez entrer un prénom.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('user', UserType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Editeur::class,
        ]);
    }
}
