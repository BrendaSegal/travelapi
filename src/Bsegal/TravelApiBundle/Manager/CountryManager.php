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

    /**
     * Creates a new Country entity, provided one doesn't already exist with the same
     *     code $code.
     * 
     * @param  string $code the country code
     * @param  string $name the country name
     * @param  string $continent 2-letter representation of continent
     *
     * @throws  \Exception if country with code $code already exists
     * 
     * @return Country entity
     */
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

    /**
     * Returns Country entity with code defined by $countryCode.
     * 
     * @param  string $countryCode the desired country code
     * 
     * @return mixed Country|null country entity if found, null otherwise
     */
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

    /**
     * Verifies if a specific Country entity exists based on the provided 
     *     countryCode $countryCode.
     * 
     * @param  string $countryCode the country's code
     * 
     * @return boolean true if country exists, false otherwise
     */
    public function countryExists($countryCode)
    {
        return !is_null($this->findCountry($countryCode));
    }

    /**
     * Returns the Country entity having the name $name.
     * 
     * @param  string $name the country's name
     * 
     * @return mixed Country|null returns Country entity if found, null otherwise
     */
    public function getCountryByName($name)
    {
        $em = $this->entityManager;

        $countries = $em->getRepository('BsegalTravelApiBundle:Country')
            ->findBy(array('name' => $name));

        if (empty($countries)) {
            return null;
        }

        return $countries[0];
    }
}