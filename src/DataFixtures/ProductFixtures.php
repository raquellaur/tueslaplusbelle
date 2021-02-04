<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use DateTime;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $j = 0;
        for ($i = 0; $i <= 100; $i++) {
            $dateCreation = (new DateTime())->modify('- ' . rand(0, 30) . 'days');
            $product = new Product();
            $product->setDescription($faker->text(30));
            $product->setPrice(rand(16, 50));
            $product->setSolde($faker->randomElement([true,false]));
            $product->setCreatedAt($dateCreation);
            if ($j == 0) {
                $product->setCategory($this->getReference('Colliers'));
                $j = 1;
            } else {
                $product->setCategory($this->getReference("Boucles d'oreilles"));
                $j = 0;
            }
            $manager->persist($product);
            $this->addReference('product_' . $i, $product);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
