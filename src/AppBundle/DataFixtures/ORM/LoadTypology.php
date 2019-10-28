<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Typology;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 */
class LoadTypology extends Fixture {
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) {
        $item1 = new Typology();
        $item1->setName('tall-body');
        $item1->setLabel('Tall body');
        $this->addReference('_reference_Typology1', $item1);
        $manager->persist($item1);

        $item2 = new Typology();
        $item2->setName('flat-bottom');
        $item2->setLabel('Flat bottom');
        $this->addReference('_reference_Typology2', $item2);
        $manager->persist($item2);

        $item3 = new Typology();
        $item3->setName('squat-body-plain-neck');
        $item3->setLabel('Squat body & plain neck');
        $this->addReference('_reference_Typology3', $item3);
        $manager->persist($item3);

        $item4 = new Typology();
        $item4->setName('squat-body-narrow-neck');
        $item4->setLabel('Squat body & narrow neck');
        $this->addReference('_reference_Typology4', $item4);
        $manager->persist($item4);

        $manager->flush();
    }
}
