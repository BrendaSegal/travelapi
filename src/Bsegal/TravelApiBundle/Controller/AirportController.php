<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

class AirportController extends FOSRestController
{  
    /**
     * List all airports alphabetically.
     *
     * @return array data
     */
    public function getAirportsAction()
    {
        $airportManager = $this->get('bsegal_travel_api.airport_manager');
        $airports = $airportManager->retrieveAllAirports();
        $view = new View($airports);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/airports/country/{countryName}", name="get_airports_by_country", 
    * options={ "method_prefix" = false })
    *
    * List all airports, filtered by country name.
    * 
    * @param string $countryName
    * 
    * @return  array data Airports with corresponding country name
    */
    public function getAirportsByCountryAction($countryName)
    {
        $airportManager = $this->get('bsegal_travel_api.airport_manager');
        $airports = $airportManager->retrieveAllAirportsByCountryName($countryName);
        $view = new View($airports);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/airports/country/code/{countryCode}", name="get_airports_by_country_code", 
    * options={ "method_prefix" = false })
    *
    * List all airports, filtered by country code.
    * 
    * @param string $countryCode
    * 
    * @return  array data Airports with corresponding country code
    */
    public function getAirportsByCountryCodeAction($countryCode)
    {
        $airportManager = $this->get('bsegal_travel_api.airport_manager');
        $airports = $airportManager->retrieveAllAirportsByCountryCode($countryCode);
        $view = new View($airports);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
