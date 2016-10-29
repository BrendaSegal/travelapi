## Description

This package is an example Travel API allowing users to view all active Airports in the world, create a Passenger, create a Trip for a Passenger, and add Flights to a Trip. At this time, all Flight/Trip and Passenger information is dummy information.  The list of Airports is real.

The framework used is Symfony 3.1.5.

## Installation

1) Please install <a href="https://www.virtualbox.org/wiki/Downloads" target="_blank">VirtualBox 5.x</a>
2) Please install <a href="https://www.vagrantup.com/docs/installation/" target="_blank">vagrant</a> 
3) Please install <a href="https://laravel.com/docs/5.3/homestead#installation-and-setup" target="_blank">homestead</a> 
4) Clone the git repository <a href="https://github.com/BrendaSegal/travelapi" target="_blank">https://github.com/BrendaSegal/travelapi</a>
5) In the root folder of the repository, there is a Homestead.yaml file.  Please change the value under folders: -map: to where this project is installed on your local machine
6) Please add the following record to your local /hosts file:
    192.168.10.10 travelapi.dev
7) In app/config/parameters.yml, you may need to change your database_user and database_password values if yours are different.
8) Sample data was created using the Commands in src/Bsegal/TravelApi/Bundle/Command.  It can easily be imported via a mysql import of the travelapi.sql.gz file in this repository.
9) In order to run the application, please go to the location of your travelapi folder on your machine.  
 a) To boot your vagrant instance, type: vagrant up  
 b) Once, booted, type: vagrant ssh
 c) Type the command: cd travelapi
 d) Visit travelapi.dev in your browser