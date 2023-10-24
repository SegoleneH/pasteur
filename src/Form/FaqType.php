<?php

namespace App\Form;

use App\Entity\Faq;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', null, [
                'label' => 'Question * ',
                'help' => 'Saisissez la question qui apparaîtra dans la section FAQ',
                'attr' => [
                    'placeholder' => 'Saisissez la question',
                ],
                'purify_html' => true,
            ])
            ->add('reponse', null, [
                'label' => 'Reponse * ',
                'label_attr' => [ 'class' => 'labelForm'],
                'help' => 'Saisissez la réponse qui apparaîtra dans la section FAQ',
                'attr' => [
                    'placeholder' => 'Saisissez la réponse',
                ],
                'purify_html' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Faq::class,
        ]);
    }
}
