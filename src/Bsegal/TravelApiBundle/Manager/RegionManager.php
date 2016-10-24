<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Region;
use Bsegal\TravelApiBundle\Manager\CountryManager;

class RegionManager
{
    private $entityManager;
    private $countryManager;

    public function __construct(EntityManager $entityManager, CountryManager $countryManager)
    {
        $this->entityManager = $entityManager;
        $this->countryManager = $countryManager;
    }

    public function createNewRegion(
        $code, 
        $name,
        $countryCode
    ) {
        $em = $this->entityManager;
        $countryManager = $this->countryManager;

        if ($this->regionExists($code)) {
            throw new \Exception('Region with code '.$code.' already exists.');
        }

        $country = $countryManager->findCountry($countryCode);

        //country doesn't exist, can't create region
        if (is_null($country)) {
            return null;
        }

        $region = new Region();
        $region->setCode($code);
        $region->setName($name);
        $region->setCountry($country);
        $em->persist($region);
        $em->flush();

        return $region;
    }

    public function findRegion($regionCode)
    {
        $em = $this->entityManager;

        $regions = $em->getRepository('BsegalTravelApiBundle:Region')
            ->findBy(array('code' => $regionCode));

        if (empty($regions)) {
            return null;
        }

        return $regions[0];
    }

    public function regionExists($regionCode)
    {
        return !is_null($this->findRegion($regionCode));
    }
}