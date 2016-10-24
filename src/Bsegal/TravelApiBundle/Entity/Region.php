<?php
namespace Bsegal\TravelApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="region", uniqueConstraints={@ORM\UniqueConstraint(name="code_idx", columns={"code"})})
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
      * @ORM\ManyToOne(targetEntity="Country")
      * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
      */
    private $country;

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
     * Set code
     *
     * @param string $code
     *
     * @return Region
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
     * Set name
     *
     * @param string $name
     *
     * @return Region
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
     * Set country
     *
     * @param \Bsegal\TravelApiBundle\Entity\Country $country
     *
     * @return Region
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
