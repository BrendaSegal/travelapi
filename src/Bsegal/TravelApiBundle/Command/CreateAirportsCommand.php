<?php
namespace Bsegal\TravelApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;

class CreateAirportsCommand extends ContainerAwareCommand
{
    protected $csvPath = "*/Bsegal/TravelApiBundle/Resources/csv";
    protected $countryCsv = "countries.csv";
    protected $regionCsv = "regions.csv";
    protected $airportCsv = "airports.csv";

    protected function configure() 
    {
        $this->setName('travelapi:createairports')
            ->setDescription('Creates airports, countries, regions from csv.')
            ->setHelp("Create airports from csv...");
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

    /**
     * Locates the file in $filePath/$fileName and returns the path to this file
     * 
     * @param  string $filePath part of the path to the file
     * @param  string $fileName the filename
     * 
     * @return string actual path to file
     */
    protected function getRealFilePath($filePath, $fileName)
    {
        $finder = new Finder();
        $fileResults = $finder->in($filePath)->name($fileName);

        if (empty($fileResults)) {
            return false;
        }

        $iterator = $finder->getIterator();
        $iterator->rewind();
        $file = $iterator->current();

        return $file->getRealPath();
    }

    /**
     * Creates Region entities, by reading the lines in the regions csv file. 
     * 
     * @param  OutputInterface $output
     * @param  string $regionCsv path to the regions csv file
     * 
     * @return void
     */
    protected function createRegions(OutputInterface $output, $regionCsv)
    {
        $columnsOfConcern = [
            'code' => 1, 
            'name' => 3, 
            'countryCode' => 5
        ];

        $regionManager = $this->getContainer()->get('bsegal_travel_api.region_manager');

        if (($handle = fopen($regionCsv, "r")) !== FALSE) {
            $row = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                
                if ($num<6) {
                    $output->writeln('Something is wrong with the format of your regions.csv.  Exiting...');
                    exit();
                }

                $row++;

                //skip first row which is the header
                if ($row==1) {
                    continue;
                }

                try {                    
                    $region = $regionManager->createNewRegion(
                        $data[$columnsOfConcern['code']], 
                        $data[$columnsOfConcern['name']], 
                        $data[$columnsOfConcern['countryCode']]
                    );
                } catch (\Exception $e) {
                    $output->writeln($e->getMessage());
                    continue;
                }

                if (!is_null($region)) {
                    $output->writeln("Create new region ".$data[$columnsOfConcern['name']]." with code ".$data[$columnsOfConcern['code']]." and country code ".$data[$columnsOfConcern['countryCode']]);
                } else {
                    $output->writeln("Failed to create region ".$data[$columnsOfConcern['name']]." with code ".$data[$columnsOfConcern['code']]." and country code ".$data[$columnsOfConcern['countryCode']]);
                }
            }

            fclose($handle);
        }
    }

    /**
     * Creates Country entities, by reading the lines in the countries csv file. 
     * 
     * @param  OutputInterface $output
     * @param  string $regionCsv path to the regions csv file
     * 
     * @return void
     */
    protected function createCountries(OutputInterface $output, $countryCsv)
    {
        $columnsOfConcern = [
            'code' => 1, 
            'name' => 2, 
            'continent' => 3
        ];

        $countryManager = $this->getContainer()->get('bsegal_travel_api.country_manager');

        if (($handle = fopen($countryCsv, "r")) !== FALSE) {
            $row = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);

                if ($num<4) {
                    $output->writeln('Something is wrong with the format of your countries.csv.  Exiting...');
                    exit();
                }

                $row++;

                //skip first row which is the header
                if ($row==1) {
                    continue;
                }

                try {
                    $country = $countryManager->createNewCountry(
                        $data[$columnsOfConcern['code']], 
                        $data[$columnsOfConcern['name']], 
                        $data[$columnsOfConcern['continent']]
                    );
                } catch (\Exception $e) {
                    $output->writeln($e->getMessage());
                    continue;
                }

                if (!is_null($country)) {
                    $output->writeln("Create new country ".$data[$columnsOfConcern['name']]." with code ".$data[$columnsOfConcern['code']]." and continent ".$data[$columnsOfConcern['continent']]);
                } else {
                    $output->writeln("Failed to create country ".$data[$columnsOfConcern['name']]." with code ".$data[$columnsOfConcern['code']]." and continent ".$data[$columnsOfConcern['continent']]);
                }
            }

            fclose($handle);
        }
    }

    /**
     * Creates Airport entities, by reading the lines in the airports csv file. 
     * 
     * @param  OutputInterface $output
     * @param  string $regionCsv path to the regions csv file
     * 
     * @return void
     */
    protected function createAirports(OutputInterface $output, $airportCsv)
    {
        $columnsOfConcern = [
            'code' => 1, 
            'airportType' => 2,
            'name' => 3, 
            'latitudeDegree' => 4, 
            'longitudeDegree' => 5, 
            'countryCode' => 8, 
            'regionCode' => 9, 
            'municipality' =>10,
        ];

        $airportManager = $this->getContainer()->get('bsegal_travel_api.airport_manager');

        if (($handle = fopen($airportCsv, "r")) !== FALSE) {
            $row = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                
                if ($num<11) {
                    $output->writeln('Something is wrong with the format of your airports.csv.  Exiting...');
                    exit();
                }

                $row++;

                //skip first row which is the header
                if ($row==1) {
                    continue;
                }

                //if the airport is a heliport or seaplane_base or closed, we skip it
                if (in_array(
                        $data[$columnsOfConcern['airportType']], 
                        ['closed', 'heliport', 'seaplane_base']
                    )
                ) {
                    $output->writeln('Skipping airport '.$data[$columnsOfConcern['code']].' of type '.$data[$columnsOfConcern['airportType']]);
                    continue;
                }

                try {
                    $airport = $airportManager->createNewAirport(
                        $data[$columnsOfConcern['code']],
                        $data[$columnsOfConcern['name']],
                        $data[$columnsOfConcern['latitudeDegree']],
                        $data[$columnsOfConcern['longitudeDegree']],
                        $data[$columnsOfConcern['countryCode']],
                        $data[$columnsOfConcern['regionCode']],
                        $data[$columnsOfConcern['municipality']]
                    );
                } catch (\Exception $e) {
                    $output->writeln($e->getMessage());
                    continue;
                }

                if (!is_null($airport)) {
                    $output->writeln("Create new airport with code ".$data[$columnsOfConcern['code']]." and name ".$data[$columnsOfConcern['name']]);
                } else {
                    $output->writeln("Failed to create airport with code ".$data[$columnsOfConcern['code']]." and name ".$data[$columnsOfConcern['name']]); 
                }
            }

            fclose($handle);
        }
    }
}
