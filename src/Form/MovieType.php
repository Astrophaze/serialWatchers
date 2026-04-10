<?php

namespace App\Form;

use App\Entity\Director;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
            ])
            ->add('synopsis', TextType::class, [
                'label' => 'Synopsis',
            ])
            ->add('releaseYear', TextType::class, [
                'label' => 'Release Year',
            ])
            ->add('genre', TextType::class, [
                'label' => 'Genre',
            ])
            ->add('director', EntityType::class, [
                'class' => Director::class,
                'choice_label' => function (Director $director) {
                    return $director->getFirstName() . ' ' . $director->getLastName();
                },
                'label' => 'Director',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
