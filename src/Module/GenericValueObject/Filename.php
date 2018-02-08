<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

use Ramsey\Uuid\Uuid;

/**
 * Class Filename
 * @package Project\Module\GenericValueObject
 */
class Filename
{
    public const TYPE_JPG = 'jpg';
    public const TYPE_PNG = 'png';
    public const TYPE_GIF = 'gif';

    public const TYPE_IMAGE_MAPPING = [
        "image/jpeg" => self::TYPE_JPG,
        "image/png" => self::TYPE_PNG,
        "image/gif" => self::TYPE_GIF,

    ];

    /** @var string $type */
    protected $type;

    /** @var Uuid $filename */
    protected $filename;

    /**
     * @param string $file
     * @return Filename
     */
    public static function fromString(string $file): self
    {
        /** @var Uuid $filename */
        $filename = Uuid::fromString(self::getFilenameFromFile($file));

        /** @var string $type */
        $type = self::getTypeFromFile($file);

        return new self($filename, $type);
    }

    /**
     * @param string $type
     * @return Filename
     */
    public static function generateFilename(string $type = self::TYPE_JPG): self
    {
        /** @var Uuid $filename */
        $filename = Uuid::uuid4();

        return new self($filename, $type);
    }

    /**
     * @param string $file
     * @return string
     */
    protected static function getFilenameFromFile(string $file): string
    {
        $filenameArray = explode('.', $file);

        return $filenameArray[0];
    }

    /**
     * @param string $file
     * @return string
     */
    protected static function getTypeFromFile(string $file): string
    {
        $filenameArray = explode('.', $file);

        return $filenameArray[1];
    }

    /**
     * Filename constructor.
     * @param Uuid $filename
     * @param string $type
     */
    protected function __construct(Uuid $filename, string $type)
    {
        $this->filename = $filename;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->filename->toString() . '.' . $this->type;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename->toString();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFile();
    }
}