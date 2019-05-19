<?php

namespace Anaxago\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="interest")
 * @ORM\Entity(repositoryClass="Anaxago\CoreBundle\Repository\InterestRepository")
 */
class interest
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Anaxago\CoreBundle\Entity\Project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="Anaxago\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $username;


    /**
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

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
     * Set amount
     *
     * @param float $amount
     *
     * @return interest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set username
     *
     * @param \Anaxago\CoreBundle\Entity\User $username
     *
     * @return interest
     */
    public function setUsername(\Anaxago\CoreBundle\Entity\User $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return \Anaxago\CoreBundle\Entity\User
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set project
     *
     * @param \Anaxago\CoreBundle\Entity\Project $project
     *
     * @return interest
     */
    public function setProject(\Anaxago\CoreBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Anaxago\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
