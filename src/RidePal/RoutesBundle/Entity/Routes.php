<?php

namespace RidePal\RoutesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routes
 */
class Routes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $routeName;

    /**
     * @var integer
     */
    private $totalStops;

    /**
     * @var integer
     */
    private $firstStop;

    /**
     * @var integer
     */
    private $lastStop;


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
     * Set routeName
     *
     * @param string $routeName
     * @return Routes
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string 
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set totalStops
     *
     * @param integer $totalStops
     * @return Routes
     */
    public function setTotalStops($totalStops)
    {
        $this->totalStops = $totalStops;

        return $this;
    }

    /**
     * Get totalStops
     *
     * @return integer 
     */
    public function getTotalStops()
    {
        return $this->totalStops;
    }

    /**
     * Set firstStop
     *
     * @param integer $firstStop
     * @return Routes
     */
    public function setFirstStop($firstStop)
    {
        $this->firstStop = $firstStop;

        return $this;
    }

    /**
     * Get firstStop
     *
     * @return integer 
     */
    public function getFirstStop()
    {
        return $this->firstStop;
    }

    /**
     * Set lastStop
     *
     * @param integer $lastStop
     * @return Routes
     */
    public function setLastStop($lastStop)
    {
        $this->lastStop = $lastStop;

        return $this;
    }

    /**
     * Get lastStop
     *
     * @return integer 
     */
    public function getLastStop()
    {
        return $this->lastStop;
    }

    /**
     * Retrieve all routes
     *
     * @return route 
     */
    public function findAll()
    {

        // Get all routes
            $routesRepository = $this->getDoctrine()
                ->getRepository('RidePalRoutesBundle:Routes');
            $routeQuery = $routesRepository->createQuery('SELECT * FROM RidePal\RoutesBundle\Routes');
            $allRoutes = $routeQuery->getResult();

        // Get all stops
            $stopsRepository = $this->getDoctrine()
                ->getRepository('RidePalRoutesBundle:Stops');

        // Loop thru each route to create list of stops
        foreach ($allRoutes as $routeList) {
            $stopsByRoute = $stopsRepository->createQueryBuilder('stops')
                ->where('stops.routeId = :route_id')
                ->setParameter('route_id', $allRoutes['id'])
                ->orderBy('stops.stopTime', 'ASC')
                ->getQuery();
            foreach ($stopsByRoute as $stop) {
                $routeList['stops'][] = $stop;
            }
        }

        return $routeList;
    }

    /**
     * Find route by name
     *
     * @return route 
     */
    public function find($name)
    {

        // Confirm necessary params     
        if ( (!isset($name)) ) {
            throw new Exception('Necessary parameters not set to find Route.');
        }

        $repository = $this->getDoctrine()
            ->getRepository('RidePalRoutesBundle:Routes');

        $query = $repository->createQueryBuilder()
            ->where('name > :name')
            ->setParameter('name', $name)
            ->getQuery();

        $route = $query->getResult();

        return $route;
    }

    /**
     * Find route by name
     *
     * @return route 
     */
    public function delete($name, $routeId)
    {

        // Confirm necessary params     
        if ( (!isset($name)) || (!isset($routeId)) ) {
            throw new Exception('Necessary parameters not set to delete Route.');
        }

        $routeRepository = $this->getDoctrine()
            ->getRepository('RidePalRoutesBundle:Routes');

        $stopRepository = $this->getDoctrine()
            ->getRepository('RidePalRoutesBundle:Stops');

        $deleteRouteQuery = $routeRepository->createQueryBuilder()
            ->delete()
            ->where('name > :name')
            ->setParameter('name', $name)
            ->getQuery();

        $deleteStopsQuery = $stopRepository->createQueryBuilder()
            ->delete()
            ->where('routeId > :id')
            ->setParameter('id', $routeId)
            ->getQuery();

        return;
    }

    /**
     * @Function updating a specified route property
     */
    public function updateRoute($name, $element, $value)
    {

        // Confirm necessary params     
        if ( (!isset($name)) || (!isset($element)) || (!isset($value)) ) {
            throw new Exception('Necessary PUT parameters not set to update Route.');
        }

        $em = $this->getDoctrine()->getManager();
        $routeByName = $em->getRepository('RidePalRoutesBundle:Routes')->find($name);

        if (!$routeByName) {
            throw new Exception('No route found for name '.$name);
        }

        // Set route repository
            $routeRepository = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Routes');

        // Update Route
            $udpateStopsByRoute = $routeRepository->createQueryBuilder('r')
                ->update()
                ->set('r.'.$element,$value)
                ->where('r.name = '.$name);

        return $routeByName['id'];
    }
}
