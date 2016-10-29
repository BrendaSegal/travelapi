## Description

This package is an example Travel API allowing users to view all active Airports in the world, create a Passenger, create a Trip for a Passenger, and add Flights to a Trip. At this time, all Flight/Trip and Passenger information is dummy information.  The list of Airports is real.

The framework used is Symfony 3.1.5.

## Installation
0) If you don't have version PHP 7 on your computer, you may have installation issues, please be sure to the follow the alternate step 8 below.
1) Please install <a href="https://www.virtualbox.org/wiki/Downloads" target="_blank">VirtualBox 5.x</a>
2) Please install <a href="https://www.vagrantup.com/docs/installation/" target="_blank">vagrant</a> 
3) Clone the git repository <a href="https://github.com/BrendaSegal/travelapi" target="_blank">https://github.com/BrendaSegal/travelapi</a>
5) In the root folder of the repository, there is a Homestead.yaml file.  Please change the value under folders: -map: to where this project is installed on your local machine
6) Please add the following record to your local /hosts file:
    192.168.10.10 travelapi.dev
7) In order to run the application, please go to the location of your travelapi folder on your machine via command line.  

IF YOU HAVE PHP 7 ON YOUR COMPUTER:
8) Type:
    composer install
=>If an error occurs at this step, please see the ALTERNATE STEP 8

ALTERNATE STEP 8 IF YOU DO NOT HAVE PHP 7 ON YOUR COMPUTER:
8) a)Run the command:
    rm composer.lock
   b) Open the composer.json file in your root directory, and delete the following line:
    "doctrine/doctrine-migrations-bundle": "^1.0"
   c)Run the command:
    composer install
   d)Once composer install completes, run the following 2 commands:
      a) git checkout -- composer.lock
      b) git checkout -- composer.json

9) To boot your vagrant instance,
     type: vagrant up
10) Once, booted, type: vagrant ssh
 c) Type the command: cd travelapi
 d) Type: composer install
 e) Please accept the default parameters it provides. 
 f) Sample data was created using the Commands in src/Bsegal/TravelApi/Bundle/Command.  It can easily be imported via a mysql import of the travelapi.sql file in this repository.
 g) Visit travelapi.dev in your browser

NOTE THAT YOU CAN CONNECT TO MYSQL AS FOLLOWS:
1) vagrant ssh
2) mysql -uhomestead -psecret
