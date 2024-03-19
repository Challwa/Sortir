<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => 'Nom de la sortie : ',
                'data' => 'Nom de la sortie',
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('dateLimiteInscription', DateTimeType::class, [
                'label' => 'Date limite d\'inscriptions : ',
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places : ',
                'attr' => [
                    'min' => 2,
                    'max' => 255,
                    'value' => 10
                ],
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée de la sortie (en minutes) : ',
                'attr' => [
                    'min' => 1,
                    'max' => 1440,
                    'value' => 60
                ],
            ])
            ->add('infosSortie',TextareaType::class, [
                'label' => 'Description et infos : ',
                'data' => 'Description et infos',
            ])
            ->add('lieux', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'label' => 'Lieu de la sortie : ',
                'placeholder' => 'Choisir un lieu',
                'required' => true,
            ])

            ->add('btnRegister', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            ->add('btnPublish', SubmitType::class, [
                'label' => 'Publier la sortie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
