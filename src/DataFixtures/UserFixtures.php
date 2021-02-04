<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $contributor1 = new User();
        $contributor1->setEmail('contributor1@monsite.com');
        $contributor1->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor1->setName($faker->name);
        $contributor1->setAddress($faker->address);
        $contributor1->setCity($faker->city);
        $contributor1->setCountry('France');
        $contributor1->setSex($faker->randomElement(['F', 'M']));
        $contributor1->setPhone($faker->phoneNumber);
        $contributor1->setPostalCode($faker->postcode);
        $contributor1->setIsAdmin('false');
        $contributor1->setPassword($this->passwordEncoder->encodePassword(
            $contributor1,
            'password'
        ));
        $manager->persist($contributor1);
        $this->addReference('contributor1', $contributor1);

        $manager->flush();
    }
}