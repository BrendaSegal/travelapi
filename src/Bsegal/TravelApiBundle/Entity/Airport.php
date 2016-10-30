<?php
namespace Bsegal\TravelApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="airport", uniqueConstraints={@ORM\UniqueConstraint(name="code_idx", columns={"code"})})
 */
class Airport
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="code", type="string", length=10, nullable=false)
     */
    private $code;

    /**
      * @ORM\ManyToOne(targetEntity="Region")
      * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false)
      */
    private $region;

    /**
      * @ORM\ManyToOne(targetEntity="Country")
      * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
      */
    private $country;

    /**
     * @ORM\Column(name="municipality", type="string", length=100, nullable=false)
     */
    private $municipality;

    /**
     * @ORM\Column(name="latitude_degree", type="decimal")
     */
    private $latitudeDegree;

    /**
     * @ORM\Column(name="longitude_degree", type="decimal")
     */
    private $longitudeDegree;

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
     * Set name
     *
     * @param string $name
     *
     * @return Airport
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Airport
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set municipality
     *
     * @param string $municipality
     *
     * @return Airport
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;

        return $this;
    }

    /**
     * Get municipality
     *
     * @return string
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * Set latitudeDegree
     *
     * @param string $latitudeDegree
     *
     * @return Airport
     */
    public function setLatitudeDegree($latitudeDegree)
    {
        $this->latitudeDegree = $latitudeDegree;

        return $this;
    }

    /**
     * Get latitudeDegree
     *
     * @return string
     */
    public function getLatitudeDegree()
    {
        return $this->latitudeDegree;
    }

    /**
     * Set longitudeDegree
     *
     * @param string $longitudeDegree
     *
     * @return Airport
     */
    public function setLongitudeDegree($longitudeDegree)
    {
        $this->longitudeDegree = $longitudeDegree;

        return $this;
    }

    /**
     * Get longitudeDegree
     *
     * @return string
     */
    public function getLongitudeDegree()
    {
        return $this->longitudeDegree;
    }

    /**
     * Set region
     *
     * @param \Bsegal\TravelApiBundle\Entity\Region $region
     *
     * @return Airport
     */
    public function setRegion(\Bsegal\TravelApiBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Bsegal\TravelApiBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set country
     *
     * @param \Bsegal\TravelApiBundle\Entity\Country $country
     *
     * @return Airport
     */
    public function setCountry(\Bsegal\TravelApiBundle\Entity\Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Bsegal\TravelApiBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
