<?php
/**
 * Created by PhpStorm.
 * User: glenn
 * Date: 09.07.15
 * Time: 13:52.
 */

namespace AppBundle\Validaton\Constraints;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class AddressBookValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint)
    {
        if (!$object instanceof \AppBundle\Entity\AddressBook) {
            return;
        }

        if ($this->isPhoneNumberAlreadyExisting($object)) {
            $this->context->buildViolation(
                'address.error.duplicate_phone_number',
                []
            )->addViolation();
        }
        if ($this->isEmailExisting($object)) {
            $this->context->buildViolation(
                'address.error.duplicate_email',
                []
            )->addViolation();
        }
    }

    private function isPhoneNumberAlreadyExisting(\AppBundle\Entity\AddressBook $newRecord) {
        $duplicateEntry = false;
        $addressRepo = $this->em->getRepository('AppBundle:AddressBook');
        $existingRecord = $addressRepo->findOneBy(['phone' => $newRecord->getPhone()]);
        if(null != $existingRecord && !$this->isSameRecord($existingRecord,$newRecord)){
            $duplicateEntry = true;
        }
        return $duplicateEntry;
    }

    private  function isEmailExisting(\AppBundle\Entity\AddressBook $newRecord){
        $duplicateEntry = false;
        $addressRepo = $this->em->getRepository('AppBundle:AddressBook');
        $existingRecord = $addressRepo->findOneBy(['email' => $newRecord->getEmail()]);
        if(null != $existingRecord && !$this->isSameRecord($existingRecord,$newRecord)){
            $duplicateEntry = true;
        }
        return $duplicateEntry;
    }

    private function isSameRecord($existingRecord, $newRecord){
        $sameRecord = true;
        if(null != $existingRecord){
            if($existingRecord->getId()!== $newRecord->getId()){
                $sameRecord = false;
            }
        }
        return $sameRecord;
    }
}
