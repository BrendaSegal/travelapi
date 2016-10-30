<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;

class PassengerController extends FOSRestController
{
   /**
     * Displays Passenger $passengerId
     * [GET] /passengers/{passengerId}
     * 
     * @param int $passengerId
     * 
     * @return array representation of Passenger with $passengerId
     */
    public function getPassengersAction($passengerId)
    {
        $passengerManager = $this->get('bsegal_travel_api.passenger_manager');
        
        try {
            $passenger = $passengerManager->getPassengerById($passengerId);
            $view = new View($passenger);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Creates a new Passenger with the provided POST data
     * [POST] /passengers
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function postPassengersAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $passengerManager = $this->get('bsegal_travel_api.passenger_manager');

        $passenger = $passengerManager->createNewPassenger(
            $data['firstName'],
            $data['lastName'],
            $data['citizenshipCountry'],
            $data['passportNumber'],
            $data['passportExpiry'],
            $data['phone'],
            $data['email'],
            $data['dateOfBirth']
        );

        $view = new View($passenger);
        
        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Lists all Trips for Passenger with id $passengerId
     * [GET] passengers/{passengerId}/trips 
     * 
     * @param int $passengerId
     * 
     * @return array of the Passenger's Trips
     */
    public function getPassengerTripsAction($passengerId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $trips = $tripManager->getAllTripsByPassengerId($passengerId);
            $view = new View($trips);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Lists all Flights for Passenger with id $passengerId
     * [GET] passengers/{passengerId}/flights 
     * 
     * @param int $passengerId
     * 
     * @return array of the Passenger's Flights
     */
    public function getPassengerFlightsAction($passengerId)
    {
        $tripManager = $this->get('bsegal_travel_api.trip_manager');
        
        try {
            $flights = $tripManager->getAllFlightsForAllTripsByPassengerId($passengerId);            
            $view = new View($flights);
        } catch (\Exception $e) {
            $view = new View(['Exception' => $e->getMessage()]);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    
    /**
     * Displays all Flights for Trip $tripId for Passenger with id $passengerId
     * [GET] passengers/{passengerId}/trips/{tripId}/flights
     * 
     * @param int $passengerId
     * @param int $tripId
     * 
     * @return array of Passenger's  Flights for Trip with $tripId
     */
    public function getPassengerTripFlightsAction($passengerId, $tripId)
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
}
