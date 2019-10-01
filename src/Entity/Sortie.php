<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sortie
 *
 * @ORM\Table(name="sorties", indexes={@ORM\Index(name="organisateur", columns={"organisateur"}), @ORM\Index(name="etats_no_etat", columns={"etats_no_etat"})})
 * @ORM\Entity
 */
class Sortie
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_sortie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecloture", type="date", nullable=false)
     */
    private $datecloture;

    /**
     * @var int
     *
     * @ORM\Column(name="nbinscriptionsmax", type="integer", nullable=false)
     */
    private $nbinscriptionsmax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptioninfos", type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @var int|null
     *
     * @ORM\Column(name="etatsortie", type="integer", nullable=true)
     */
    private $etatsortie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @var int
     *
     * @ORM\Column(name="organisateur", type="integer", nullable=false)
     */
    private $organisateur;

    /**
     * @var int
     *
     * @ORM\Column(name="lieux_no_lieu", type="integer", nullable=false)
     */
    private $lieuxNoLieu;

    /**
     * @var int
     *
     * @ORM\Column(name="etats_no_etat", type="integer", nullable=false)
     */
    private $etatsNoEtat;

    /**
     * @return int
     */
    public function getNoSortie(): int
    {
        return $this->noSortie;
    }

    /**
     * @param int $noSortie
     */
    public function setNoSortie(int $noSortie)
    {
        $this->noSortie = $noSortie;
    }

    /**
     * @return string
     */
    public function getNom(): string
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
     * @return \DateTime
     */
    public function getDatedebut(): \DateTime
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut(\DateTime $datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return int|null
     */
    public function getDuree(): int
    {
        return $this->duree;
    }

    /**
     * @param int|null $duree
     */
    public function setDuree(int $duree)
    {
        $this->duree = $duree;
    }

    /**
     * @return \DateTime
     */
    public function getDatecloture(): \DateTime
    {
        return $this->datecloture;
    }

    /**
     * @param \DateTime $datecloture
     */
    public function setDatecloture(\DateTime $datecloture)
    {
        $this->datecloture = $datecloture;
    }

    /**
     * @return int
     */
    public function getNbinscriptionsmax(): int
    {
        return $this->nbinscriptionsmax;
    }

    /**
     * @param int $nbinscriptionsmax
     */
    public function setNbinscriptionsmax(int $nbinscriptionsmax)
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;
    }

    /**
     * @return string|null
     */
    public function getDescriptioninfos(): string
    {
        return $this->descriptioninfos;
    }

    /**
     * @param string|null $descriptioninfos
     */
    public function setDescriptioninfos(string $descriptioninfos)
    {
        $this->descriptioninfos = $descriptioninfos;
    }

    /**
     * @return int|null
     */
    public function getEtatsortie(): int
    {
        return $this->etatsortie;
    }

    /**
     * @param int|null $etatsortie
     */
    public function setEtatsortie(int $etatsortie)
    {
        $this->etatsortie = $etatsortie;
    }

    /**
     * @return string|null
     */
    public function getUrlphoto(): string
    {
        return $this->urlphoto;
    }

    /**
     * @param string|null $urlphoto
     */
    public function setUrlphoto(string $urlphoto)
    {
        $this->urlphoto = $urlphoto;
    }

    /**
     * @return int
     */
    public function getOrganisateur(): int
    {
        return $this->organisateur;
    }

    /**
     * @param int $organisateur
     */
    public function setOrganisateur(int $organisateur)
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return int
     */
    public function getLieuxNoLieu(): int
    {
        return $this->lieuxNoLieu;
    }

    /**
     * @param int $lieuxNoLieu
     */
    public function setLieuxNoLieu(int $lieuxNoLieu)
    {
        $this->lieuxNoLieu = $lieuxNoLieu;
    }

    /**
     * @return int
     */
    public function getEtatsNoEtat(): int
    {
        return $this->etatsNoEtat;
    }

    /**
     * @param int $etatsNoEtat
     */
    public function setEtatsNoEtat(int $etatsNoEtat)
    {
        $this->etatsNoEtat = $etatsNoEtat;
    }
}
