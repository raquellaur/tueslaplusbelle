<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use DateTime;

class CardFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i <= 50; $i++) {
            $dateCreation = (new DateTime())->modify('- ' . rand(0, 30) . 'days');
            $card = new Card();
            $card->setUser($this->getReference('contributor1'));
            $card->setCreatedAt($dateCreation);
            for ($p = 0; $p <= rand(1,5); $p++){
                $card->addProduct($this->getReference('product_' . rand(1,100)));
            }
            $manager->persist($card);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProductFixtures::class];
    }
}
