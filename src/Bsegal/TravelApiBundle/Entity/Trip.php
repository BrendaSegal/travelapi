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
     * @ORM\JoinTable(name="trips_return_flights",
     *      joinColumns={@ORM\JoinColumn(name="trip_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="flight_id", referencedColumnName="id")}
     *      )
     */
    private $returnFlights;

    /**
     * @ORM\ManyToMany(targetEntity="Flight")
     * @ORM\JoinTable(name="trips_outbound_flights",
     *      joinColumns={@ORM\JoinColumn(name="trip_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="flight_id", referencedColumnName="id")}
     *      )
     */
    private $outboundFlights;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->returnFlights = new \Doctrine\Common\Collections\ArrayCollection();
        $this->outboundFlights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add returnFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $returnFlight
     *
     * @return Trip
     */
    public function addReturnFlight(\Bsegal\TravelApiBundle\Entity\Flight $returnFlight)
    {
        $this->returnFlights[] = $returnFlight;

        return $this;
    }

    /**
     * Remove returnFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $returnFlight
     */
    public function removeReturnFlight(\Bsegal\TravelApiBundle\Entity\Flight $returnFlight)
    {
        $this->returnFlights->removeElement($returnFlight);
    }

    /**
     * Get returnFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReturnFlights()
    {
        return $this->returnFlights;
    }

    /**
     * Add outboundFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $outboundFlight
     *
     * @return Trip
     */
    public function addOutboundFlight(\Bsegal\TravelApiBundle\Entity\Flight $outboundFlight)
    {
        $this->outboundFlights[] = $outboundFlight;

        return $this;
    }

    /**
     * Remove outboundFlight
     *
     * @param \Bsegal\TravelApiBundle\Entity\Flight $outboundFlight
     */
    public function removeOutboundFlight(\Bsegal\TravelApiBundle\Entity\Flight $outboundFlight)
    {
        $this->outboundFlights->removeElement($outboundFlight);
    }

    /**
     * Get outboundFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOutboundFlights()
    {
        return $this->outboundFlights;
    }
}
