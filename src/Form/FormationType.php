<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultDate = $options['data']->getPublishedAt() ?? new \DateTime();
        $builder
                
            ->add('publishedAt', null,[
                'label' => 'Date',
                'required' =>true,
               
                'data' => $defaultDate,
                'constraints' => [
                    new LessThanOrEqual('today'),   
                ],
            ])
            ->add('title', null,[
                
                'label' => 'Titre',
                'required' =>true,
                
            ])
                
            ->add('playlist', EntityType::class,[
                'class' => Playlist::class,
                'choice_label' => 'name',
                'label' => 'Playlist',
                'required' => true,
                'multiple' => false,
                
            ])

            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name', 
                'label' => 'Catégories',
                'multiple' => true,
                'required' => false,
            ])

            ->add('description')
            ->add('videoId', null,[
                 'required' =>true,  
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
