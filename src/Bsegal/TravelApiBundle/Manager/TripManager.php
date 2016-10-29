<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Trip;
use Bsegal\TravelApiBundle\Entity\Flight;
use Bsegal\TravelApiBundle\Entity\Airport;
use Bsegal\TravelApiBundle\Entity\Passenger;

class TripManager
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager,
        PassengerManager $passengerManager,
        FlightManager $flightManager
    ) {
        $this->entityManager = $entityManager;
        $this->passengerManager = $passengerManager;
        $this->flightManager = $flightManager;
    }

    /**
     * Create new Trip for Passenger defined by $passengerId
     * 
     * @param  integer $passengerId the id of the passenger going on the trip
     * @param  boolean $isRoundtrip
     *
     * @throws \Exception when passengerId does not refer to an existing Passenger
     * 
     * @return Trip the newly created Trip entity
     */
    public function createNewTrip(
        $passengerId,
        $isRoundtrip = true
    ) {
        $em = $this->entityManager;

        $passenger = $this->passengerManager
            ->getPassengerById($passengerId);

        if (empty($passenger)) {
            throw new \Exception("Passenger with id ".$passengerId." does not exist.");
        }

        $trip = new Trip();

        $trip->setIsRoundtrip($isRoundtrip);
        $trip->setPassenger($passenger);
        $trip->setUpdatedAt(new \DateTime('now'));
        $trip->setCreatedAt(new \DateTime('now'));

        $em->persist($trip);
        $em->flush();

        return $trip;
    }
    
    /**
     * 
     */
    /**
     * Retrieve all trips for a specified Passenger with id $passengerId
     * 
     * @param int $passengerId the passenger's id
     * 
     * @throws \Exception when no Passenger with the specified id exists
     * 
     * @return array of Trip entities
     */
    public function getAllTripsByPassengerId($passengerId)
    {
        $em = $this->entityManager;

        $passenger = $em->getRepository('BsegalTravelApiBundle:Passenger')
            ->find($passengerId);

        if (empty($passenger)) {
            throw new \Exception('Passenger with id '.$passengerId.' does not exist.');
        }

        $trips = $em->getRepository('BsegalTravelApiBundle:Trip')
            ->findBy(array(
                'passenger' => $passenger
            ));

        return $trips;
    }

    /**
     * Add a Flight to a specified Trip
     * 
     * @param int $tripId
     * @param int $flightId the flight to add to the trip
     * @param boolean $outbound true if this is an outbound flight, false otherwise
     *
     * @throws \Exception when Trip does not exist
     * @throws \Exception when Flight does not exist
     * 
     * @return  Trip
     */
    public function addFlightToTrip(
        $tripId,
        $flightId,
        $outbound = true
    ) {
        $em = $this->entityManager;

        $trip = $em->getRepository('BsegalTravelApiBundle:Trip')
            ->find($tripId);

        if (empty($trip)) {
            throw new \Exception('Trip with id '.$tripId.' does not exist.');
        }

        $flight = $this->flightManager->getFlightById($flightId);

        if (empty(flight)) {
            throw new \Exception('Flight with id '.$flightId.' does not exist.');
        }

        $trip->setUpdatedAt(new \DateTime('now'));

        if ($wayThere) {
            $trip->addOutboundFlight($flight);
        } else {
            $trip->addReturnFlight($flight);
        }

        $em->flush();

        return $trip;
    }

    /**
     * Removes a Flight from a specified Trip
     * 
     * @param int $tripId
     * @param int $flightId the flight to add to the trip
     * @param boolean $outbound true if this is an outbound flight, false otherwise
     *
     * @throws \Exception when Trip does not exist
     * @throws \Exception when Flight does not exist
     * 
     * @return  Trip
     */
    public function removeFlightFromTrip(
        $tripId,
        $flightId,
        $outbound = true
    ) {
        $em = $this->entityManager;

        $trip = $em->getRepository('BsegalTravelApiBundle:Trip')
            ->find($tripId);

        if (empty($trip)) {
            throw new \Exception('Trip with id '.$tripId.' does not exist.');
        }

        $flight = $this->flightManager->getFlightById($flightId);

        if (empty(flight)) {
            throw new \Exception('Flight with id '.$flightId.' does not exist.');
        }

        $trip->setUpdatedAt(new \DateTime('now'));

        if ($wayThere) {
            $trip->removeOutboundFlight($flight);
        } else {
            $trip->removeReturnFlight($flight);
        }

        $em->flush();

        return $trip;
    }

    /**
     * Retrieves an existing Trip entity
     * 
     * @param  int $tripId the desired Trip id
     * 
     * @return Trip
     */
    public function getTripById($tripId)
    {
        return $this->entityManager->getRepository('BsegalTravelApiBundle:Trip')
            ->find($tripId);
    }
    
    /**
     * Retrieve all Flights for all Trips for a specified Passenger with id $passengerId
     * 
     * @param int $passengerId the passenger's id
     * 
     * @throws \Exception when no Passenger with the specified id exists
     * 
     * @return array containing all Flights, such that array['outbound'] is all 
     * Outbound Flights and array['return'] is all Return Fligths
     */
    public function getAllFlightsForAllTripsByPassengerId($passengerId)
    {
        $flights = [
            'outbound' => [],
            'return' => [],
        ];
        
        $trips = $this->retrieveAllTripsByPassengerId($passengerId);
        
        foreach ($trips as $trip) {
            array_push($flights['outbound'], $trip->getOutboundFlights());
            array_push($flights['return'], $trip->getReturnFlights());
        }   
        
        return $flights;
    }
}
