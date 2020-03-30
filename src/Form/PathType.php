<?php

namespace App\Form;

use App\Entity\Path;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PathType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seats', null, [
                "label" => "Nombre de place"
            ])
            ->add('startTime', DateTimeType::class, [
                "label" => "Heure et date de départ",
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd H:mm',
                "html5" => false,
                "data" => new DateTime()
            ])
            ->add('startLocation', null, [
                "label" => "Départ"
            ])
            ->add('endLocation', null, [
                "label" => "Arrivé"
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Nouveau",
                "attr" => [
                    "class" => "btn btn-success"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Path::class,
        ]);
    }
}
