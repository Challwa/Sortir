<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : ',
                'disabled' => true,
    ])
            ->add('dateHeureDebut', DateType::class, [
                'label' => 'Date de la sortie : ',
                'widget' => 'single_text',
                'disabled' => true,
            ])
            ->add('sites', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'nom',
                'label' => 'Site organisateur : ',
                'disabled' => true,
            ])
            ->add('lieux', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label' => 'Lieu : ',
                'disabled' => true,
            ])
            ->add('motif', TextareaType::class, [
                'label' => 'Motif : ',

            ])
            ->add('btnRegister', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

}