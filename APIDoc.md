#  TravelAPI Doc

## Airports

* ###### Path
    GET /airports

    ###### Summary
    Lists Airports

    ###### Description
    Returns a list of Airport entities

    ###### Responses
    Returns an array of Airports in JSON

* ###### Path
    GET /airports/country

    ###### Summary
    Returns a list of Airports for the given country.

    ###### Description
    Returns a list of Airport entities for the given country name provided

    ###### Parameters
    * **countryName** the desired country name

    ###### Responses
    Returns an array of Airports in JSON

* ###### Path
    GET /airports/country/code

    ###### Summary
    Returns a list of Airports for the given country.

    ###### Description
    Returns a list of Airport entities for the given country code provided

    ###### Parameters
    * **countryCode** the desired country code

    ###### Responses
    Returns an array of Airports in JSON

## Flights
* ###### Path
    GET /flights

    ###### Summary
    Lists Flights

    ###### Description
    Returns a list of Flight entities

    ###### Responses
    Returns an array of Flights in JSON

* ###### Path
    GET /flights/country

    ###### Summary
    Returns a list of Flights for the given country.

    ###### Description
    Returns a list of Flight entities for the given country name provided.

    ###### Parameters
    * **countryName** the desired country name

    ###### Responses
    Returns an array of Flights in JSON

* ###### Path
    GET /flights/country/code

    ###### Summary
    Returns a list of Flights for the given country.

    ###### Description
    Returns a list of Flight entities for the given country code provided

    ###### Parameters
    * **countryCode** the desired country code

    ###### Responses
    Returns an array of Flights in JSON

* ###### Path
    GET /flights/region

    ###### Summary
    Returns a list of Flights for the given region.

    ###### Description
    Returns a list of Flight entities for the given region name provided

    ###### Parameters
    * **regionName** the desired region name

    ###### Responses
    Returns an array of Flights in JSON

* ###### Path
    GET /flights/muncipality

    ###### Summary
    Returns a list of Flights for the given municipality.

    ###### Description
    Returns a list of Flight entities for the given municipality provided

    ###### Parameters
    * **municipality** the desired region name

    ###### Responses
    Returns an array of Flights in JSON

## Passengers
* ###### Path
    GET /passengers

    ###### Summary
    Returns a Passenger.

    ###### Description
    Returns a Passenger for the provided passenger id.

    ###### Parameters
    * **passengerId** id representing the Passenger entity

    ###### Responses
    Returns a Passenger entity in JSON

* ###### Path
    POST /passengers

    ###### Summary
    Creates a Passenger.

    ###### Description
    Creates a Passenger with the provided parameters.

    ###### Parameters
    * **firstName** the Passenger's given name
    * **lastName** the Passenger's surname
    * **citizenshipCountry** the name of the Country of citizenship
    * **passportNumber** the Passenger's passport number
    * **passportExpiry** the Passenger's passport expiry date in the format YYYY-MM-DD
    * **phone** the Passenger's phone number
    * **email** the Passenger's email
    * **dateOfBirth** the Passenger's date of birth in the format YYYY-MM-DD

    ###### Responses
    Returns the resulting created new Passenger entity in JSON.

* ###### Path
    GET passengers/{passengerId}/trips

    ###### Summary
    Returns a list of Trips.

    ###### Description
    Returns a list of Trips for the Passenger with id passengerId

    ###### Parameters
    * **passengerId** the desired Passenger's id

    ###### Responses
    Returns an array of Trips in JSON

* ###### Path
    GET passengers/{passengerId}/flights

    ###### Summary
    Returns a list of Flights.

    ###### Description
    Returns a list of Flights for the Passenger with id passengerId.

    ###### Parameters
    * **passengerId** the desired Passenger's id

    ###### Responses
    Returns an array of Flights in JSON

## Trips
* ###### Path
    GET /trips

    ###### Summary
    Returns a Trip.

    ###### Description
    Returns a Trip for the provided trip id.

    ###### Parameters
    * **tripId** id representing the Trip entity

    ###### Responses
    Returns a Trip entity in JSON

* ###### Path
    POST /trips

    ###### Summary
    Creates a Trip.

    ###### Description
    Creates a Trip with the provided parameters.

    ###### Parameters
    * **passengerId** the id of the Passenger who will be on the Trip
    * **isRoundtrip** 0 if not a roundtrip, 1 otherwise

    ###### Responses
    Returns the resulting created new Trip entity in JSON.

* ###### Path
    GET trips/{tripId}/flights

    ###### Summary
    Returns a list of Flights.

    ###### Description
    Returns a list of Flights for the Trip with id tripId.

    ###### Parameters
    * **tripId** the desired Trip's id

    ###### Responses
    Returns an array of Flight entities in JSON

* ###### Path
    PUT /trips/{tripId}/outboundflights/{flightId}

    ###### Summary
    Adds an outbound Flight to a Trip.

    ###### Description
    Adds Flight with flightId as an outbound flight for the Trip with tripId

    ###### Parameters
    * **tripId** the desired Trip's id
    * **flightId** the desired Flight's id

    ###### Responses
    Returns the updated Trip entity in JSON.

* ###### Path
    PUT /trips/{tripId}/returnflights/{flightId}

    ###### Summary
    Adds a return Flight to a Trip.

    ###### Description
    Adds Flight with flightId as a return flight for the Trip with tripId

    ###### Parameters
    * **tripId** the desired Trip's id
    * **flightId** the desired Flight's id

    ###### Responses
    Returns the updated Trip entity in JSON.

* ###### Path
    GET /trips/{tripId}/outboundflights/{flightId}/remove

    ###### Summary
    Removes an outbound Flight from a Trip.

    ###### Description
    Removes Flight with flightId as an outbound flight for the Trip with tripId

    ###### Parameters
    * **tripId** the desired Trip's id
    * **flightId** the desired Flight's id

    ###### Responses
    Returns the updated Trip entity in JSON.

* ###### Path

    GET /trips/{tripId}/returnflights/{flightId}/remove

    ###### Summary

    Removes a return Flight from a Trip.

    ###### Description

    Removes Flight with flightId as a return flight for the Trip with tripId

    ###### Parameters
    * **tripId** the desired Trip's id
    * **flightId** the desired Flight's id

    ###### Responses
    Returns the updated Trip entity in JSON.