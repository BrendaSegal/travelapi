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
     * List all Flights.
     *
     * @return array data
     */
    public function getFlightsAction()
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlights();
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/flights/country/{countryName}", name="get_flights_by_country", 
    * options={ "method_prefix" = false })
    *
    * List all flights, filtered by country name.
    * 
    * @param string $countryName
    * 
    * @return  array data Flights With corresponding country name
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
    * @return array data with corresonding country code
    */
    public function getFlightsByCountryCodeAction($countryCode)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByCountryCode($countryCode);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
    * @Get("/flights/region/{regionName}", name="get_flights_by_region", 
    * options={ "method_prefix" = false })
    *
    * List all flights, filtered by region code.
    * 
    * @param string $regionName
    * 
    * @return  array data Flights with corresponding Region
    */
    public function getFlightsByRegionNameAction($regionName)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByRegion($regionName);
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
    * @return  array data Flights with corresponding municipality
    */
    public function getFlightsByMunicipalityAction($municipality)
    {
        $flightManager = $this->get('bsegal_travel_api.flight_manager');
        $flights = $flightManager->retrieveAllFlightsByMunicipality($municipality);
        $view = new View($flights);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
