<?php

namespace App\Form;

use App\Entity\Realisation;
use App\Entity\Technology;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RealisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('date')
            ->add('intro')
            ->add('introLong', TextareaType::class, [
                'help' => 'Utilisez <span class="tooltip" title="texte ici"> pour mettre un indice.\nUtilisez <span class="monospace"> pour utiliser une police sans chasse.'
            ])
            ->add('introImage', FileType::class, [
                'label' => "Image d'intro",
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ]
                    ])
                ]
            ])
            ->add('mainText')
            ->add('features')
            ->add('technologies', EntityType::class, [
                'class' => Technology::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('frontPage')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisation::class,
        ]);
    }
}
