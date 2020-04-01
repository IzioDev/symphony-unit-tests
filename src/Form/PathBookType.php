<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PathBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberPassenger', IntegerType::class, [
                "attr" => ["min" => 1, "style" => "width: 80px;"],
                "data" => 1,
                "empty_data" => 1,
                "label" => "Nombre de passagers: "
            ])
                ->add('submit', SubmitType::class, [
                    "label" => "Réserver",
                    "attr" => ["class" => "btn btn-sm btn-warning"]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
