<?php
namespace Bsegal\TravelApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;

class CreateSampleDataCommand extends ContainerAwareCommand
{
    protected function configure() 
    {
        $this->setName('travelapi:createsampledata')
            ->setDescription('Creates sample data: flights, passengers, trips.')
            ->setHelp("Create sample data.");
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
        $output->writeln("Creating new countries:");
        $this->createCountries($output, $this->getRealFilePath($this->csvPath, $this->countryCsv));

        $output->writeln("Creating new regions:");
        $this->createRegions($output, $this->getRealFilePath($this->csvPath, $this->regionCsv));

        $output->writeln("Creating new airports:");
        $this->createAirports($output, $this->getRealFilePath($this->csvPath, $this->airportCsv));
    }
}
