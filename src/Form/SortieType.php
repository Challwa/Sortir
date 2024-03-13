<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Sortie;
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
                'constraints' => [
                    new notBlank(),
                    new Length(['min' => 2, 'max' => 30])
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'input' => 'string',
                'input_format' => 'd/m/Y H:i',
                'widget' => 'single_text',
                'label' => 'Date et heure de la sortie : ',
                'constraints' => [
                    new NotBlank(),
                    new DateTime()
                ]
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'widget' => 'choice',
                'label' => 'Date limite d\'inscription : ',
                'format' => 'dd/MM/yyyy',
                'constraints' => [
                    new notBlank(),
                    new DateTime()
                ]
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places : ',
                'attr' => [
                    'min' => 2,
                ],
                'constraints' => [
                    new notBlank(),
                ]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée de la sortie (en minutes) : ',
                'attr' => [
                    'min' => 1,
                    'step' => 1
                ],
                'constraints' => [
                    new notBlank(),
                    new Length(['min' => 30])
                ]
            ])
            ->add('infosSortie',TextareaType::class, [
                'label' => 'Description et infos : ',
                'attr' => [
                    'rows' => 5,
                    'cols' => 40,
                ],
                'constraints' => [
                    new Length(['max' => 1000])
                ]
            ])
            ->add('Submit',SubmitType::class,[
                'label' => 'Créer une sortie',
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
