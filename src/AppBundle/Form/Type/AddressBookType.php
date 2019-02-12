<?php
/**
 * Created by PhpStorm.
 * User: MerijnCampsteyn
 * Date: 29-Dec-15
 * Time: 11:45 PM.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class AddressBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'form.label.first_name',
                'attr' => [
                    'autofocus' => true,
                    'class'=> "form-control"
                ],
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'form.label.last_name',
                'attr' => [
                    'required' => true,
                    'class'=> "form-control"
                ],
            ))
            ->add('streetNumber', TextType::class, array(
                'label' => 'form.label.street_number',
                'required' => true,
                'attr' => [
                    'class'=> "form-control"
                ],
            ))
            ->add('streetName', TextType::class, array(
                'label' => 'form.label.street_name',
                'required' => true,
                'attr' => [
                    'class'=> "form-control"
                ],
            ))
            ->add('zip', TextType::class, array(
                'label' => 'form.label.zipcode',
                'required' => true,
                'attr' => [
                    'class'=> "form-control"
                ],
            ))
            ->add('city', TextType::class, array(
                'label' => 'form.label.city',
                'required' => true,
                'attr' => [
                    'class'=> "form-control"
                ],
            ))->add('birthday',DateType::Class, array(
                'years' => range(date('Y'), date('Y')-100),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
                'attr' => ['class' => "form-control"]
            ))
            ->add('country', CountryType::class, array(
                'label' => 'form.label.country',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ))
            ->add('phone', TextType::class, array(
                'label' => 'form.label.phone',
                'required' => true,
                'attr' => [
                    'class'=> "form-control"
                ],
            ))
            ->add('email', EmailType::class, array(
                'label' => 'form.label.email',
                'required' => true,
                'attr' => [

                    'class'=> "form-control"
                ],
            ))
            ->add('imageFile', VichFileType::class, array(
                'required' => false,
                'label' => 'form.label.profile_picture',
            ))

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AddressBook',
        ));
    }

    public function getName()
    {
        return 'appbundle_address';
    }
}
