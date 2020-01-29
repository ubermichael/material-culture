<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

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
