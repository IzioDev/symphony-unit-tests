<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                "label" => "Nom"
            ])
            ->add('lat', null, [
                "label" => "Longitude"
            ])
            ->add('lon', null, [
                "label" => "Latitude"
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Nouveau",
                "attr" => [
                    "class" => "btn btn-success"
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
