<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setMethod('GET')
            ->add('sites', EntityType::class, [
            'class' => Site::class,
            'choice_label' => 'nom',
        ])
            ->add('nom', TextType::class, [
                'label' => 'Le nom de la sortie contient :'
                ])
            ->add('startDate', DateType::class, [
                'required' => false,
                'label' => 'Entre : ',
                'widget' => 'single_text'
                ])
            ->add('endDate', DateType::class, [
                'required' => false,
                'label' => ' et : ',
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [
            'label' => 'Rechercher'
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}