<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * Form
 *
 * @ORM\Table(name="form")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShapeRepository")
 */
class Shape extends AbstractTerm {

    /**
     * @var Collection|Ceramic[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ceramic", mappedBy="shape")
     */
    private $ceramics;


    /**
     * Add ceramic.
     *
     * @param \AppBundle\Entity\Ceramic $ceramic
     *
     * @return Shape
     */
    public function addCeramic(\AppBundle\Entity\Ceramic $ceramic)
    {
        $this->ceramics[] = $ceramic;

        return $this;
    }

    /**
     * Remove ceramic.
     *
     * @param \AppBundle\Entity\Ceramic $ceramic
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCeramic(\AppBundle\Entity\Ceramic $ceramic)
    {
        return $this->ceramics->removeElement($ceramic);
    }

    /**
     * Get ceramics.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCeramics()
    {
        return $this->ceramics;
    }
}
