<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        
        $utilisateur = new Utilisateur();
        $utilisateur->setNom('nom');
        $utilisateur->setEmail('test@test.fr');
        $password = $this->hasher->hashPassword($utilisateur,'coucou');
        $utilisateur->setPassword($password);
        #$utilisateur->setDateIns(new \DateTime);
        $manager->persist($utilisateur);

        $admin = new Utilisateur();
        $admin->setNom('moi');
        $admin->setEmail('admin@test.fr');
        $password = $this->hasher->hashPassword($admin,'coucou');
        $admin->setPassword($password);
        $admin->setRoles(["ROLE_MODERATION"]);
        #$admin->setDateIns(new \DateTime);
        $manager->persist($admin);

        $manager->flush();
    }
}
