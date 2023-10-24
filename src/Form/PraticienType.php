<?php

namespace App\Form;

use App\Entity\Metier;
use App\Entity\Praticien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PraticienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom * ',
                'help' => 'Saisissez le nom du praticien',
                'attr' => [
                    'placeholder' => 'Saisissez le nom du praticien',
                ],
                'purify_html' => true,
            ])
            ->add('prenom', null, [
                'label' => 'Prenom * ',
                'help' => 'Saisissez le prenom du praticien',
                'attr' => [
                    'placeholder' => 'Saisissez le prenom du praticien',
                ],
                'purify_html' => true,
            ])
            ->add('lienRdv', null, [
                'label' => 'Lien de rdv ',
                'help' => 'Saisissez le lien de prise de rdv du praticien (doctissimo). Si aucune valeur n\'est saisie, le numéro du standard sera utilisé.',
                'help_attr' => [ 'class' => 'helpForm'],
                'attr' => [
                    'placeholder' => 'Saisissez le lien de rdv du praticien',
                ],
                'purify_html' => true,
            ])
            ->add('metiers', EntityType::class, [
                'class' => Metier::class,
                'multiple' => true,
                'required' => true,
                'expanded' =>true,
                'label' => 'Métier(s) * ',
                'help' => 'Indiquer au moins 1 métier pour le praticien',
                'invalid_message' => 'Veuillez indiquer au moins 1 métier',
            ])
            ->add('imageFile', VichImageType::class, 
            ['required' => false,
            'download_uri' => false,
            'label' => 'Photo du praticien',
            'help' => 'Choisissez la photo du praticien, si aucune photo n\'est choisie, la photo par défaut sera utilisée',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Praticien::class,
        ]);
    }
}
