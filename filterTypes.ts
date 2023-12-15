import { IntRange } from "@/shared/types";

/**
 * Юридические опции
 */
export interface ILegalFilterOptions {
    /**
     * Флаг корабля (локаль)
     */
    flag?: string;

    /**
     * Тип эксплуатации
     */
    exploitations_type?: 'коммерческое' | 'некоммерческое';

    /**
     * формулы класса
     */
    class_formula?: string;

    /**
     * Ледовое усиление
     */
    ice_power?: boolean;

    /**
     * Тип судна
     */
    type?: string;

    /**
     * Назначение
     */
    purpose?: string;

    /**
     * Находилось ли на учете
     */
    was_registered?: boolean;

    /**
     * Учет действует до Date
     */
    register_valid_until?: string;

    /**
     * статус судна
     */
    vessel_status?: 'эксплуатируется' | 'на холодном отстое' | 'прекращено действие документов';

    /**
     * номер проекта
     */
    project_number?: string;

    /**
     * строительный номер
     */
    building_number?: string;

    /**
     * год постройки Date
     */
    building_year?: string;

    /**
     * страна постройки
     */
    building_country?: string;

    // порт приписки
    // страна
    port_adress_country?: string;

    // город
    port_adress_city?: string;

    /**
     * местонахождение судна
     */
    // порт или в рейсе
    vessel_location_country?: string;

    // порт или в рейсе
    vessel_location_city?: string;

    /**
     * Номер IMO
     */
    imo_number?: number;
}

/**
 * Технические опции
 */
export interface ITechnicalFilterOptions {
    /**
     * Минимальное длинна судна 60см
     */
    min_overall_length?: number;

    /**
     * Максималдьная длинна судна 458.5м
     */
    max_overall_length?: number;

    /**
     * Ширина судна 30см
     */
    min_overall_width?: number;

    /**
     * Ширина судна 70м
     */
    max_overall_width?: number;

    /**
     * Высота борта 5см
     */
    min_board_height?: number;

    /**
     * Высота борта 74м
     */
    max_board_height?: number;

    /**
     * Максимальный надводный борт 0
     */
    min_maximum_freeboard?: number;

    /**
     * Максимальный надводный борт 47м
     */
    max_maximum_freeboard?: number;

    /**
     * Материал корпуса
     */
    material?: 'древесина' | 'сталь' | 'железобетонный' | 'композитный',

    /**
     * Предельная масса (дедвейт) 0 
     */
    min_deadweight?: number,

    /**
     * Предельная масса (дедвейт) 600 000 т. 
     */
    max_deadweight?: number,

    /**
     * Доковый вес 0
     */
    min_dock_weight?: number;

    /**
     * Доковый вес 600 000 т.
     */
    max_dock_weight?: number;

    /**
     * Водоизмещение полное 0
     */
    min_full_displacement?: number;

    /**
     * Водоизмещение полное Infinity
     */
    max_full_displacement?: number;

    /**
     * Валовая вместимость 0
     */
    min_gross_tonnage?: number;

    /**
     * Валовая вместимость Infinity
     */
    max_gross_tonnage?: number;

    /**
     * Количество главных двигателей 1 - 8
     */
    num_engines?: IntRange<1, 9>;

    /**
     * Мощность двигателей 0
     */
    min_power?: number;

    /**
     * Мощность двигателей Infinty
     */
    max_power?: number;

    /**
     * Максимальная скорость в балласте км/ч
     */
    max_speed_in_ballast?: number;

    /**
     * Максимальная скорость в грузу
     */
    max_speed_in_load?: number;

    /**
     * Грузовой танк
     */
    cargo_tanks?: boolean;

    /**
     * Cуммарная вместимость если грузовой танк
     */
    total_capacity_cargo_tanks?: number;

    /**
     * Наливные танки
     */
    filling_tanks?: boolean;

    /**
     * Cуммарная вместимость если наливной танк
     */
    total_capacity_filling_tanks?: number;

    /**
     * Второе дно
     */
    seccond_bottom?: boolean;

    /**
     * Вторые борта
     */
    second_sides?: boolean;

    /**
     * Грузоподъемность 0
     */
    min_carrying?: number;

    /**
     * Грузоподъемность Infinty
     */
    max_carrying?: number;

    /**
     * Надстройки
     */
    superstructures?: boolean;

    /**
     * Рубки
     */
    deckhouses?: boolean;

    /**
     * Пассажировмещаемость 0 шаг в 1
     */
    min_passangers_avialable?: number;

    /**
     * Пассажировмещаемость Infinity 
     */
    max_passangers_avialable?: number;

    /**
     * Техническая документация
     */
    technical_documentation?: boolean;
}

export type TFilterOptions = ILegalFilterOptions & ITechnicalFilterOptions & {
    /**
     * Лимит для получения с бэка
     */
    limit?: number;
};