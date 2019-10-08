<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity(repositoryClass="App\Repository\VillesRepository")
 */
class Ville
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
     * @ORM\Column(name="nom_ville", type="string", length=255, nullable=false)
     */
    private $nomVille;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=10, nullable=false)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="ville", orphanRemoval=true)
     */
    private $lieus;

    public function __construct()
    {
        $this->lieus = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $Id
     */
    public function setId(int $Id)
    {
        $this->id = $Id;
    }

    /**
     * @return string
     */
    public function getNomVille(): string
    {
        return $this->nomVille;
    }

    /**
     * @param string $nomVille
     */
    public function setNomVille(string $nomVille)
    {
        $this->nomVille = $nomVille;
    }

    /**
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     */
    public function setCodePostal(string $codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return Collection|Lieu[]
     */
    public function getLieus(): Collection
    {
        return $this->lieus;
    }

    public function addLieus(Lieu $lieus): self
    {
        if (!$this->lieus->contains($lieus)) {
            $this->lieus[] = $lieus;
            $lieus->setVille($this);
        }

        return $this;
    }

    public function removeLieus(Lieu $lieus): self
    {
        if ($this->lieus->contains($lieus)) {
            $this->lieus->removeElement($lieus);
            // set the owning side to null (unless already changed)
            if ($lieus->getVille() === $this) {
                $lieus->setVille(null);
            }
        }

        return $this;
    }

        public  function __toString()
        {
            return $this->getNomVille();
        }
}
