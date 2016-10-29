<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Airport;
use Bsegal\TravelApiBundle\Manager\CountryManager;
use Bsegal\TravelApiBundle\Manager\RegionManager;

class AirportManager
{
    private $entityManager;
    private $countryManager;
    private $regionManager;

    public function __construct(
        EntityManager $entityManager, 
        CountryManager $countryManager,
        RegionManager $regionManager
    ) {
        $this->entityManager = $entityManager;
        $this->countryManager = $countryManager;
        $this->regionManager = $regionManager;
    }

    /**
     * Creates an Airport entity with the specified parameters, provided
     *     one with the same code $code does not exist.
     * 
     * @param  string $code the airport code
     * @param  string $name the airport name
     * @param  float $latitudeDegree
     * @param  float $longitudeDegree
     * @param  string $countryCode code of the country in which the airport is located
     * @param  string $regionCode code of the region in which the airport is located
     * @param  string $municipality
     *
     * @throws  \Exception if country with $countryCode does not exist, because no association with 
     *          Country could be created 
     * @throws  \Exception if region with $regionCode does not exist, because no association with 
     *          Region could be created  
     * @throws \Exception if Airport entity with code $code already exists
     * 
     * @return Airport the resulting airport entity
     */
    public function createNewAirport(
        $code, 
        $name,
        $latitudeDegree,
        $longitudeDegree,
        $countryCode,
        $regionCode,
        $municipality
    ) {
        $em = $this->entityManager;
        $countryManager = $this->countryManager;
        $regionManager = $this->regionManager;

        if ($this->airportExists($code)) {
            throw new \Exception('Airport with code '.$code.' already exists');
        }

        $country = $countryManager->findCountry($countryCode);
        $region = $regionManager->findRegion($regionCode);

        //country and/or region doesn't exist, can't create airport
        if (is_null($country)) {
            throw new \Exception('Country with code '.$countryCode.' does not exist; Cannot create airport with code.'.$code);
        } 

        if (is_null($region)) {
            throw new \Exception('Region with code '.$regionCode.' does not exist; Cannot create airport with code.'.$code);
        }

        $airport = new Airport();
        $airport->setCode($code);
        $airport->setName($name);
        $airport->setLatitudeDegree($latitudeDegree);
        $airport->setLongitudeDegree($longitudeDegree);
        $airport->setCountry($country);
        $airport->setRegion($region);
        $airport->setMunicipality($municipality);

        $em->persist($airport);
        $em->flush();

        return $airport;
    }

    /**
     * Retrieves the Airport entity defined by code $airportCode or
     *     null otherwise.
     * 
     * @param  string $airportCode the desired airport code
     * 
     * @return mixed Airport|null returns Airport if it exists, null otherwise
     */
    public function findAirport($airportCode)
    {
        $em = $this->entityManager;

        $airports = $em->getRepository('BsegalTravelApiBundle:Airport')
            ->findBy(array('code' => $airportCode));

        if (empty($airports)) {
            return null;
        }

        return $airports[0];
    }

    /**
     * Verifies if a specific Airport entity exists.
     * 
     * @param  string $airportCode code representing the airport
     * 
     * @return boolean true if airport exists, false otherwise
     */
    public function airportExists($airportCode)
    {
        return !is_null($this->findAirport($airportCode));
    }

    /**
     * Retrieves list of Airport entities in alphabetical order.
     * 
     * @return array all airport entities
     */
    public function retrieveAllAirports()
    {
        $airports = $this->entityManager->getRepository('BsegalTravelApiBundle:Airport')
            ->findBy(array(), array('code' => 'ASC'));
            
        return $airports;
    }

    /**
     * Retrieve all airports by country name.
     * 
     * @param  string $name the country name
     * 
     * @return array airport entities within the specified country
     */
    public function retrieveAllAirportsByCountryName($name)
    {
        $country = $this->countryManager->getCountryByName($name);

        if (is_null($country)) {
            return [];
        }

        return $this->retrieveAllAirportsByCountry($country);
    }

     /**
     * Retrieve all airports by country code (eg: US).
     * 
     * @param  string $code the code representing the country
     * 
     * @return array airport entities within the specified country code
     */
    public function retrieveAllAirportsByCountryCode($code)
    {
        $country = $this->countryManager->findCountry($code);

        if (is_null($country)) {
            return [];
        }

        return $this->retrieveAllAirportsByCountry($country);
    }

    /**
     * Retrieve all airports by Country entity.
     * 
     * @param  \Bsegal\TravelApiBundle\Entity\Country $country the Country entity
     * 
     * @return array airport entities within the specified country
     */
    private function retrieveAllAirportsByCountry(\Bsegal\TravelApiBundle\Entity\Country $country)
    {
        $airports = $this->entityManager->getRepository('BsegalTravelApiBundle:Airport')
            ->findBy(['country' => $country]);

        return $airports;
    }
}
