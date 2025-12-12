<?php

namespace Simpliss;

class Nfse{
    private $wsdl;
    private array $options = [];
    
    private $soapClient;
    
    private $login;
    private $password;
    
    public function __construct($wsdl, array $options = []) {
        $defaults = [
            'trace' => false,
            'timeout' => 30000,
            'connecttimeout' => 30000,
            'sslverifypeer' => false,
        ];
        
        $options = array_merge_recursive($defaults, $options);
        
        $this->soapClient = new Core\SimplissWebservice($wsdl, $options);
    }  
    
    public function gerar(array $data){
        $data = array_merge($data, [
            'pParam' => [
                'P1' => $this->login,//cnpj
                'P2' => $this->password,//senha
            ]
        ]);
        
        return $this->soapClient->GerarNfse($data);
    }
    
    public function consultar(array $data){
        $data = array_merge($data, [
            'pParam' => [
                'P1' => $this->login,//cnpj
                'P2' => $this->password,//senha
            ]
        ]);
        
        return $this->soapClient->ConsultarNfse($data);
    }
    
    public function cancelar(array $data){
        $data = array_merge($data, [
            'pParam' => [
                'P1' => $this->login,//cnpj
                'P2' => $this->password,//senha
            ]
        ]);
        
        return $this->soapClient->CancelarNfse($data);
    }
    
    public function getLastResponse(){
        return $this->soapClient->__getLastResponse();
    }
    
    public function dumpSoa(){
        Helper\SimplissHelper::dump([
            'request' => $this->soapClient->__getLastRequest(),
            'response' => $this->soapClient->__getLastResponse(),
        ]);
    }
    
    public function setLogin($login, $password){
        $this->login = $login;
        $this->password = $password;
        return $this;
    }
}
