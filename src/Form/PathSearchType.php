<?php

namespace App\Form;

use App\Entity\Path;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PathSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seats', null, [
                "label" => "Nombre de place",
                "required" => false
            ])
            ->add('startTime', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
                "label" => "Heure et date de départ",
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd H:mm',
                "html5" => false,
                "data" => new \DateTime(),
                "required" => false
            ])
            ->add('startLocation', null, [
                "label" => "Départ",
                "required" => false
            ])
            ->add('endLocation', null, [
                "label" => "Arrivé",
                "required" => false
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Rechercher",
                "attr" => [
                    "class" => "btn btn-success"
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Path::class,
        ]);
    }
}
