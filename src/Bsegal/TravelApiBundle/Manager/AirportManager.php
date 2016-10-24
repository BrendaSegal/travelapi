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
            return null;
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

    public function airportExists($airportCode)
    {
        return !is_null($this->findAirport($airportCode));
    }
}