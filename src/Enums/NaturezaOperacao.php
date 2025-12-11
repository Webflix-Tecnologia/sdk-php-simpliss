<?php

namespace Simpliss\Enums;

enum NaturezaOperacao: int {
    case TRIBUTACAO_NO_MUNICIPIO = 1;
    case TRIBUTACAO_FORA_MUNICIPIO = 2;
    case ISENCAO = 3;
    case IMUNE = 4;
    case EXIGIBILIDADE_SUSPENSA_DECISAO_JUDICIAL = 5;
    case EXIGIBILIDADE_SUSPENSA_PROCEDIMENTO_ADMINISTRATIVO = 6;
}
