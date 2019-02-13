<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AppControllerTest extends WebTestCase
{

    protected  $container;
    protected $entityManager;
    protected $client;


    public function setUp(){
        $this->client = static::createClient();
        $this->container = self::$kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();

    }

    protected function trans($string, $params = [], $domain = null)
    {
        return $this->container->get('translator')->trans($string, $params, $domain);
    }

    public function generateUrl($route, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        $uri = $this->container->get('router')->generate($route, $parameters, $referenceType);
        $uri = str_ireplace('/app_dev.php', '', $uri);

        return $uri;
    }

    public function testIndex()
    {
        $this->client->request('GET', '/');

        $response = $this->client->getResponse()->getContent();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("{$this->trans('header.adddress_form')}", $response);

    }

    public function testCreateAddressBook(){
        $crawler = $this->client->request(
            'GET',
            $this->generateUrl('app_address_book_create_new')
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $token = $crawler->filter('input#address_book__token')
            ->attr('value');
        $this->assertTrue(($token && null !== $token), 'token not found');

        if (!$token) {
            throw new \Exception('Unable to submit form without token');
        }

        $form = $crawler->selectButton("{$this->trans('form.label.btn_save')}")->form();
        $formName = 'address_book';

        $form["{$formName}[firstName]"] = 'Morayo';
        $form["{$formName}[lastName]"] = 'Bamgbose';
        $form["{$formName}[lastName]"] = 'Bamgbose';
        $form["{$formName}[email]"] = 'test@bamgbose.com';
        $form["{$formName}[phone]"] = '07030560077';
        $form["{$formName}[streetNumber]"] = '7';
        $form["{$formName}[streetName]"] = 'Faith Ajayi Street';
        $form["{$formName}[zip]"] = '23401';
        $form["{$formName}[city]"] = 'Lagos';

        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
    }

    public function testDuplicate(){
        $crawler = $this->client->request(
            'GET',
            $this->generateUrl('app_address_book_create_new')
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $token = $crawler->filter('input#address_book__token')
            ->attr('value');
        $this->assertTrue(($token && null !== $token), 'token not found');

        if (!$token) {
            throw new \Exception('Unable to submit form without token');
        }

        $form = $crawler->selectButton("{$this->trans('form.label.btn_save')}")->form();
        $formName = 'address_book';

        $form["{$formName}[firstName]"] = 'Morayo';
        $form["{$formName}[lastName]"] = 'Bamgbose';
        $form["{$formName}[lastName]"] = 'Bamgbose';
        $form["{$formName}[email]"] = 'test@bamgbose.com';
        $form["{$formName}[phone]"] = '07030560077';
        $form["{$formName}[streetNumber]"] = '7';
        $form["{$formName}[streetName]"] = 'Faith Ajayi Street';
        $form["{$formName}[zip]"] = '23401';
        $form["{$formName}[city]"] = 'Lagos';
        $crawler = $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("{$this->trans('address.error.duplicate_phone_number')}", $this->client->getResponse()->getContent());

    }

    public function testView(){
        $address = $this->entityManager->getRepository('AppBundle:AddressBook')->findOneBy(['email' => 'test@bamgbose.com']);
        $crawler = $this->client->request(
            'GET',
            $this->generateUrl('app_address_book_view', ['id' => $address->getId()])
        );

        $response = $this->client->getResponse()->getContent();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Morayo", $response);

    }

    public function testDelete(){
        $address = $this->entityManager->getRepository('AppBundle:AddressBook')->findOneBy(['email' => 'test@bamgbose.com']);
        $crawler = $this->client->request(
            'DELETE',
            $this->generateUrl('app_address_book_delete', ['id' => $address->getId()])
        );



        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();

        $response = $this->client->getResponse()->getContent();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertNotContains("Morayo", $response);
        $this->assertContains("{$this->trans('address.delete.success.message')}", $response);

    }
}
