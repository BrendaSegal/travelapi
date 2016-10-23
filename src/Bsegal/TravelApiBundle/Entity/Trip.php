<?php
namespace Bsegal\TravelApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="trip")
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="is_roundtrip", type="boolean", options={"default" : false})
     */
    private $isRoundtrip;

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
     * @ORM\ManyToOne(targetEntity="Passenger")
     * @ORM\JoinColumn(name="passenger_id", referencedColumnName="id", nullable=false)
     */
    private $passenger;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Flight")
     * @ORM\JoinTable(name="trips_arrival_flights",
     *      joinColumns={@ORM\JoinColumn(name="trip_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="flight_id", referencedColumnName="id")}
     *      )
     */
    private $arrivalFlights;

    /**
     * @ORM\ManyToMany(targetEntity="Flight")
     * @ORM\JoinTable(name="trips_departure_flights",
     *      joinColumns={@ORM\JoinColumn(name="trip_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="flight_id", referencedColumnName="id")}
     *      )
     */
    private $departureFlights;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arrivalFlights = new \Doctrine\Common\Collections\ArrayCollection();
        $this->departureFlights = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set isRoundtrip
     *
     * @param boolean $isRoundtrip
     *
     * @return Trip
     */
    public function setIsRoundtrip($isRoundtrip)
    {
        $this->isRoundtrip = $isRoundtrip;

        return $this;
    }

    /**
     * Get isRoundtrip
     *
     * @return boolean
     */
    public function getIsRoundtrip()
    {
        return $this->isRoundtrip;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Trip
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
     * @return Trip
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
     * @return Trip
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
     * @return Trip
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

    /**
     * Set passenger
     *
     * @param \Bsegal\TravelApiBundle\Entity\Passenger $passenger
     *
     * @return Trip
     */
    public function setPassenger(\Bsegal\TravelApiBundle\Entity\Passenger $passenger)
    {
        $this->passenger = $passenger;

        return $this;
    }

    /**
     * Get passenger
     *
     * @return \Bsegal\TravelApiBundle\Entity\Passenger
     */
    public function getPassenger()
    {
        return $this->passenger;
    }

    /**
     * Add arrivalFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $arrivalFlight
     *
     * @return Trip
     */
    public function addArrivalFlight(\Bsegal\TravelApiBundle\Entity\Flight $arrivalFlight)
    {
        $this->arrivalFlights[] = $arrivalFlight;

        return $this;
    }

    /**
     * Remove arrivalFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $arrivalFlight
     */
    public function removeArrivalFlight(\Bsegal\TravelApiBundle\Entity\Flight $arrivalFlight)
    {
        $this->arrivalFlights->removeElement($arrivalFlight);
    }

    /**
     * Get arrivalFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArrivalFlights()
    {
        return $this->arrivalFlights;
    }

    /**
     * Add departureFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $departureFlight
     *
     * @return Trip
     */
    public function addDepartureFlight(\Bsegal\TravelApiBundle\Entity\Flight $departureFlight)
    {
        $this->departureFlights[] = $departureFlight;

        return $this;
    }

    /**
     * Remove departureFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $departureFlight
     */
    public function removeDepartureFlight(\Bsegal\TravelApiBundle\Entity\Flight $departureFlight)
    {
        $this->departureFlights->removeElement($departureFlight);
    }

    /**
     * Get departureFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartureFlights()
    {
        return $this->departureFlights;
    }
}
