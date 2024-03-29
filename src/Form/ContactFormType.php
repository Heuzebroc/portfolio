<?php

namespace App\Form;

use App\Entity\FormMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    const HONEYPOT_DEFAULT = '123email456';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //honeypot field
            ->add('e-mail', TextType::class, [
                'label' => 'Your email here',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'form-secondary'],
            ])

            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('website', TextType::class, ['label' => 'Site web (facultatif)'])
            ->add('mail', EmailType::class, ['label' => 'Adresse E-mail'])
            ->add('message', TextareaType::class, ['label' => 'Votre message', 'help' => 'Vos données ne seront pas réutilisées ou transmises à des tiers.'])
            ->add('submit', SubmitType::class, ["label" => "Envoyer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormMessage::class,
        ]);
    }
}
