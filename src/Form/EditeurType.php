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
                'label' => 'Nom * ',

                'help' => 'Entrez votre nom de famille dans le champ ci-dessus.',

                'attr' => ['placeholder' => 'Votre nom ici'],

                'invalid_message' => 'Veuillez entrer un nom.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('prenom', null, [
                'label' => 'Prénom * ',
                'help' => 'Entrez votre prénom dans le champ ci-dessus.',

                'attr' => ['placeholder' => 'Votre prénom ici'],

                'invalid_message' => 'Veuillez entrer un prénom.',
                'required' => true,
                'purify_html' => true,
            ])
            ->add('user', UserType::class, [
                'label' => false,
                'help' => 'Le mot de passe doit contenir au moins 8 caractères, dont 1 majuscule, 1 minuscule, 1 chiffre et 1 des caractères spéciaux suivants : @ # % & + = _ ! . $ -'
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
