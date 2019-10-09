<?php


namespace App\Dto;


class RequestFindSeries
{


    private $site ;
   private $dateDebut = null;
   private $dateFin = null;
   private $keyword = null;
   private $ManagerFilter = false;
   private $RegisterFilter = false;
   private $NotRegisterFilter = false;
   private $OutDatedFilter = false;

    /**
     * @return null
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param null $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return null
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param null $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return null
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param null $keyword
     */
    public function setKeyword($keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return null
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param null $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return bool
     */
    public function isNotRegisterFilter(): bool
    {
        return $this->NotRegisterFilter;
    }

    /**
     * @param bool $NotRegisterFilter
     */
    public function setNotRegisterFilter(bool $NotRegisterFilter =null): void
    {
        $this->NotRegisterFilter = $NotRegisterFilter;
    }

    /**
     * @return bool
     */
    public function isOutDatedFilter(): bool
    {
        return $this->OutDatedFilter;
    }

    /**
     * @param bool $OutDatedFilter
     */
    public function setOutDatedFilter(bool $OutDatedFilter  =null): void
    {
        $this->OutDatedFilter = $OutDatedFilter;
    }

    /**
     * @return bool
     */
    public function isRegisterFilter(): bool
    {
        return $this->RegisterFilter;
    }

    /**
     * @param bool $RegisterFilter
     */
    public function setRegisterFilter(bool $RegisterFilter  =null): void
    {
        $this->RegisterFilter = $RegisterFilter;
    }

    /**
     * @return bool
     */
    public function isManagerFilter(): bool
    {
        return $this->ManagerFilter;
    }

    /**
     * @param bool $ManagerFilter
     */
    public function setManagerFilter(bool $ManagerFilter =null): void
    {
        $this->ManagerFilter = $ManagerFilter;
    }

}