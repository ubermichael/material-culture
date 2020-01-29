<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of FileUploader.
 *
 * @author Michael Joyce <ubermichael@gmail.com>
 */
class FileUploader {
    /**
     * @var string
     */
    private $imageDir;

    public function __construct($imageDir) {
        $this->imageDir = $imageDir;
    }

    public function upload(UploadedFile $file) {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        if ( ! file_exists($this->imageDir)) {
            mkdir($this->imageDir, 0777, true);
        }
        $file->move($this->imageDir, $filename);

        return $filename;
    }

    /**
     * @return string
     */
    public function getImageDir() {
        return $this->imageDir;
    }

    public function getMaxUploadSize($asBytes = true) {
        static $maxBytes = -1;

        if ($maxBytes < 0) {
            $postMax = $this->parseSize(ini_get('post_max_size'));
            if ($postMax > 0) {
                $maxBytes = $postMax;
            }

            $uploadMax = $this->parseSize(ini_get('upload_max_filesize'));
            if ($uploadMax > 0 && $uploadMax < $maxBytes) {
                $maxBytes = $uploadMax;
            }
        }
        if ($asBytes) {
            return $maxBytes;
        }
        $units = ['b', 'Kb', 'Mb', 'Gb', 'Tb'];
        $exp = floor(log($maxBytes, 1024));
        $est = round($maxBytes / 1024 ** $exp, 1);

        return $est . $units[$exp];
    }

    public function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $bytes = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($bytes * 1024 ** stripos('bkmgtpezy', $unit[0]));
        }

        return round($bytes);
    }
}
