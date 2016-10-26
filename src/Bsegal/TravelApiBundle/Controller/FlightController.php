<?php

namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

class FlightController extends FOSRestController
{
    /**
    * @Get("/flights/country/{countryName}", name="get_flights_by_country", 
    * options={ "method_prefix" = false })
    *
    * List all flights, filtered by country name.
    * 
    * @param string $countryName
    * 
    * @return  array data
    */
    public function getFlightsByCountryAction($countryName)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByCountryName($countryName);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/flights/country/code/{countryCode}", name="get_flights_by_country_code", 
    * options={ "method_prefix" = false })
    *
    * List all flights, filtered by country code.
    * 
    * @param string $countryCode
    * 
    * @return  array data
    */
    public function getFlightsByCountryCodeAction($countryCode)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByCountryCode($countryCode);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/flights/region/code/{regionCode}", name="get_flights_by_region_code", 
    * options={ "method_prefix" = false })
    *
    * List all flights, filtered by region code.
    * 
    * @param string $regionCode
    * 
    * @return  array data
    */
    public function getFlightsByRegionCodeAction($regionCode)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByCountryCode($countryCode);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/flights/municipality/{municipality}", name="get_flights_by_municipality", 
    * options={ "method_prefix" = false })
    *
    * List all flights for a given municipality.
    * 
    * @param string $municipality
    * 
    * @return  array data
    */
    public function getFlightsByMunicipalityAction($municipality)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByMunicipality($municipality);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
