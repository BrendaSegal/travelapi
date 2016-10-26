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
    * @Get("/trips/create/{passengerId}/{roundTrip}", name="create_trip_for_passenger", 
    * options={ "method_prefix" = false })
    *
    * Creates a new trip for a Passenger.
    * 
    * @param int $passengerId
    * @param boolean $roundTrip
    * 
    * @return  array data
    */
    public function createTrip($passengerId, $roundTrip)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');

        try {
            $trips = $tripManager->createNewTrip($passengerId, $roundTrip);
            $view = new View($trips);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/trips/passenger/{passengerId}", name="get_trips_by_passenger_id", 
    * options={ "method_prefix" = false })
    *
    * List all trips for a Passenger.
    * 
    * @param int $passengerId
    * 
    * @return  array data
    */
    public function getTripsByPassengerIdAction($passengerId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trips = $tripManager->retrieveAllTripsByPassengerId($passengerId);
            $view = new View($trips);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/trips/add/outbound/flight/{tripId}/{flightId}", name="add_outbound_flight_to_trip", 
    * options={ "method_prefix" = false })
    *
    * Adds Outbound Flight to Trip
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array data
    */
    public function addOutboundFlightToTrip($tripId, $flightId)
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
    * @Get("/trips/add/return/flight/{tripId}/{flightId}", name="add_return_flight_to_trip", 
    * options={ "method_prefix" = false })
    *
    * Adds Return Flight to Trip
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array data
    */
    public function addReturnFlightToTrip($tripId, $flightId)
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
    * @Get("/trips/remove/outbound/flight/{tripId}/{flightId}", name="remove_outbound_flight_from_trip", 
    * options={ "method_prefix" = false })
    *
    * Removes Outbound Flight from Trip
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array data
    */
   public function removeOutboundFlightFromTrip($tripId, $flightId)
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
    * @Get("/trips/remove/return/flight/{tripId}/{flightId}", name="remove_return_flight_from_trip", 
    * options={ "method_prefix" = false })
    *
    * Removes Return Flight from Trip
    * 
    * @param int $tripId
    * @param int $flightId
    * 
    * @return  array data
    */
    public function removeReturnFlightFromTrip($tripId, $flightId)
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
