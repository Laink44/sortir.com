<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lieu
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 * @ORM\Table(name="lieux")
 * @ORM\Entity
 *
 */
class Lieu  implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="lieus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="Lieu")
     */
    private $sorties;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
    }


    /**
     * @return int
     * @Groups("group1")
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
     * @Groups("group1")
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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setLieu($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->contains($sorty)) {
            $this->sorties->removeElement($sorty);
            // set the owning side to null (unless already changed)
            if ($sorty->getLieu() === $this) {
                $sorty->setLieu(null);
            }
        }

        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
           'id'=>$this->getId(),
            'libelle'=>$this->getNomLieu()
       ];
    }
}
