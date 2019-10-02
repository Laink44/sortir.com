<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Participant
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantsRepository")
 * @ORM\Table(name="participants")
 * @UniqueEntity(fields={"username"})
 * @UniqueEntity(fields={"mail"})
 */
class Participant implements UserInterface
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
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\Length(max=50, maxMessage="{{ limit }} car&actères maxi")
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30)
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     *
     * @ORM\Column(name="telephone", type="string", length=10)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255, maxMessage="{{ limit }} caractères maxi")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="administrateur", type="boolean")
     * @Assert\NotBlank()
     */
    private $administrateur;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $actif;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="participant", orphanRemoval=true)
     */
    private $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;


    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();


    }




    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function setId(): int
    {
        return $this->id;
    }


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }



    /**
     * @return bool
     */
    public function isAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    /**
     * @param bool $administrateur
     */
    public function setAdministrateur(bool $administrateur)
    {
        $this->administrateur = $administrateur;
    }

    /**
     * @return bool
     */
    public function isActif(): ?bool
    {
        return $this->actif;
    }

    /**
     * @param bool $actif
     */
    public function setActif(bool $actif)
    {
        $this->actif = $actif;
    }




    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ($this->username == "admin" ? ['ROLE_ADMIN'] :['ROLE_USER']);
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }



    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setParticipant($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getParticipant() === $this) {
                $inscription->setParticipant(null);
            }
        }

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }



}
