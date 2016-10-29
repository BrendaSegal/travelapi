<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

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

        $passenger = $tripManager->createNewTrip(
            $data['passengerId'],
            $data['isRoundtrip']
        );

        return new Response('Created passenger with id '.$passenger->getId());
    }
    
    /**
     * Adds Outbound Flight to Trip
     * [LINK] /trips/{tripId}/outboundflights/{flightId}
     * 
     * @param int $tripId
     * @param int $flightId
     * 
     * @return  array of Trip with new added Flight
     * 
     */
    public function linkTripOutboundflightAction($tripId, $flightId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->addFlightToTrip($tripId, $flightId, true);
        } catch (\Exception $e) {
            $view = new View(['Exception' =>$e->getMessage()]);
        }

        $view = new View($trip);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Adds Return Flight to Trip
     * [LINK] /trips/{tripId}/returnflights/{flightId}
     * @param int $tripId
     * @param int $flightId
     * 
     * @return  array of Trip with new added Flight
     * 
     */
    public function linkTripReturnflightAction($tripId, $flightId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trip = $tripManager->addFlightToTrip($tripId, $flightId, false);
        } catch (\Exception $e) {
            $view = new View(['Exception' =>$e->getMessage()]);
        }

        $view = new View($trip);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

   /**
    * Removes Outbound Flight from Trip
    * [GET] /trips/{tripId}/outboundflights/{flightId}
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
            $trip = $tripManager->removeFlightFromTrip($trip, $flight, true);
        } catch (\Exception $e) {
            $view = new View(['Exception' =>$e->getMessage()]);
        }
        
        $view = new View($trip);

        return $this->get('fos_rest.view_handler')->handle($view);
   }

   /**
    * Removes Return Flight from Trip
    * [GET] /trips/{tripId}/returnflights/{flightId}
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
            $trip = $tripManager->removeFlightFromTrip($trip, $flight, false);
        } catch (\Exception $e) {
            $view = new View(['Exception' =>$e->getMessage()]);
        }
        
        $view = new View($trip);

        return $this->get('fos_rest.view_handler')->handle($view);
   }
}
