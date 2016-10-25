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

    /**
     * Creates a new Region with the given parameters, unless one with code $code
     *     already exists.
     * 
     * @param  string $code the region code
     * @param  string $name the region name
     * @param  string $countryCode the region's country code
     * 
     * @throws  \Exception if country with $countryCode does not exist, since no association
     *          to Country could be made
     * @throws  \Exception if region with region code $code already exists
     * 
     * @return REgion the resulting created entity
     */
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
            throw new \Exception('Country with code '.$countryCode.' does not exist.');
        }

        $region = new Region();
        $region->setCode($code);
        $region->setName($name);
        $region->setCountry($country);
        $em->persist($region);
        $em->flush();

        return $region;
    }

    /**
     * Locates the region with code $regionCode.
     * 
     * @param  string $regionCode region's code
     * 
     * @return mixed Region|null the Region if lcoated, null otherwise
     */
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

    /**
     * Verifies if region with code $regionCode exists.
     * 
     * @param  string $regionCode
     * 
     * @return boolean true if region exists, false otherwise
     */
    public function regionExists($regionCode)
    {
        return !is_null($this->findRegion($regionCode));
    }
}
