<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/../vendor/autoload.php";

$wsNfse = new Simpliss\Nfse(Simpliss\Core\SimplissWebservice::HOMOLOGATION_URL);

$wsNfse->setLogin('', '');

try{
    $wsNfseGerarResponse = $wsNfse->gerar([
        'GerarNovaNfseEnvio' => [
            'Prestador' => [
                'Cnpj' => '',
                'InscricaoMunicipal' => '',
            ],
            'InformacaoNfse' => [
                'NaturezaOperacao' => \Simpliss\Enums\NaturezaOperacao::ISENCAO->value,
                'RegimeEspecialTributacao' => \Simpliss\Enums\RegimeEspecialTributacao::TRIBUTACAO_FATURAMENTO->value,
//                    'RegimeEspecialTributacao' => $containsBooklet ? 
//                        \Simpliss\Enums\RegimeEspecialTributacao::TRIBUTACAO_FATURAMENTO->value : \Simpliss\Enums\RegimeEspecialTributacao::IMUNE->value,
                'OptanteSimplesNacional' => \Simpliss\Enums\OptanteSimplesNacional::NAO->value,
                'IncentivadorCultural' => \Simpliss\Enums\IncentivadorCultural::NAO->value,
                'Status' => \Simpliss\Enums\Status::ATIVA->value,
                'Competencia' => date('Y-m-d\TH:i:s.000\Z'),
                //'NfseSubstituida' => '',
                'OutrasInformacoes' => '',
                'Servico' => [
                    'Valores' => [
                        'ValorServicos' => 100, 
                        'ValorDeducoes' => 0,
                        'ValorPis' => 0,
                        'ValorCofins' => 0,
                        'ValorInss' => 0,
                        'ValorIr' => 0,
                        'ValorCsll' => 0,
                        'IssRetido' => true ?
                            \Simpliss\Enums\IssRetido::SIM->value : \Simpliss\Enums\IssRetido::NAO->value,
                        'ValorIss' => 0,
                        'ValorIssRetido' => 0,
                        'OutrasRetencoes' => 0,
                        'BaseCalculo' => 100,
                        'Aliquota' => 0,
                        'ValorLiquidoNfse' => 100,
                        //'DescontoIncondicionado' => '',
                        //'DescontoCondicionado' => '',
                    ],
                    'ItemListaServico' => '',
                    'CodigoCnae' => 5822101,
                    'CodigoTributacaoMunicipio' => '',
                    'Discriminacao' => '',
                    'CodigoMunicipio' => 3541406,
                    'ItensServico' => [[
                        'Descricao' => '',
                        'Quantidade' => 1,
                        'ValorUnitario' => 100,
                        'IssTributavel' => \Simpliss\Enums\IssTributavel::SIM->value,
                    ]],
                ],
                'Tomador' => [
                    'IdentificacaoTomador' => [
                        'CpfCnpj' => '',
                        'InscricaoMunicipal' => '',
                        'InscricaoEstadual' => '',
                    ],
                    'RazaoSocial' => '',
                    'Endereco' => [
                        'Endereco' => '',
                        'Numero' => '',
                        'Complemento' => '',
                        'Bairro' => '',
                        'CodigoMunicipio' => \Simpliss\Helper\SimplissHelper::getIgbdeCode('Presidente Prudente', 'SP'),//getIgbdeCode
                        'Uf' => '',
                        'Cep' => '',
                    ],
                    'Contato' => [
                        'Telefone' => '',
                        'Email' => '',
                    ]
                ],
//                'IntermediarioServico' => [
//                    'RazaoSocial' => '',
//                    'CpfCnpj' => [
//                        'Cnpj' => '',
//                        'Cpf' => '',
//                    ],
//                    'InscricaoMunicipal' => '',
//                ]
            ]
        ]
    ]);

    Simpliss\Helper\SimplissHelper::dump($wsNfseGerarResponse);
} catch (Telcom\Exceptions\TelcomException $ex) {

    Simpliss\Helper\SimplissHelper::dump($ex);
    
}

