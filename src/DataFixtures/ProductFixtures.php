<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use  Faker;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $j = 0;
         for($i = 0; $i <= 100; $i++){
            $product = new Product();
             $product->setDescription($faker->text(30));
             $product->setPrice(rand(16,100));
             $product->setSolde('true'|'false');
            if($j == 0){
                $product->setCategory($this->getReference('Colliers'));
                $j = 1;
            } else {
                $product->setCategory($this->getReference( "Boucles d'oreilles"));
                $j = 0;
            }
            $manager->persist($product);
            $this->addReference('product_'.$i, $product);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
