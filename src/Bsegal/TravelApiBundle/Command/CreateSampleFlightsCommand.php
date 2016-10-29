<?php
namespace Bsegal\TravelApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;
use Bsegal\TravelApiBundle\Entity\Airport as Airport;
use Bsegal\TravelApiBundle\Manager\FlightManager as FlightManager;

class CreateSampleFlightsCommand extends ContainerAwareCommand
{
    protected function configure() 
    {
        $this->setName('travelapi:createsampleflights')
            ->setDescription('Creates sample data: flights.')
            ->setHelp("Create sample flights.");
    }

    /**
     * Executes command to create new Country, Region, and Airport entities
     *     from the csv files stored in Bsegal/TravelApiBundle/Resources/csv/.
     *     
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $flightManager = $this->getContainer()->get('bsegal_travel_api.flight_manager');
        
        for ($i = 0; $i<100; $i++) {
            $this->createNewFlight($output, $flightManager);
        }
    }

    protected function createNewFlight(OutputInterface $output, FlightManager $flightManager)
    {   
        //select our random departure and arrival Airports
        $departureAirport = $this->selectRandomAirport();
        $arrivalAirport = $this->selectRandomAirport($departureAirport->getId());

        //select our random departure and arrival dates
        $dates = $this->retrieveDepartureArrivalDates();
        $departureTime = $dates['departureTime'];
        $arrivalTime = $dates['arrivalTime'];

        //select the random number of tickets available to be sold
        $numberOfTicketsAvailable = rand(0, 100);

        $output->writeln("Departure airport: ".$departureAirport->getCode()." at ".$departureTime->format('Y-m-d H:i:s')."; Arrival airport: ".$arrivalAirport->getCode()." at ".$arrivalTime->format('Y-m-d H:i:s')." and number of tickets available ".$numberOfTicketsAvailable);

        $flightManager->createNewFlight(
            $departureAirport,
            $arrivalAirport,
            $departureTime,
            $arrivalTime,
            $numberOfTicketsAvailable
        );
    }

    protected function retrieveDepartureArrivalDates()
    {
        //for our initial dates, we will chose anytime between now and 30 days from now
        $startDate = new \DateTime();
        $endDate = new \DateTime();
        $endDate->add(new \DateInterval('P30D'));

        $departureTime = $this->selectRandomTime($startDate, $endDate);

        //note that our arrival time should be a few hours after our departure time
        $maxStartArrivalTime = new \DateTime($departureTime->format('Y-m-d H:i:s'));
        $maxStartArrivalTime->add(new \DateInterval('PT1H'));

        $maxEndArrivalTime = new \DateTime($departureTime->format('Y-m-d H:i:s'));
        $maxEndArrivalTime->add(new \DateInterval('PT10H'));

        $arrivalTime = $this->selectRandomTime($maxStartArrivalTime, $maxEndArrivalTime);

        return [
            'departureTime' => $departureTime,
            'arrivalTime' => $arrivalTime,
        ];
    }

    protected function selectRandomTime($startDate, $endDate)
    {
        $randomTime = rand(strtotime($startDate->format('Y-m-d H:i:s')), strtotime($endDate->format('Y-m-d H:i:s')));

        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTime);

        return $randomDate;
    }

    /**
     * Returns a random Airport entity from the table
     * 
     * @param  integer $ignoreAirportWithId id of Airport entity we DON'T want 
     * returned, as it may correspond to the departure airport when selecting
     * an arrival airport
     * 
     * @return Airport
     */
    protected function selectRandomAirport($ignoreAirportWithId = -1)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $airportId = $this->chooseRandomAirportId($ignoreAirportWithId);

        return $entityManager->getRepository('BsegalTravelApiBundle:Airport')
            ->find($airportId);
    } 

    /**
     * Chooses a random number corresponding  to an Airport id between 1 and 
     * the number of rows in the airport table
     * 
     * @param  integer $ignoreAirportWithId if the returned value corresponds to this value, 
     * we make another attempt, in order to prevent the departure and arrival Airports being the same
     *
     * @throws  \Exception if we attempted to find a proper Airport id, but failed after 50 attempts 
     *
     * @return integer the desired random id
     */
    protected function chooseRandomAirportId($ignoreAirportWithId = -1)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        //first count number of airports
        $query = $entityManager->createQueryBuilder()
            ->select('COUNT(a.id)') 
            ->from('BsegalTravelApiBundle:Airport', 'a')
            ->getQuery();

        $upperLimit = $query->getSingleScalarResult();

        $attempts = 0;

        while ($attempts < 50) {
            $randomAirportId = rand(1, $upperLimit);

            if ($randomAirportId != $ignoreAirportWithId) {
                return $randomAirportId;
            }

            $attempts++;
        }
        
        throw new \Exception("Failed to choose a random airport.");
    }

}
