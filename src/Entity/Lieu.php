<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="lieux", indexes={@ORM\Index(name="villes_no_ville", columns={"villes_no_ville"})})
 * @ORM\Entity
 */
class Lieu
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lieu", type="string", length=255, nullable=false)
     */
    private $nomLieu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=255, nullable=true)
     */
    private $rue;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="villes_no_ville", type="integer", nullable=false)
     */
    private $villesNoVille;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $noLieu
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomLieu(): string
    {
        return $this->nomLieu;
    }

    /**
     * @param string $nomLieu
     */
    public function setNomLieu(string $nomLieu)
    {
        $this->nomLieu = $nomLieu;
    }

    /**
     * @return string|null
     */
    public function getRue(): string
    {
        return $this->rue;
    }

    /**
     * @param string|null $rue
     */
    public function setRue(string $rue)
    {
        $this->rue = $rue;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return int
     */
    public function getVillesNoVille(): int
    {
        return $this->villesNoVille;
    }

    /**
     * @param int $villesNoVille
     */
    public function setVillesNoVille(int $villesNoVille)
    {
        $this->villesNoVille = $villesNoVille;
    }
}
