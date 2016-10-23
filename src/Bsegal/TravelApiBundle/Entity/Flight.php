<?php
namespace Bsegal\TravelApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flight")
 */

class Flight
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
      * @ORM\ManyToOne(targetEntity="Airport")
      * @ORM\JoinColumn(name="arrival_airport_id", referencedColumnName="id", nullable=false)
      */
    private $arrivalAirport;

    /**
      * @ORM\ManyToOne(targetEntity="Airport")
      * @ORM\JoinColumn(name="departure_airport_id", referencedColumnName="id", nullable=false)
      */
    private $departureAirport;

    /**
     * @ORM\Column(name="tickets_available", type="integer", options={"default" : 0})
     */
    private $ticketsAvailable;

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
     * Set ticketsAvailable
     *
     * @param integer $ticketsAvailable
     *
     * @return Flight
     */
    public function setTicketsAvailable($ticketsAvailable)
    {
        $this->ticketsAvailable = $ticketsAvailable;

        return $this;
    }

    /**
     * Get ticketsAvailable
     *
     * @return integer
     */
    public function getTicketsAvailable()
    {
        return $this->ticketsAvailable;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Flight
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
     * @return Flight
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
     * Set arrivalAirport
     *
     * @param \Bsegal\TravelApiBundle\Entity\Airport $arrivalAirport
     *
     * @return Flight
     */
    public function setArrivalAirport(\Bsegal\TravelApiBundle\Entity\Airport $arrivalAirport)
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }

    /**
     * Get arrivalAirport
     *
     * @return \Bsegal\TravelApiBundle\Entity\Airport
     */
    public function getArrivalAirport()
    {
        return $this->arrivalAirport;
    }

    /**
     * Set departureAirport
     *
     * @param \Bsegal\TravelApiBundle\Entity\Airport $departureAirport
     *
     * @return Flight
     */
    public function setDepartureAirport(\Bsegal\TravelApiBundle\Entity\Airport $departureAirport)
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    /**
     * Get departureAirport
     *
     * @return \Bsegal\TravelApiBundle\Entity\Airport
     */
    public function getDepartureAirport()
    {
        return $this->departureAirport;
    }
}
