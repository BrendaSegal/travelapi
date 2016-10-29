<?php
namespace Bsegal\TravelApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function addReturnFlightToTripAction($flightId, $tripId)
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_URL, $request->getHost()."/trips/".$tripId."/returnflights/".$flightId);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        return new JsonResponse([
            $result
        ]);
    }
    
    public function addOutboundFlightToTripAction($flightId, $tripId)
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_URL, $request->getHost()."/trips/".$tripId."/outboundflights/".$flightId);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        return new JsonResponse([
            $result
        ]);
    }
}