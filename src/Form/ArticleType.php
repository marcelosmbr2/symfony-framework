<?php

namespace App\Form;

use App\Entity\Article;
//use App\Entity\User;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome do Artigo',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Digite o título do artigo',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descrição Breve',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'placeholder' => 'Uma breve descrição do artigo (aparece nas listagens)',
                ],
                'help' => 'Resumo curto que aparece nas listagens de artigos',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Conteúdo Completo',
                'required' => false,
                'config' => [
                    'toolbar' => 'full',
                    'height' => 500,
                    'language' => 'pt-br',
                    'extraPlugins' => 'uploadimage,image2,colorbutton,font,justify',
                    'filebrowserUploadRoute' => 'app_ckeditor_upload',
                    'filebrowserUploadRouteParameters' => [],
                    'allowedContent' => true,
                ],
                'help' => 'Use o editor rico para formatar seu conteúdo com imagens, listas, tabelas, etc.',
            ])
            ->add('category', TextType::class, [
                'label' => 'Categoria',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Tecnologia, Notícias, Tutorial',
                ],
            ])
            ->add('thumbnail', TextType::class, [
                'label' => 'URL da Thumbnail',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://exemplo.com/imagem.jpg',
                ],
                'help' => 'Imagem de capa do artigo (opcional)',
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publicar artigo',
                'required' => false,
                'help' => 'Marque para tornar o artigo visível publicamente',
            ])
            // Removemos createdAt e updatedAt pois são gerenciados automaticamente
            // Removemos author pois será definido no controller
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}