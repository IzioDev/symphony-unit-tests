<?php

namespace App\Form;

use App\Entity\Path;
use App\Entity\Location;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PathSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('seats', null, [
                    "label" => "Nombre de place",
                    "required" => false,
                    "attr" => ["min" => 1]
                ])
                ->add('startTime', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
                    "label" => "Heure et date de départ",
                    "widget" => 'single_text',
                    "format" => 'yyyy-MM-dd H:mm',
                    "html5" => false,
                    "required" => false,
                    "empty_data" => date_format(new \DateTime(), "Y-m-d h:i")
                ])
                ->add('startLocation', EntityType::class, [
                    "label" => "Départ",
                    "required" => false,
                    "class" => Location::class,
                    "choice_label" => "name",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('l')
                                ->orderBy('l.name', 'ASC')
                        ;
                    }
                ])
                ->add('endLocation', EntityType::class, [
                    "label" => "Arrivé",
                    "required" => false,
                    "class" => Location::class,
                    "choice_label" => "name",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('l')
                                ->orderBy('l.name', 'ASC')
                        ;
                    }
                ])
                ->add('submit', SubmitType::class, [
                    "label" => "Rechercher",
                    "attr" => [
                        "class" => "btn btn-success"
                    ]
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Path::class,
        ]);
    }

}
