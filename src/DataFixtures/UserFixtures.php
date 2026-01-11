<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@app.com');
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $admin->setAvatar('/images/admin.jpg');
        
        $manager->persist($admin);

        // Criar usuários de exemplo
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@app.com");
            $user->setUsername("user{$i}");
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'user123')
            );
            
            //$user->setAvatar("/uploads/avatars/user{$i}.jpg");
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}