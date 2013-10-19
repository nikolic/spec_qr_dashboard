<?php

namespace Acme\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qrcode
 */
class Qrcode
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var boolean
     */
    private $used;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var user
     */
    private $user;

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
     * Set secret
     *
     * @param string $secret
     * @return Qrcode
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    
        return $this;
    }

    /**
     * Get secret
     *
     * @return string 
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Qrcode
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set used
     *
     * @param boolean $used
     * @return Qrcode
     */
    public function setUsed($used)
    {
        $this->used = $used;
    
        return $this;
    }

    /**
     * Get used
     *
     * @return boolean 
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Qrcode
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Qrcode
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set weight
     *
     * @return Qrcode
     */
    public function setWeight($weight)
    {   
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set weight
     *
     * @return Qrcode
     */
    public function setUser($user)
    {   
        $this->user = $user;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }
}
