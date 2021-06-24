<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('lobosa999@outlook.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setForename('Ferdynand');
        $user->setSurname('Kowalski');
        $user->setDateOfBirth(new \DateTime('19-06-1978'));
        $user->setPlaceOfBirth('Kraków');
        $user->setPESEL('78061912484');

        $manager->persist($user);

        $user = new User();
        $user->setEmail('charlienixon@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setForename('Charlie');
        $user->setSurname('Nixon');
        $user->setDateOfBirth(new \DateTime('15.09.1980'));
        $user->setPlaceOfBirth('Kielce');
        $user->setPESEL('80091587342');
        $user->setIsVerified(true);

        $manager->persist($user);

        $user = new User();
        $user->setEmail('thomasbradshaw@rhyta.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setForename('Thomas');
        $user->setSurname('Bradshaw');
        $user->setDateOfBirth(new \DateTime('09.05.1968'));
        $user->setPlaceOfBirth('Kraków');
        $user->setPESEL('68050912330');

        $manager->persist($user);

        $user = new User();
        $user->setEmail('jasminenaylor@jourrapide.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setForename('Jasmine');
        $user->setSurname('Naylor');
        $user->setDateOfBirth(new \DateTime('25.02.1990'));
        $user->setPlaceOfBirth('Radom');
        $user->setPESEL('90022507438');
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_ADMIN',]);

        $manager->persist($user);

        $manager->flush();
        $manager->clear(User::class);
    }
}
