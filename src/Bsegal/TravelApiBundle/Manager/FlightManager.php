<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Flight;
use Bsegal\TravelApiBundle\Entity\Airport;

class FlightManager
{
    private $entityManager;
    private $airportManager;

    public function __construct(
        EntityManager $entityManager,
        AirportManager $airportManager
    ) {
        $this->entityManager = $entityManager;
        $this->airportManager = $airportManager;
    }

    /**
     * Creates a new Flight entity given the provided parameters.
     *
     * @param  Airport $arrivalAirport
     * @param  Airport $departureAirport
     * @param  integer $numberOfTicketsAvailable
     * 
     * @return  Flight the resulting created flight
     */
    public function createNewFlight(
        Airport $arrivalAirport,
        Airport $departureAirport,
        $numberOfTicketsAvailable
    ) {
        $em = $this->entityManager;

        $flight = new Flight();        
        $flight->setDepartureAirport($departureAirport);
        $flight->setArrivalAirport($arrivalAirport);
        $flight->setNumberOfTicketsAvailable($numberOfTicketsAvailable);

        $flight->setCreatedAt(new \DateTime('now'));
        $flight->setUpdatedAt(new \DateTime('now'));
        
        $em->persist($flight);
        $em->flush();

        return $flight;
    }

    /**
     * Retrieves an existing Flight entity
     * 
     * @param int $flightId the desired flight id
     * 
     * @return Flight
     */
    public function getFlightById($flightId)
    {
        return $this->entityManager->getRepository('BsegalTravelApiBundle:Flight')
            ->find($flightId);
    }
}
