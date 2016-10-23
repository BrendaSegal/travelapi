<?php
namespace Bsegal\TravelApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="passenger", uniqueConstraints={@ORM\UniqueConstraint(name="passport_number_idx", columns={"passport_number"})})
 */

class Passenger
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=150, nullable=false)
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=150, nullable=false)
     */
    private $lastName;

    /**
      * @ORM\ManyToOne(targetEntity="Country")
      * @ORM\JoinColumn(name="citizenship_country_id", referencedColumnName="id", nullable=false)
      */
    private $citizenshipCountry;

    /**
     * @ORM\Column(name="passport_number", type="string", length=20, nullable=false)
     */
    private $passportNumber;

    /**
     * @ORM\Column(name="passport_expiry", type="datetime", nullable=false)
     */
    private $passportExpiry;

    /**
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\Column(name="email", type="string", length=20)
     */
    private $email;

    /**
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=false)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Passenger
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Passenger
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set passportNumber
     *
     * @param string $passportNumber
     *
     * @return Passenger
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;

        return $this;
    }

    /**
     * Get passportNumber
     *
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * Set passportExpiry
     *
     * @param \DateTime $passportExpiry
     *
     * @return Passenger
     */
    public function setPassportExpiry($passportExpiry)
    {
        $this->passportExpiry = $passportExpiry;

        return $this;
    }

    /**
     * Get passportExpiry
     *
     * @return \DateTime
     */
    public function getPassportExpiry()
    {
        return $this->passportExpiry;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Passenger
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Passenger
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Passenger
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Passenger
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Passenger
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set citizenshipCountry
     *
     * @param \Bsegal\TravelApiBundle\Entity\Country $citizenshipCountry
     *
     * @return Passenger
     */
    public function setCitizenshipCountry(\Bsegal\TravelApiBundle\Entity\Country $citizenshipCountry)
    {
        $this->citizenshipCountry = $citizenshipCountry;

        return $this;
    }

    /**
     * Get citizenshipCountry
     *
     * @return \Bsegal\TravelApiBundle\Entity\Country
     */
    public function getCitizenshipCountry()
    {
        return $this->citizenshipCountry;
    }
}
