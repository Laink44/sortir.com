<?php


namespace App\Service;


class PaginatorService
{
    /**
     * @param int $currentPage
     * @param int $maxByPage
     * @param int $rowCount
     * @return array
     */
    public function getViewParams( int $currentPage, int $maxByPage, int  $rowCount, int $numberOfRange ) : array
    {
        $numberOfPages = $this -> getPagesCount( $maxByPage, $rowCount );
        $pagesRange = $this -> getPagesRange( $currentPage, $numberOfPages, $numberOfRange );
        $previous = $this -> getPrevious( $currentPage );
        $next = $this -> getNext( $currentPage, $numberOfPages );
        return array(
            'numberOfPages' => $numberOfPages,
            'currentPage'   => $currentPage,
            'pagesRange'    => $pagesRange,
            'previousPage'  => $previous,
            'nextPage'      => $next,
        );
    }

    /**
     * @param int $currentPage
     * @param int $maxByPage
     * @return float|int
     */
    public function getOffset( int $currentPage, int $maxByPage )
    {
        $offset = 0;

        if ( $currentPage != 1 ) {
            $offset = ( $currentPage - 1 ) * $maxByPage;
        }

        return $offset;
    }

    /**
     * @param int $currentPage
     * @param int $numberOfPages
     * @return array
     */
    public function getPagesRange( int $currentPage, int $numberOfPages, int $numberOfRange ) : array
    {
        $pagesRange = [];

        if( $numberOfRange > $numberOfPages ) {
            $numberOfRange = $numberOfPages;
        }

        $numberOfPlacesBefore   = $this -> getNumberOfPlacesBefore( 1, $currentPage );
        $start                  = $this -> getStart( $numberOfPlacesBefore, $currentPage );
        $end                    = $this -> getEnd( $start, $numberOfRange );
        for( $i = $start; $i < $end; ++$i ) {
            array_push( $pagesRange, $i );
        }
        return $pagesRange;
    }

    /**
     * @param int $currentPage
     * @return int
     */
    public function getStart( int $numberOfPlacesBefore, int $currentPage ) : int
    {
       $start = 1;

        switch ( $numberOfPlacesBefore ) {
            case 0 :
                $start = $currentPage;
                break;
            case 1 :
                $start = $currentPage - 1;
                break;
            default :
                $start = $currentPage - 2;
                break;
        }

        return $start;
    }

    /**
     * @param int $currentPage
     * @param int $numberOfPages
     * @return int
     */
    public function getEnd( int $start, int $numberOfPagesToShow ) : int
    {
        return $start + $numberOfPagesToShow;
    }

    /**
     * @param int $currentPage
     * @param int $numberOfPages
     * @return int
     */
    public function getPrevious( int $currentPage ) : int
    {
        return max( 1 , $currentPage - 1 );
    }

    /**
     * @param int $currentPage
     * @return int
     */
    public function getNext( int $currentPage,  int $numberOfPages ) : int
    {
        dump( $currentPage );
        return min( $numberOfPages , $currentPage + 1 );
    }

    /**
     * @param int $maxByPage
     * @param int $rowCount
     * @return int
     */
    public function getPagesCount( int $maxByPage, int $rowCount ) : int
    {
        $numberOfPages = 1;

        if ( $rowCount > $maxByPage )  {
            $mod = $rowCount % $maxByPage;
            $numberOfPages = intval( $rowCount / $maxByPage );

            if ( $mod != 0 ) {
                $numberOfPages = $numberOfPages + 1;
            }
        }

        return $numberOfPages;
    }

    /**
     * @param $firstPage
     * @param $currentPage
     * @return mixed
     */
    public function getNumberOfPlacesBefore( $firstPage, $currentPage ) {
        return $currentPage - $firstPage;
    }

    /**
     * @param $lastPage
     * @param $currentPage
     * @return mixed
     */
    public function getNumberOfPlacesAfter( $lastPage, $currentPage ) {
        return $lastPage - $currentPage;
    }
}