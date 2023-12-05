<?php

namespace App\Http\Services;

trait EnumToArray
{

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

}

enum AdvertStateOnRU: string
{
    use EnumToArray;
    
    case Draft = 'Черновик'; //черновик
    case Moderation = 'На модерации'; //на модерации
    case Active = 'Активное'; //активное
    case Inactive = 'Неактивное'; //неактивное
    case Deleted = 'Удаленное'; //удаленное
}

enum AdvertState:int {
    case Draft = 1; //черновик
    case Moderation = 2; //на модерации
    case Active = 3; //активное
    case Inactive = 4; //неактивное
    case Deleted = 0; //удаленное
}

enum VesselType:int {
    case FullSizeSelfPropelled = 0; //полноразмерное самоходное
    case FullSizeNonSelfPropelled = 1; //полноразмерное несамоходное
    case SmallSizeSelfPropelled = 2; //маломерное самоходное
    case SmallSizeNonSelfPropelled = 3; //маломерное несамоходное
}

enum ExploitationType:int {
    case Commercial = 0;//коммерческое
    case NonCommercial = 1;//некоммерческое
}

class Consts
{
    public static function getVesselTypes(){
        return [
            3 => 'Полноразмерное самоходное',
            2 => 'Полноразмерное несамоходное',
            1 => 'Маломерное самоходное',
            0 => 'Маломерное несамоходное'
        ];
    }

    public static function getExploitationType(){
        return [
            1 => 'Коммерческое',
            0 => 'Некоммерческое'
        ];
    }
    public static function getMaterials(){
        return [
            4 => 'Сталь',
            3 => 'Железобетон',
            2 => 'Композит',
            1 => 'Дерево',
            0 => 'Стеклопластик'
        ];
    }

    public static function getClassFormulaLeftPart(){
        return [
            'fullsize' => [
                5 => 'Л',
                4 => 'Р',
                3 => 'О',
                2 => 'О-ПР',
                1 => 'М-ПР',
                0 => 'М-СП'
            ],
            'smallsize' => [
                10 => 'Л мс',
                11 => 'Р мс',
                12 => 'О мс',
                13 => 'О-ПР мс',
                14 => 'М-ПР мс',
                15 => 'М-СП мс',
                16 => 'I',
                17 => 'II',
                18 => 'III',
                19 => 'IV',
                20 => 'V',
                21 => 'VI'
            ]
        ];
    }
}

