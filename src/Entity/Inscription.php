<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSortie(): Sortie
    {
        return $this->sortie;
    }

    public function setSortie(Sortie $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    public function setParticipant(Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }
}
