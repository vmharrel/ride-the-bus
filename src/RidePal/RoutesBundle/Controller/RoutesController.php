<?php

namespace RidePal\RoutesBundle\Controller;

use RidePal\RoutesBundle\Entity\Routes;
use RidePal\RoutesBundle\Entity\Stops;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RoutesController extends Controller
{

    /**
     * @Rest\View for retreiving all routes
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="This endpoint will retrieve all routes and related stops",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  }
     * )
     */
    public function allAction()
    {
    	// Response array
    	$getAllRoutesAndStops = array();

    	// Return all routes
		$getRoutes = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Routes')->findAll();
		$getAllRoutes = $getRoutes->getResult();

		// If no routes are found, complain
	    if (!$getAllRoutes) {
	        throw new Exception('No routes found ');
	    }

	    // Set repository
		$repository = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Stops');

		foreach ($getAllRoutes as $allRoutes) {

			// Set route entity
			$getAllRoutesAndStops['route'] = $allRoutes;

			// Retrieve all stops for that route
			$em = $this->getDoctrine()->getManager();
    		$stopsPerRoute = $em->getRepository('RidePalRoutesBundle:Stops')->findStops($allRoutes['id']);

		    // Set stops entity
		    $getAllRoutesAndStops['stops'] = $stopsPerRoute;
		}

	    return new Response(json_encode($getAllRoutesAndStops));
    }

    /**
     * @Rest\View for getting a specific Route
     * 
     * @ApiDoc(
     *  description="Get a route by name",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="Your\Namespace\Class"
     * )
     */
    public function getAction($name)
    {

    	// Check if name is set, complain if not
    		if (!$name) {
	        	throw new Exception('Name has not been set.');
	    	}

    	// Response array
    	$getRouteAndStops = array();
    	
    	// Return all routes
		$getRouteByName = $this->getDoctrine()->getRepository('RidePalRoutesBundle:Routes')->find($name);
		$getRoute = $getRouteByName->getResult();

		// If no routes are found, complain
	    if (!$getRoute) {
	        throw new Exception('No routes found by that name' . $name);
	    }
			
			// Set route entity
			$getRouteAndStops['route'] = $getRoute;

			// Retrieve all stops for that route
			$em = $this->getDoctrine()->getManager();
    		$stopsByRoute = $em->getRepository('RidePalRoutesBundle:Stops')->findStops($getRoute['id']);

		    // Set stops entity
		    $getRouteAndStops['stops'] = $stopsByRoute;

	    return new Response(json_encode($getRouteAndStops));
    }

    /**
     * @Rest\View for adding a new Route
     */
    public function postAction(Request $request)
    {

    	// Check if route name is set, complain if not
    	if (!isset($request['route']['name'])) {
    		throw new Exception('Route name is missing.  Cannot update route.');
    	}

    	// Return new route name, id and stops
    	$routesAndStops = array();
    	$route = new Routes();
    	$stop = new Stops();

    	// Set route id, name and total stops
    	$routeID = $route->setId();
	    $route->setRouteName($request['routeName']);
	    $route->setTotalStops(count($request['stops']));

	    // Loop thru each stop to create list of stop times and set stop parameters
	    foreach ($request['stops'] as $stops) {
	    	$stopTimes[] = $stops['stopTime'];
	    	$stop->setId();
	    	$stop->setRouteId($routeID);
			$stop->setStopLocation($stops['location']);
			$stop->setStopDescription($stops['description']);
			$stop->setStopTime($stops['stopTime']);
	    }

	    // Set first and last stop times for that route
	    $route->setFirstStop(min($stopTimes));
	    $route->setLastStop(max($stopTimes));

	    // Create new Route
		    $routeTable = $this->getDoctrine()->getManager();
		    $routeTable->persist($route);
		    $routeTable->flush();
		
		// Create new Route
		    $stopTable = $this->getDoctrine()->getManager();
		    $stopTable->persist($stop);
		    $stopTable->flush();

	    return new Response(json_encode($request));
    }

    /**
     * @Rest\View for updating a Route
     */
    public function putAction(Request $request)
    {
    	// Confirm necessary PUT params		
    	if (!isset($request['route']['name'])) {
    		throw new Exception('Route name is missing.  Cannot update route.');
    	}

		$em = $this->getDoctrine()->getManager();

    	// Update all route elements that are set
    	foreach ($request['route'] as $key => $value) {
    		$em->getRepository('RidePalRoutesBundle:Routes')->updateRoute($request['route']['name'], $key, $value);
    	}

    	// Update all route elements that are set
    	foreach ($request['stops'] as $key => $value) {
    		$em->getRepository('RidePalRoutesBundle:Stops')->updateStops($routeIdToUpdate, $key, $value, $request['stops']['id']);
    	}

    }

    /**
     * @Rest\View for deleting a Route
     */
    public function deleteAction($name)
    {

    	// Check if name is set, complain if not
    		if (!$name) {
	        	throw new Exception('Name has not been set.');
	    	}

	    // Find Route by name
        	$em = $this->getDoctrine()->getManager();
        	$routeByName = $em->getRepository('RidePalRoutesBundle:Routes')->find($name);
	    	$em->getRepository('RidePalRoutesBundle:Routes')->delete($name, $routeByName['id']);

	    return "Deleted $name route and stops";

    }

}
