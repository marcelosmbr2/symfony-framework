<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        
        if (empty($users)) {
            throw new \Exception('Nenhum usuário encontrado. Execute UserFixtures primeiro.');
        }
        
        $articleData = [
            [
                'name' => 'Introdução ao Symfony 8',
                'description' => 'Aprenda os fundamentos do Symfony 8',
                'content' => '<h1>Introdução ao Symfony 8</h1><p>Symfony é um framework PHP robusto e moderno. Neste artigo, vamos explorar suas principais funcionalidades.</p>',
                'category' => 'Tecnologia',
                'published' => true,
                'thumbnail' => '/uploads/thumbnails/article-1.jpg',
                'author' => $users[array_rand($users)]
            ]
        ];

        // Criar artigos predefinidos
        foreach ($articleData as $data) {
            $article = new Article();
            $article->setName($data['name']);
            $article->setDescription($data['description']);
            $article->setContent($data['content']);
            $article->setCategory($data['category']);
            $article->setIsPublished($data['published']);
            
            $randomUser = $users[array_rand($users)];
            $article->setAuthor($randomUser);
            
            //$article->setThumbnail($data['thumbnail']);
            
            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * Define que esta fixture depende de UserFixtures
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}