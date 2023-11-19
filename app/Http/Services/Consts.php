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

class Consts
{
    public static function getVesselTypes(){
        return [
            0 => 'Полноразмерное самоходное',
            1 => 'Полноразмерное несамоходное',
            2 => 'Маломерное самоходное',
            3 => 'Маломерное несамоходное'
        ];
    }
}

enum AdvertStateOnRU: string
{
    use EnumToArray;
    
    case Hearts = 'H';
    case Diamonds = 'D';
    case Clubs = 'C';
    case Spades = 'S';
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


