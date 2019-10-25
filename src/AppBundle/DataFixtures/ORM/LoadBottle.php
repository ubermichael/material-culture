<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Bottle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 */
class LoadBottle extends Fixture implements DependentFixtureInterface {
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) {
        $item3 = new Bottle();
        $item3->setCompany('Coca Cola');
        $item3->setBrand('Fanta');
        $item3->setManufacturer($this->getReference('_reference_Manufacturer3'));
        $item3->setContent($this->getReference('_reference_Content5'));
        $item3->setRecoveryLocation($this->getReference('_reference_Location6'));
        $item3->setRecoveryDate('1976');
        $item3->setManufactureLocation($this->getReference('_reference_Location1'));
        $item3->setManufactureDate('1796');
        $item3->setInstitution($this->getReference('_reference_Institution4'));
        $item3->addCatalogNumber('c01');
        $item3->setDescription('<p>Coca Cola bottle with discolored label</p>');
        $this->addReference('_reference_Bottle3', $item3);
        $manager->persist($item3);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies() {
        return array(
            LoadVessel::class,
            LoadGlaze::class,
            LoadLocation::class,
            LoadLocation::class,
            LoadInstitution::class,
            LoadManufacturer::class,
            LoadContent::class,
        );
    }
}
