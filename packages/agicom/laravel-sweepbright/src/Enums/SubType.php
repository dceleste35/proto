<?php

namespace Agicom\Sweepbright\Enums;

use Agicom\Sweepbright\Enums\Concerns\HasFurnishedLabel;
use Agicom\Sweepbright\Enums\Concerns\HasLabel;

enum SubType: string
{
    use HasFurnishedLabel;
    use HasLabel;

    case Chalet = 'chalet';
    case ChaletAlpine = 'chalet_alpine';
    case Agricultural = 'agricultural';
    case ApartmentBlock = 'apartment_block';
    case Buildable = 'buildable';
    case Bungalow = 'bungalow';
    case Condo = 'condo';
    case Cottage = 'cottage';
    case CoveredOutdoorSpace = 'covered_outdoor_space';
    case Coworking = 'coworking';
    case Detached = 'detached';
    case Duplex = 'duplex';
    case EndOfTerrace = 'end_of_terrace';
    case Farm = 'farm';
    case FlexOffice = 'flex_office';
    case Healthcare = 'healthcare';
    case IndoorParkingSpace = 'indoor_parking_space';
    case Industrial = 'industrial';
    case InvestmentProperty = 'investment_property';
    case LeasureAndSports = 'leasure_and_sports';
    case Loft = 'loft';
    case Mansion = 'mansion';
    case MasFarmhouse = 'mas_farmhouse';
    case OpenOffice = 'open_office';
    case OutdoorParkingSpace = 'outdoor_parking_space';
    case PastureLand = 'pasture_land';
    case Penthouse = 'penthouse';
    case PrivateGarage = 'private_garage';
    case Recreational = 'recreational';
    case RestaurantAndCafe = 'restaurant_and_café';
    case Retail = 'retail';
    case SemiDetached = 'semi_detached';
    case Shop = 'shop';
    case StudentAccommodation = 'student_accommodation';
    case Terraced = 'terraced';
    case Townhouse = 'townhouse';
    case Villa = 'villa';
    case Warehouse = 'warehouse';
    case Studio = 'studio';
    case Triplex = 'triplex';
    case Barge = 'barge';
    case Castle = 'castle';
    case EquestrianProperty = 'equestrian_property';
    case HuntingProperty = 'hunting_property';
    case Other = 'other';
    case Vineyard = 'vineyard';
    case Bnb = 'bnb';
    case TradingFund = 'trading_fund';
    case MixedUse = 'mixed_use';

    public function upper()
    {
        return strtoupper($this->value);
    }
}
