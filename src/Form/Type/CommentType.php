<?php

namespace MicroCMS\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	// Le nom de la zone de texte ("content") n'est pas choisi au hasard : il correspond exactement à la propriété content de la classe métier Comment.
    	// C'est indispensable pour que Symfony puisse associer notre formulaire à une instance de Comment
        $builder->add('email', EmailType::class, [
                    'label'           => 'Votre eMail ',
                    'attr'            => ['placeholder' => '(ne sera pas publié)'],
                    'required'        => true,
                    'invalid_message' => 'Cette eMail n\'est pas valide.',
                    'constraints'     => new Assert\Email(['checkMX' => true]),
                ])
                /*
                Le champ email va avoir une nouvelle contrainte, on lui signifie qu’on veut qu'il soit de type email avec une vérification de l'entrée DNS de type MX.
                C'est pour s'assurer que l'internaute propose bien  un email avec un domaine qui existe et qu'il est bien configuré pour envoyer des emails.
                En gros il va refuser les emails avec un domaine inexistant.
                */
                ->add('website', UrlType::class, [
                    'label'           => 'Your webSite',
                    'required'        => false,
                    'constraints'     => new Assert\Url(),
                ])
                ->add('content', TextareaType::class,[
                    'label'       => 'Your comment',
                    'required'    => true,
                    'constraints' => new Assert\NotBlank(),
        ]);
    }

    public function getName()
    {
        return 'comment';
    }
}
