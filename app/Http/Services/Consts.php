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

enum AdvertType:int {
    case Sale = 0;//Продажа
    case Fracht = 1;//Фрахт
}

enum FrachtPriceType:int {
    case Year = 0;
    case Month = 1;
    case Day = 2;
}

class Consts
{
    public static function getVesselStatuses(){
        return [
            0 => 'На холодном отстое',
            1 => 'Действующие документы',
            2 => 'Недействующие документы',
            3 => 'Без документов'
        ];
    }

    public static function getFrachtPriceTypes(){
        return [
            0 => 'Год',
            1 => 'Месяц',
            2 => 'День',
            null => null
        ];
    }

    public static function getFrachtTypes(){
        return [
            0 => 'Тайм чартер (с командой)',
            1 => 'Бербоут чартер (без команды)',
            null => null
        ];
    }

    public static function getAdvertTypes(){
        return [
            0 => 'Продажа',
            1 => 'Фрахт (аренда)',
        ];
    }

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
}

