<?php
declare(strict_types=1);

namespace ProjectUtilities;

/**
 * Classe pour la gestion des validations captcha
 */
class Captcha
{
    /**
     * @var int
     * L'identifiant du captcha
     */
    private int $id;
    /**
     * @var string
     * Le code du captcha
     */
    private string $code;
    /**
     * @var string
     * L'image en écriture binaire du captcha
     */
    private string $imageBlob;

    /**
     * Constructeur orienté coté base de données
     * @param int $id
     * @param string $code
     * @param string $imageBlob
     */
    public function __construct(int $id, string $code, string $imageBlob){
        $this->id = $id;
        $this->code = $code;
        $this->imageBlob = $imageBlob;
    }

    /*
     * Getters et setters
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getImageBlob(): string
    {
        return $this->imageBlob;
    }

    public function setImageBlob(string $imageBlob): void
    {
        $this->imageBlob = $imageBlob;
    }


}