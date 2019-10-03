<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity(repositoryClass="App\Repository\SitesRepository")
 */
class Site
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
     * @ORM\Column(name="nom_site", type="string", length=255, nullable=false)
     */
    private $nomSite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participant", mappedBy="site")
     */
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomSite(): string
    {
        return $this->nomSite;
    }

    /**
     * @param string $nomSite
     */
    public function setNomSite(string $nomSite)
    {
        $this->nomSite = $nomSite;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setSite($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getSite() === $this) {
                $participant->setSite(null);
            }
        }

        return $this;
    }
}
