<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;

class TripController extends FOSRestController
{   
    /**
     * Displays Trip $tripId
     * [GET] /trips/{tripId}
     * 
     * @param int $tripId
     * 
     * @return array representation of Trip with $tripId
     */
    public function getTripsAction($tripId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->getTripById($tripId);
            $view = new View($trip);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Displays Flights for the trip with $tripId
     * [GET] /trips/{tripId}/flights
     * 
     * @param int $tripId
     * 
     * @return array representation of Trip with $tripId
     */
    public function getTripsFlightsAction($tripId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->getTripById($tripId);
            $view = new View([
               'outbound' => $trip->getOutboundFlights(),
               'return' => $trip->getReturnFlights(),
            ]);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Creates a new Trip with the provided POST data
     * [POST] /trips
     * 
     * @param void
     * 
     * @return Response
     */
    public function postTripsAction()
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        
        $data = json_decode($request->getContent(), true);
        $tripManager = $this->get('bsegal_travel_api.trip_manager');

        $trip = $tripManager->createNewEmptyTrip(
            $data['passengerId'],
            $data['isRoundtrip']
        );

        $view = new View($trip);
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Adds Outbound Flight to Trip
     * [PUT] /trips/{tripId}/outboundflights/{flightId}
     * 
     * @param int $tripId
     * @param int $flightId
     * 
     * @return  array of Trip with new added Flight
     * 
     */
    public function putTripOutboundflightAction($tripId, $flightId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->addFlightToTrip($tripId, $flightId, true);
            $view = new View($trip);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Adds Return Flight to Trip
     * [PUT] /trips/{tripId}/returnflights/{flightId}
     * @param int $tripId
     * @param int $flightId
     * 
     * @return  array of Trip with new added Flight
     * 
     */
    public function putTripReturnflightAction($tripId, $flightId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->addFlightToTrip($tripId, $flightId, false);
            $view = new View($trip);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }

   /**
    * Removes Outbound Flight from Trip
    * [GET] /trips/{tripId}/outboundflights/{flightId}/remove
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array of Trip with flight removed
    */
   public function removeTripOutboundflightAction($tripId, $flightId)
   {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');

        try {
            $trip = $tripManager->removeFlightFromTrip($tripId, $flightId, true);            
            $view = new View($trip);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }
        
        return $this->get('fos_rest.view_handler')->handle($view);
   }

   /**
    * Removes Return Flight from Trip
    * [GET] /trips/{tripId}/returnflights/{flightId}/remove
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array of Trip with flight removed
    */
   public function removeTripReturnflightAction($tripId, $flightId)
   {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');

        try {
            $trip = $tripManager->removeFlightFromTrip($tripId, $flightId, false);
            $view = new View($trip);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }
        
        return $this->get('fos_rest.view_handler')->handle($view);
   }
}
