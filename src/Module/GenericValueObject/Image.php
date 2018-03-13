<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

use claviska\SimpleImage;
use Project\Configuration;

/**
 * Class Image
 * @package Project\Module\GenericValueObject
 */
class Image
{
    public const USE_TEASER = 'teaser';
    public const USE_BILD = 'bild';
    public const USE_KARTE = 'karte';

    public const PATH_KARTE = 'data/img/reise/karte/';
    public const PATH_REISE = 'data/img/reise/';

    public const TYPE_JPG = 'jpg';
    public const TYPE_PNG = 'png';

    protected const SAVE_QUALITY = 100;
    protected const MAX_LENGTH = 1200;
    protected const MAX_UNCOMPRESSED_FILE_SIZE = 100000;

    public const TYPE_USE = [
        self::USE_TEASER => [
            'maxLength' => 1200,
            'path' => self::PATH_REISE,
        ],
        self::USE_KARTE => [
            'maxLength' => 600,
            'path' => self::PATH_KARTE,
        ],
        self::USE_BILD => [
            'maxLength' => 330,
            'path' => self::PATH_REISE,
        ]
    ];

    public const IMAGE_MAPPING = [
        "image/jpeg" => self::TYPE_JPG,
        "image/png" => self::TYPE_PNG
    ];

    /** @var SimpleImage $image */
    protected $image;

    /** @var string $imagePath */
    protected $imagePath;

    /** @var  array $tempImage */
    protected $tempImage;

    /**
     * Image constructor.
     * @param string $path
     */
    protected function __construct(string $path)
    {
        //$this->image = new SimpleImage($path);
        $this->imagePath = $path;
        // $this->image->autoOrient();

        /*if ($this->image->getAspectRatio() >= 1) {
            $this->image->fitToWidth(self::MAX_LENGTH);
        } else {
            $this->image->fitToHeight(self::MAX_LENGTH);
        }*/

        // $this->image->sharpen();
    }

    /**
     * @param string $path
     * @return Image
     */
    public static function fromFile(string $path): self
    {
        return new self($path);
    }

    /**
     * @param array  $uploadedFile
     * @param string $path
     * @return null|Image
     */
    public static function fromUploadWithSave(array $uploadedFile, string $type): ?self
    {
        if (isset(self::TYPE_USE[$type]) === false) {
            return null;
        }

        $useType = self::TYPE_USE[$type];

        $image = self::fromFile($uploadedFile['tmp_name']);

        $simpleImage = new SimpleImage($uploadedFile['tmp_name']);
        /*$simpleImage->autoOrient();

        if ($simpleImage->getAspectRatio() >= 1) {
            $simpleImage->fitToWidth($useType['maxLength']);
        } else {
            $simpleImage->fitToHeight($useType['maxLength']);
        }*/

        //$simpleImage->sharpen();

        $filePath = $useType['path'] . Filename::generateFilename(Filename::TYPE_IMAGE_MAPPING[$uploadedFile['type']]);

        $simpleImage->toFile($filePath, null, self::SAVE_QUALITY);

        if (Filename::TYPE_IMAGE_MAPPING[$uploadedFile['type']] === self::TYPE_PNG && $uploadedFile['size'] >= self::MAX_UNCOMPRESSED_FILE_SIZE) {
            $config = new Configuration();
            $apiKey = $config->getEntryByName('tinypng-api-key');

            \Tinify\setKey($apiKey);

            $source = \Tinify\fromFile($filePath);
            $source->toFile($filePath);
        }

        $image->setImagePath($filePath);

        return $image;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->imagePath;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->imagePath;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->image->getWidth();
    }

    /**
     * @return SimpleImage
     */
    public function getImage(): SimpleImage
    {
        return $this->image;
    }

    /**
     * @param string $path
     * @return bool
     * @throws \Exception
     */
    public function saveToPath(string $path): bool
    {
        try {
            $this->image->toFile($path, null, self::SAVE_QUALITY);
        } catch (\InvalidArgumentException $error) {
            return false;
        }

        $this->imagePath = $path;

        return true;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath(string $imagePath)
    {
        $this->imagePath = $imagePath;
    }
}