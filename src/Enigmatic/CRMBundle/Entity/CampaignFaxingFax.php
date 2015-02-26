<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CampaignFaxingFax
 *
 * @ORM\Table(name="crm_campaign_faxing_fax")
 * @ORM\Entity
 */
class CampaignFaxingFax
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var CampaignFaxing
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\CampaignFaxing", inversedBy="faxs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $campaign;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=45)
     */
    private $path;

    /**
     * @Assert\File(
     *      maxSize="2M",
     *      mimeTypes={"application/pdf"},
     *      mimeTypesMessage = "enigmatic.crm.campaign_faxing.fax.file.mimeTypes"
     * )
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdated", type="datetime")
     */
    private $dateUpdated;

    /**
     * Constructor
     */
    public function __construct(CampaignFaxing $campaignFaxing = null)
    {
        $this->campaign = $campaignFaxing;
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    /**
     * Get getAbosolutePath
     *
     * @return string
     */
    public function getAbsolutePath(){
        return null === $this->path ? null : $this->getUploadRootDir().$this->getPath();
    }

    /**
     * Get getUploadRootDir
     *
     * @return string
     */
    public function getUploadRootDir(){
        return  __DIR__.'/../../../../media/fax/';
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
     * Set path
     *
     * @param string $path
     * @return CampaignFaxingFax
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set File
     *
     * @param File $file
     * @return File
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return CampaignFaxingFax
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return CampaignFaxingFax
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set campaign
     *
     * @param \Enigmatic\CRMBundle\Entity\CampaignFaxing $campaign
     * @return CampaignFaxingFax
     */
    public function setCampaign(\Enigmatic\CRMBundle\Entity\CampaignFaxing $campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return \Enigmatic\CRMBundle\Entity\CampaignFaxing 
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
}
