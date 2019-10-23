<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ImageEntity.
 *
 * @ORM\MappedSuperclass()
 */
abstract class ImageEntity extends AbstractEntity {
    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $originalName;

    /**
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=48, nullable=false)
     */
    private $imageFilePath;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=48, nullable=false)
     */
    private $thumbnailPath;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $imageSize;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageWidth;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageHeight;

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getOriginalName() : ?string {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     *
     * @return ImageTrait
     */
    public function setOriginalName(string $originalName) : ImageEntity {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() : ?File {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     *
     * @return ImageTrait
     */
    public function setImageFile(File $imageFile) : ImageEntity {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageFilePath() : ?string {
        return $this->imageFilePath;
    }

    /**
     * @param string $imageFilePath
     *
     * @return ImageTrait
     */
    public function setImageFilePath(string $imageFilePath) : ImageEntity {
        $this->imageFilePath = $imageFilePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnailPath() : ?string {
        return $this->thumbnailPath;
    }

    /**
     * @param string $thumbnailPath
     *
     * @return ImageTrait
     */
    public function setThumbnailPath(string $thumbnailPath) : ImageEntity {
        $this->thumbnailPath = $thumbnailPath;

        return $this;
    }

    /**
     * @return int
     */
    public function getImageSize() : ?int {
        return $this->imageSize;
    }

    /**
     * @param int $imageSize
     *
     * @return ImageTrait
     */
    public function setImageSize(int $imageSize) : ImageEntity {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getImageWidth() : ?int {
        return $this->imageWidth;
    }

    /**
     * @param int $imageWidth
     *
     * @return ImageTrait
     */
    public function setImageWidth(int $imageWidth) : ImageEntity {
        $this->imageWidth = $imageWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getImageHeight() : ?int {
        return $this->imageHeight;
    }

    /**
     * @param int $imageHeight
     *
     * @return ImageTrait
     */
    public function setImageHeight(int $imageHeight) : ImageEntity {
        $this->imageHeight = $imageHeight;

        return $this;
    }
}