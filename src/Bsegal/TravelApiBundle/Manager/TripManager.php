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
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * Create new Trip for Passenger $passenger
     * 
     * @param  Passenger $passenger the passenger going on the trip
     * @param  boolean $isRoundtrip
     * @return Trip the newly created Trip entity
     */
    public function createNewTrip(
        Passenger $passenger,
        $isRoundtrip = true
    ) {
        $em = $this->entityManager;

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
     * Retrieve all trips for a specified Passenger with id $passengerId
     * 
     * @param int $passengerId the passenger's id
     * 
     * @throws \Exception when no Passenger with the specified id exists
     * 
     * @return array of Trip entities
     */
    public function retrieveAllTripsByPassengerId($passengerId)
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
     * Add Flight to the specified trip
     * 
     * @param Trip $trip
     * @param Flight $flight the flight to add to the trip
     * @param boolean $outbound true if this is an outbound flight, false otherwise
     *
     * @throws \Exception when Trip does not exist
     *
     * @return  Trip
     */
    public function addFlightToTrip(
        Trip $trip,
        Flight $flight,
        $outbound = true
    ) {
        $em = $this->entityManager;

        $trip = $em->getRepository('BsegalTravelApiBundle:Trip')
            ->find($tripId);

        if (empty($trip)) {
            throw new \Exception('Trip with id '.$tripId.' does not exist.');
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
     * Removes Flight from specified trip
     * 
     * @param Trip $trip
     * @param Flight $flight the flight to add to the trip
     * @param boolean $outbound true if this is an outbound flight, false otherwise
     *
     * @throws \Exception when Trip does not exist
     *
     * @return  Trip
     */
    public function removeFlightFromTrip(
        Trip $trip, 
        Flight $flight,
        $outbound = true
    ) {
        $em = $this->entityManager;

        $trip = $em->getRepository('BsegalTravelApiBundle:Trip')
            ->find($tripId);

        if (empty($trip)) {
            throw new \Exception('Trip with id '.$tripId.' does not exist.');
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
}
