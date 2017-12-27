<?php

namespace MicroCMS\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                    'required'    => true, // verification HTML
                    'constraints' => array(
                        new Assert\NotBlank(), 
                        new Assert\Length(array(
                        'min' => 5,'max' => 100, // il ne peut pas contenir moins de 5 caractères et pas plus de 100. Rappelez-vous, le champ dans notre base de données ne peut pas en contenir plus.
            ))),
            ->add('content', TextareaType::class, array(
                'required'    => true,
                'constraints' => new Assert\NotBlank(),
    }

    public function getName()
    {
        return 'article';
    }
}