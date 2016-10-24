<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Country;

class CountryManager
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createNewCountry(
        $code, 
        $name,
        $continent
    ) {
        $em = $this->entityManager;

        if ($this->countryExists($code)) {
            throw new \Exception('Country with code '.$code.' already exists.');
        }

        $country = new Country();
        $country->setCode($code);
        $country->setName($name);
        $country->setContinent($continent);
        $em->persist($country);
        $em->flush();

        return $country;
    }

    public function findCountry($countryCode)
    {
        $em = $this->entityManager;

        $countries = $em->getRepository('BsegalTravelApiBundle:Country')
            ->findBy(array('code' => $countryCode));

        if (empty($countries)) {
            return null;
        }

        return $countries[0];
    }

    public function countryExists($countryCode)
    {
        return !is_null($this->findCountry($countryCode));
    }
}