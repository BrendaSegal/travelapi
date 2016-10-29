<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Flight as Flight;
use Bsegal\TravelApiBundle\Entity\Airport;
use Bsegal\TravelApiBundle\Entity\Country;
use Doctrine\ORM\Query\ResultSetMapping;

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
     * @param  \DateTime $departureTime time at which Flight leaves $departureAirport
     * @param  \DateTime $arrivalTime time at which Flight arrives at $arrivalTime
     * @param  integer $numberOfTicketsAvailable
     * 
     * @return  Flight the resulting created flight
     */
    public function createNewFlight(
        Airport $departureAirport,
        Airport $arrivalAirport,
        \DateTime $departureTime,
        \DateTime $arrivalTime,
        $numberOfTicketsAvailable
    ) {
        $em = $this->entityManager;

        $flight = new Flight();
        $flight->setDepartureAirport($departureAirport);
        $flight->setArrivalAirport($arrivalAirport);
        $flight->setDepartureTime($departureTime);
        $flight->setArrivalTime($arrivalTime);
        $flight->setTicketsAvailable($numberOfTicketsAvailable);

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

    /**
     * Retrieves all flights
     */
    public function retrieveAllFlights()
    {
        return $this->entityManager->getRepository('BsegalTravelApiBundle:Flight')
            ->findAll();
    }
    
    /**
     * Retrieves all flights that have either (or both) the ArrivalAirport
     * or the DepartureAirport in the country specified by $countryName
     * 
     * @param string $countryName
     * 
     * @return array containing matching Flight entities
     */
    public function retrieveAllFlightsByCountryName($countryName)
    {
        $em = $this->entityManager;
        
        $query = $em->createQuery(
            "SELECT f
            FROM BsegalTravelApiBundle:Flight f
            JOIN BsegalTravelApiBundle:Airport a 
            WITH (f.departureAirport = a.id OR f.arrivalAirport = a.id)
            JOIN BsegalTravelApiBundle:Country c 
            WITH a.country = c.id
            WHERE c.name LIKE :countryName"
        )->setParameter('countryName', $countryName);

        return $query->getResult();
    }
    
    /**
     * Retrieves all flights that have either (or both) the ArrivalAirport
     * or the DepartureAirport in the country specified by $countryCode
     * 
     * @param string $countryCode the corresponding country code
     * 
     * @return array containing matching Flight entities
     */
    public function retrieveAllFlightsByCountryCode($countryCode)
    {
        $em = $this->entityManager;
        
        $query = $em->createQuery(
            "SELECT f
            FROM BsegalTravelApiBundle:Flight f
            JOIN BsegalTravelApiBundle:Airport a 
            WITH (f.departureAirport = a.id OR f.arrivalAirport = a.id)
            JOIN BsegalTravelApiBundle:Country c 
            WITH a.country = c.id
            WHERE c.code LIKE :countryCode"
        )->setParameter('countryCode', $countryCode);

        return $query->getResult();
    }
    
    /**
     * Retrieves all flights that have either (or both) the ArrivalAirport
     * or the DepartureAirport in the Region specified by $region
     * 
     * @param string $region the corresponding Region's name
     * 
     * @return array containing matching Flight entities
     */
    public function retrieveAllFlightsByRegion($region)
    {
        $em = $this->entityManager;
        
        $query = $em->createQuery(
            "SELECT f
            FROM BsegalTravelApiBundle:Flight f
            JOIN BsegalTravelApiBundle:Airport a 
            WITH (f.departureAirport = a.id OR f.arrivalAirport = a.id)
            JOIN BsegalTravelApiBundle:Region r 
            WITH a.region = r
            WHERE r.name LIKE :region"
        )->setParameter('region', $region);

        return $query->getResult();
    }
    
    /**
     * Retrieves all flights that have either (or both) the ArrivalAirport
     * or the DepartureAirport in the municipality specified by $municipality
     * 
     * @param string $muncipality
     * 
     * @return array containing matching Flight entities
     */
    public function retrieveAllFlightsByMunicipality($municipality)
    {
        $em = $this->entityManager;
        
        $query = $em->createQuery(
            "SELECT f
            FROM BsegalTravelApiBundle:Flight f
            JOIN BsegalTravelApiBundle:Airport a 
            WITH (f.departureAirport = a.id OR f.arrivalAirport = a.id)
            WHERE a.municipality LIKE :municipality"
        )->setParameter('municipality', $municipality);

        return $query->getResult();
    }
        
    /**
     * Retrieves all flights that have the ArrivalAirport
     * in the country specified by $countryName
     * 
     * @param string $countryName
     * 
     * @return array containing matching Flight entities
     */
    public function retrieveAllArrivalFlightsByCountryName($countryName)
    {
        $em = $this->entityManager;

        $query = $em->createQuery(
            "SELECT f
            FROM BsegalTravelApiBundle:Flight f
            JOIN BsegalTravelApiBundle:Airport a 
            WITH f.arrivalAirport = a.id
            JOIN BsegalTravelApiBundle:Country c 
            WITH a.country = c.id
            WHERE c.name LIKE :countryName"
        )->setParameter('countryName', $countryName);

        return $query->getResult();
    }
}
