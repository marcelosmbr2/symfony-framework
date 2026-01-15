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
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $admin->setAvatar('/images/admin.jpg');
        
        $manager->persist($admin);

        // Criar usuários de exemplo
        for ($i = 1; $i <= 2; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@app.com");
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(true);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'user123')
            );
            
            //$user->setAvatar("/uploads/avatars/user{$i}.jpg");
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}