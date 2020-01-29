<?php

namespace App\Repository;

use App\Entity\Artefact;
use App\Entity\Can;
use Doctrine\Persistence\ManagerRegistry;

/**
 * CanRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CanRepository extends ArtefactRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Can::class);
    }

}
