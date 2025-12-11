<?php

namespace Simpliss\Helper;

class SimplissHelper {
        
    public static function dump($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    
    public static function removeAccents($text){
        $map = [
            'Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A',
            'á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a',
            'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
            'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
            'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
            'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
            'ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
            'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U',
            'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
            'Ç'=>'C','ç'=>'c',
            'Ñ'=>'N','ñ'=>'n'
        ];

        return strtr($text, $map);
    }
    
    public static function urlTitle(string $str, string $separator = '-', bool $lowercase = false): string{
        $qSeparator = preg_quote($separator, '#');

        $trans = [
            '&.+?;'                  => '',
            '[^\w\d\pL\pM _-]'       => '',
            '\s+'                    => $separator,
            '(' . $qSeparator . ')+' => $separator,
        ];

        $str = strip_tags($str);

        foreach ($trans as $key => $val) {
            $str = preg_replace('#' . $key . '#iu', $val, $str);
        }

        if ($lowercase) {
            $str = mb_strtolower($str);
        }

        return trim(trim($str, $separator));
    }
    
    public static function getIgbdeCode($cityName, $state){
        $cidadeIbgeId = null;
                
        try{
            
            $client = new \GuzzleHttp\Client();
            $clientResponse = $client->get("https://servicodados.ibge.gov.br/api/v1/localidades/municipios/" . self::urlTitle(self::removeAccents($cityName), "-", true));
            
            $cidadeIbge = @json_decode($clientResponse->getBody());
            
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            
            throw \Simpliss\Exceptions\SimplissException::fromGuzzleException($ex);
            
        }
        
        if(empty($cidadeIbge)){
            throw \Simpliss\Exceptions\SimplissException::fromObjectMessage("(1) Não foi possivel localizar o código do IBGE dessa cidade: " . $cityName, 404);
        }

        if(is_array($cidadeIbge)){
            foreach ($cidadeIbge as $codigoIbgeDecodedItem) {
                if ($codigoIbgeDecodedItem->microrregiao->mesorregiao->UF->sigla == strtoupper($state)) {
                    $cidadeIbgeId = $codigoIbgeDecodedItem->id;
                    break;
                }
            }

            if(empty($cidadeIbgeId)){
                throw \Simpliss\Exceptions\SimplissException::fromObjectMessage("(2) Não foi possivel localizar o código do IBGE dessa cidade: " . $cityName . " no estado: " . $state, 404);
            }
        }
        elseif(is_object($cidadeIbge)){
            if (property_exists($cidadeIbge, 'id')) {
                $cidadeIbgeId = $cidadeIbge->id;
            } else {
                throw \Simpliss\Exceptions\SimplissException::fromObjectMessage($cidadeIbgeId . " - (3) Não foi possivel localizar o código do IBGE dessa cidade: " . $cityName, 404);
            }
        }
        else{
            throw \Simpliss\Exceptions\SimplissException::fromObjectMessage("(4) Não foi possivel localizar o código do IBGE dessa cidade: " . $cityName, 404);
        }

        return $cidadeIbgeId;
    }
    
}
