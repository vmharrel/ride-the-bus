<?php

namespace RidePal\RoutesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stops
 */
class Stops
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $routeId;

    /**
     * @var string
     */
    private $stopLocation;

    /**
     * @var string
     */
    private $stopDescription;

    /**
     * @var integer
     */
    private $stopTime;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set routeId
     *
     * @param integer $routeId
     * @return Stops
     */
    public function setRouteId($routeId)
    {
        $this->routeId = $routeId;

        return $this;
    }

    /**
     * Get routeId
     *
     * @return integer 
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * Set stopLocation
     *
     * @param string $stopLocation
     * @return Stops
     */
    public function setStopLocation($stopLocation)
    {
        $this->stopLocation = $stopLocation;

        return $this;
    }

    /**
     * Get stopLocation
     *
     * @return string 
     */
    public function getStopLocation()
    {
        return $this->stopLocation;
    }

    /**
     * Set stopDescription
     *
     * @param string $stopDescription
     * @return Stops
     */
    public function setStopDescription($stopDescription)
    {
        $this->stopDescription = $stopDescription;

        return $this;
    }

    /**
     * Get stopDescription
     *
     * @return string 
     */
    public function getStopDescription()
    {
        return $this->stopDescription;
    }

    /**
     * Set stopTime
     *
     * @param integer $stopTime
     * @return Stops
     */
    public function setStopTime($stopTime)
    {
        $this->stopTime = $stopTime;

        return $this;
    }

    /**
     * Get stopTime
     *
     * @return integer 
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }

    /**
     * Find route by name
     *
     * @return route 
     */
    public function findStops($routeId)
    {

        // Confirm necessary params     
        if ( (!isset($routeId)) ) {
            throw new Exception('Route ID not available.');
        }

        $repository = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Stops');
        $stopsByRoute = $repository->createQueryBuilder('stops')
            ->where('stops.routeId = :route_id')
            ->setParameter('route_id', $routeId)
            ->orderBy('stops.stopTime', 'ASC')
            ->getQuery();

        foreach ($stopsByRoute as $stops) {
            $stopsByRoute['stopTime'] = strtotime('today midnight') + $stops['stopTime'];
        }

        return $stopsByRoute;
    }

    /**
     * @Function updating a specified stop property
     */
    public function updateStops($routeId, $element, $value, $stops)
    {

        // Confirm necessary params     
        if ( (!isset($routeId)) || (!isset($element)) || (!isset($value)) || (!isset($stops)) ) {
            throw new Exception('Necessary parameters not set to update Stops.');
        }

        // Set stop repository
            $stopRepository = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Stops');
            $udpateStopsByRoute = $stopRepository->createQueryBuilder('s')
                    ->update()
                    ->set('s.'.$element,$value)
                    ->where('r.routeId = '.$routeId);
    }


}
