<?php
namespace Bsegal\TravelApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;
use Bsegal\TravelApiBundle\Manager\PassengerManager;

class CreateSamplePassengersCommand extends ContainerAwareCommand
{
    protected function configure() 
    {
        $this->setName('travelapi:createsamplepassengers')
            ->setDescription('Creates sample data: passengers.')
            ->setHelp("Create sample passengers.");
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
        $passengerManager = $this->getContainer()->get('bsegal_travel_api.passenger_manager');
       
        for ($i = 0; $i<200; $i++) {
            $this->createNewPassenger($passengerManager);
        }
    }
    
    protected function createNewPassenger(
        PassengerManager $passengerManager
    ) {   
        //select our random departure and arrival Airports
        $firstName = $this->selectRandomFirstName();
        $lastName = $this->selectRandomLastName();
        
        $phone = $this->selectRandomPhone();        
        $email = strtolower($firstName).".".strtolower($lastName)."@gmail.com";
        
        $passportDetails = $this->generatePassportDetails();

        //select our random departure and arrival dates
        $startDate = new \DateTime("now");
        $startDate->sub(new \DateInterval('P100Y'));
        
        $endDate = new \DateTime("now");
        $endDate->sub(new \DateInterval('P1Y'));
        
        $dateOfBirth = $this->selectRandomDate($startDate, $endDate);
        
        $passenger = $passengerManager->createNewPassenger(
            $firstName,
            $lastName,
            $passportDetails['citizenshipCountry'],
            $passportDetails['passportNumber'],
            $passportDetails['passportExpiry'],
            $phone,
            $email,
            $dateOfBirth
        );
    }
      
    protected function generatePassportDetails()
    {
        $countryArray = ['Canada', 'United States', 'France', 'United Kingdom', 'Germany', 'Italy', 'China'];
        
        $startDate = new \DateTime("now");
        $startDate->add(new \DateInterval('P100Y'));
        
        $endDate = new \DateTime("now");
        $endDate->add(new \DateInterval('P1Y'));
        
        $passportDetails = [];
        $passportDetails['passportNumber'] = $this->selectRandomPassportNumber();
        $passportDetails['passportExpiry'] = $this->selectRandomDate($startDate, $endDate);
        $passportDetails['citizenshipCountry'] = $countryArray[array_rand($countryArray)];
        
        return $passportDetails;        
    }
    
    protected function selectRandomPassportNumber()
    {
        $passportString = '';
        
        for ($i=0; $i<9; $i++) {
            $letterOrNumber = rand(0, 1);
            
            switch($letterOrNumber) {
                case 0:
                    $passportString .= chr(rand(65, 90));
                    break;
                case 1: 
                    $passportString .= rand(0, 9);
                    break;
            }
        }
        
        return $passportString;
    }
    
    protected function selectRandomDate($startDate, $endDate)
    {
        $randomTime = rand(strtotime($startDate->format('Y-m-d H:i:s')), strtotime($endDate->format('Y-m-d H:i:s')));

        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTime);

        return $randomDate;
    }
    
    protected function selectRandomPhone()
    {
        $phone = "";
        
        for ($i=0; $i<10; $i++) {
            $phone.=rand(1, 9);
        }
        
        return $phone;
    }
    
    protected function selectRandomFirstName()
    {
        $randomNames = [
            'Brenda',
            'Paul',
            'Tyler',
            'Linda',
            'Mickey',
            'Jon',
            'Homer',
            'Bart',
            'Lisa',
            'Marge',
            'Snoopy',
            'Fred',
            'Scooby',
            'Tyrion',
            'Archie',
            'Garfield',
            'Victor',
            'Jake',
            'Barney',
        ];
        
        $index = rand(0, count($randomNames)-1);
        
        return $randomNames[$index];
    }
    
    protected function selectRandomLastName()
    {
        $randomNames = [
            'Jones',
            'Paulson',
            'Smith',
            'Rubble',
            'Snow',
            'Simpson',
            'Lannister',
            'Blah',
            'Matthews',
            'White',
            'Green',
            'Mustard',
            'Daniels'
        ];
        
        $index = rand(0, count($randomNames)-1);
        
        return $randomNames[$index];
    }
}
