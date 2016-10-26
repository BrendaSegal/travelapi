<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;

class PassengerController extends FOSRestController
{
    /**
    * @Post("/passenger/create", name="create_passenger", 
    * options={ "method_prefix" = false })
    *
    * Creates a new Passenger entity via POST request
    * 
    * @return  array data
    */
    public function createPassengerAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $passengerManager = $this->get('bsegal_travel_api.passenger_manager');

        $passenger = $passengerManager->createNewPassenger(
            $data['firstName'],
            $data['lastName'],
            $data['citizenshipCountry'],
            $data['passportNumber'],
            $$data['passportExpiry'],
            $data['phone'],
            $data['email'],
            $data['dateOfBirth']
        );

        return new Response('Created passenger with id '.$passenger->getId());
    }
}