<?php

namespace Simpliss\Exceptions;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class SimplissException extends Exception{
    
    public function __construct(Exception $ex) {
        $message = $ex->getMessage() . ' <> ' . $ex->getTraceAsString();        
        parent::__construct($message, $ex->getCode(), $ex->getPrevious());
    }
    
    public static function fromObjectMessage($message, $code, $previous = null){
        
        if(is_array($message)){
            
            $newMessageString = [];
            
            foreach($message as $error){
                $newMessageString[] =  $error;
            }                           
            
            return new SimplissException( new Exception(implode("\n", $newMessageString), $code, $previous) );     
        }
        
        if(is_string($message)){
            
            return new SimplissException( new Exception($message, $code, $previous) );     
            
        }
        
    }
    
    public static function fromGuzzleException(ServerException|ClientException|BadResponseException $ex){
        $responseBody = '['.$ex::class.'] Body: ' . (string)$ex->getResponse()->getBody();
        return new SimplissException( new Exception($responseBody, $ex->getCode(), $ex->getPrevious()) );
    }
    
}
