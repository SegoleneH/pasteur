<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
// use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserType extends AbstractType
{
    // déclaration de la fonction hasher de mdp
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    // function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
    // {

    // }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hasher = $this->hasher;

        $builder
            ->add('email')
            // ->add('roles')

            // Ajout d'un champ pour le mot de passe
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => [
                        'class' => 'password-field',
                        'autocomplete' => 'new-password'
                    ]
                ],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'required' => true
                ])

            //& => il faut rendre accessible le MDP non hashé pour l'utilisateur
            // Ajout d'un event listener pour lancer le hasher au submit
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($hasher) {
               
                $user = $event->getData();
                $password = $user->getPassword();
                $hashedPassword = $hasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $event->setData($user);
            })
            
            //& comment valider champ 'enabled' sans que
            //& l'utilisateur doive cocher la case "enabled"??
            ->add('enabled')
            // ->add('editeur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
