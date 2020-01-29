<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Ceramic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 */
class CeramicFixtures extends Fixture implements DependentFixtureInterface {
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) : void {
        $item1 = new Ceramic();
        $item1->setVessel($this->getReference('_reference_Vessel4'));
        $item1->setGlaze($this->getReference('_reference_Glaze1'));
        $item1->setPaste('brown');
        $item1->setMunsell('YA-10-1');
        $item1->setRecoveryLocation($this->getReference('_reference_Location2'));
        $item1->setRecoveryDate('1975');
        $item1->setManufactureLocation($this->getReference('_reference_Location3'));
        $item1->setManufactureDate('1790-1795');
        $item1->setInstitution($this->getReference('_reference_Institution2'));
        $item1->addCatalogNumber('abc-123');
        $item1->setDescription('A piece of pottery');
        $item1->setTypology($this->getReference('_reference_Typology1'));
        $this->addReference('_reference_Ceramic1', $item1);
        $manager->persist($item1);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies() {
        return [
            VesselFixtures::class,
            GlazeFixtures::class,
            TypologyFixtures::class,
            LocationFixtures::class,
            LocationFixtures::class,
            InstitutionFixtures::class,
        ];
    }
}
