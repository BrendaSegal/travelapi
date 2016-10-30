# TravelAPI

## Description

This package is an example Travel API allowing users to view all active Airports in the world, create a Passenger, create a Trip for a Passenger, and add Flights to a Trip. At this time, all Flight/Trip and Passenger information is dummy information.  Also, adding Flights to a Trip does not yet factor in DateTime values, although the columns for arrival and departure times exist.
The list of Airports is real.

The framework used is Symfony 3.1.5.

## Installation
1. If you don't have version PHP 7 on your computer, you may have installation issues, please be sure to the follow the alternate step 8 below.
2. Install [VirtualBox 5.x](https://www.virtualbox.org/wiki/Downloads)
3. Install [vagrant](https://www.vagrantup.com/docs/installation/)
4. Clone the [git repository](https://github.com/BrendaSegal/travelapi)
5. In the root folder of the repository, there is a `Homestead.yaml` file.  Please change the value under folders: -map: to where this project is installed on your local machine
6. Add the following record to your local `/etc/hosts` file:
    `192.168.10.10 travelapi.dev`
7. In order to run the application, please go to the location of your `travelapi` folder on your machine via command line.  
8. IF YOU HAVE PHP 7 ON YOUR COMPUTER:
  * Type:
   ``` 
   composer install 
  ```

*`If an error occurs at this step, please see the ALTERNATE STEP 8`

8. ALTERNATE STEP 8 IF YOU DO NOT HAVE PHP 7 ON YOUR COMPUTER:
  * Run the command:
  ``` 
rm composer.lock 
  ```
  * Open the composer.json file in your root directory, and delete the following line:
 
    "doctrine/doctrine-migrations-bundle": "^1.0"
  * Run the command:
```
composer install
```
  * Once composer install completes, run the following 2 commands:
    ```
    git checkout -- composer.lock
    git checkout -- composer.json
    ```
9. To boot your vagrant instance, type:
    ``` 
     vagrant up 
    ```
10. Once, booted, type: 
  ``` 
  vagrant ssh
  cd travelapi
  composer install
   ```
  * Please accept the default parameters it provides. 
  * Sample data was created using the Commands in src/Bsegal/TravelApi/Bundle/Command.  It can easily be imported via a MySQL import of the travelapi.sql file in this repository.
  * Visit travelapi.dev/airports in your browser

### API Documentation
This can be found in the file APIDoc.md.

### NOTE THAT YOU CAN CONNECT TO MYSQL AS FOLLOWS:
```
vagrant ssh
mysql -uhomestead -psecret
```