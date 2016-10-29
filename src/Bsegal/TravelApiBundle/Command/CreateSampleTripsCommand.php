<?php
namespace Bsegal\TravelApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;
use Bsegal\TravelApiBundle\Manager\FlightManager;
use Bsegal\TravelApiBundle\Manager\TripManager;
use Bsegal\TravelApiBundle\Entity\Passenger;

class CreateSampleTripsCommand extends ContainerAwareCommand
{
    protected function configure() 
    {
        $this->setName('travelapi:createsampletrips')
            ->setDescription('Creates sample data: trips.')
            ->setHelp("Create sample trips.");
    }
    
    /**
     * Executes command to create new sample Trips for each Passenger in the database.
     *     
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $flightManager = $this->getContainer()->get('bsegal_travel_api.flight_manager');
        $tripManager = $this->getContainer()->get('bsegal_travel_api.trip_manager');
        $passengerManager = $this->getContainer()->get('bsegal_travel_api.passenger_manager');
        
        $passengers = $passengerManager->getAllPassengers();
        
        foreach ($passengers as $passenger) {
            $this->createNewTrip($flightManager, $tripManager, $passenger);
        }
    }    
    
    /**
     * Creates a Trip entity for Passenger $passenger with random Flights.
     * 
     * @param \Bsegal\TravelApiBundle\Manager\FlightManager $flightManager
     * @param \Bsegal\TravelApiBundle\Manager\TripManager $tripManager
     * @param \Bsegal\TravelApiBundle\Entity\Passenger $passenger
     * 
     * @return \Bsegal\TravelApiBundle\Entity\Trip
     */
    protected function createNewTrip(
        FlightManager $flightManager,
        TripManager $tripManager, 
        Passenger $passenger
    ) {
        $isRoundtrip = rand(0,1) == 1;
        
        $outboundFlights = [];
        $outboundFlights[] = $flightManager->getRandomFlight();
        
        $returnFlights = [];
        
        if ($isRoundtrip) {
            $returnFlights[] = $flightManager->getRandomFlight(); 
        }
        
        return $tripManager->createNewTrip(
            $passenger,
            $outboundFlights,
            $returnFlights,
            $isRoundtrip
        );
    }
}
