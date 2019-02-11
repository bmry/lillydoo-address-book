<?php
/**
 * Created by PhpStorm.
 * User: Morayo
 * Date: 2/11/2019
 * Time: 9:54 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * AddressBook
 *
 * @ORM\Table(name="address_book")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class AddressBook
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false, name="first_name")
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string",nullable=false, name="last_name")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, name="phone")
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="email")
     * @Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="street_name")
     */
    protected $streetName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="street_number")
     */
    protected $streetNumber;

    /**
     * @ORM\Column(type="string", length=20, nullable=false, name="zipcode")
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="city")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, name="country")
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="profile_picture")
     */
    protected $profilePicture;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="profile_picture", fileNameProperty="pictureFile")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/gif", "image/jpeg", "image/jpg", "image/png", "image/svg+xml"},
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     */
    protected $imageFile;

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param mixed $streetName
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }
    /**
     * @return mixed
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param mixed $streetNumber
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTime('now'));
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set logoFile.
     *
     * @param string $profilePicture
     *
     * @return AddressBook
     */
    public function setProfile($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture.
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

}
