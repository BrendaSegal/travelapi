<?php
namespace Bsegal\TravelApiBundle\Manager;

use Doctrine\ORM\EntityManager;
use Bsegal\TravelApiBundle\Entity\Passenger;
use Bsegal\TravelApiBundle\Manager\CountryManager;

class PassengerManager
{
    private $entityManager;
    private $countryManager;

    public function __construct(
        EntityManager $entityManager,
        CountryManager $countryManager
    ) {
        $this->entityManager = $entityManager;
        $this->countryManager = $countryManager;
    }

    /**
     * Creates a new Passenger entity given the provided parameters.
     * 
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $citizenshipCountry name of country
     * @param  string $passportNumber
     * @param  \Datetime $passportExpiry
     * @param  string $phone
     * @param  string $email
     * @param  \Datetime $dateOfBirth
     *
     * @throws  \Exception when country of citizenship does not exist
     * 
     * @return Passenger the new Passenger created
     */
    public function createNewPassenger(
        $firstName,
        $lastName,
        $citizenshipCountry,
        $passportNumber,
        \DateTime $passportExpiry,
        $phone,
        $email,
        $dateOfBirth
    ) {
        $em = $this->entityManager;
        $country = $this->countryManager
            ->getCountryByName($citizenshipCountry);

        if (empty($country)) {
            throw new \Exception('Failed to create Passenger with name '.$firstName.' '.$lastName.'. Country of citizenship does not exist: '.$citizenshipCountry);
        }

        $passenger = new Passenger();
        $passenger->setFirstName($firstName);
        $passenger->setLastName($lastName);
        $passenger->setCitizenshipCountry($country);
        $passenger->setPassportNumber($passportNumber);
        $passenger->setPassportExpiry($passportExpiry);

        if ($phone != "") {
            $passenger->setPhone($phone);
        }

        if ($email != "") {
            $passenger->setEmail($email);
        }
        
        $passenger->setDateOfBirth($dateOfBirth);
        $passenger->setCreatedAt(new \DateTime('now'));
        $passenger->setUpdatedAt(new \DateTime('now'));

        $em->persist($passenger);
        $em->flush();

        return $passenger;
    }

    /**
     * Retrieves an existing Passenger entity
     * 
     * @param int $passengerId the desired Passenger id
     * 
     * @return Passenger
     */
    public function getPassengerById($passengerId)
    {
        return $this->entityManager->getRepository('BsegalTravelApiBundle:Flight')
            ->find($flightId);
    }
}
