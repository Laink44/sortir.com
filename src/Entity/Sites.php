<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sites
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity
 */
class Sites
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_site", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $noSite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_site", type="string", length=30, nullable=false)
     */
    private $nomSite;

    /**
     * @return int
     */
    public function getNoSite(): int
    {
        return $this->noSite;
    }

    /**
     * @param int $noSite
     */
    public function setNoSite(int $noSite)
    {
        $this->noSite = $noSite;
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
}
