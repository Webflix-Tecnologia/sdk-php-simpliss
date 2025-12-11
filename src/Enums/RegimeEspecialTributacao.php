<?php

namespace Simpliss\Enums;

enum RegimeEspecialTributacao: int {
    case MICROEMPRESA_MUNICIPAL = 1;
    case ESTIMATIVA = 2;
    case SOCIEDADE_PROFISSIONAIS = 3;
    case COOPERATIVA = 4;
    case MEI = 5;
    case ME_EPP = 6;
    case TRIBUTACAO_FATURAMENTO = 7;
    case FIXO = 8;
    case ISENCAO = 9;
    case IMUNE = 10;
    case EXIBILIDADE_SUSPENSA_DECISAO_JUDICIAL = 11;
    case EXIBILIDADE_SUSPENSA_PROCESSO_ADMINISTRATIVO = 12;
}
