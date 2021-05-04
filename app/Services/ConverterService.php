<?php


namespace App\Services;

/**
 * Czterocyfrowe skróty skończą się po ZZZZ ( 14_776_335 )
 * Czternaście milionów siedemset siedemdziesiąt sześć tysięcy trzysta trzydzieści pięć
 *
 * Class UrlConverter
 * @package App\Actions
 */
class ConverterService {

    public function toDec( $hash ) {
        $result = 0;

        $power = 0;
        foreach ( str_split( strrev( $hash ) ) as $digit ) {
            $result += $this->convertDuosexagesimal( $digit ) * pow( 62, $power );
            $power++;
        }

        return $result;
    }

    public function toDuosexagesimal( $dec ) {
        $result = "";

        do {
            $reminder = $dec % 62;
            $dec = ( $dec - $reminder ) / 62;

            $result = $this->convertDec( $reminder ) . $result;
        } while( $dec != 0 );

        return $result;
    }

    private function convertDec( $num ) {
        if ( $num < 10 ) {
            return strval( $num );
        }

        if ( $num >= 10 && $num < 36 ) {
            return chr( ord( "a" ) + ( $num - 10 ) );
        }

        if ( $num >= 36 && $num < 62 ) {
            return chr( ord( "A" ) + ( $num - 36 ) );
        }

        return "";
    }

    private function convertDuosexagesimal( $num ) {
        if ( is_numeric( $num ) ) {
            return intval( $num );
        }

        if ( ord( $num ) >= ord( "a") && ord( $num ) <= ord( "z") ) {
            return 10 + ( ord( $num ) - ord( "a" ) );
        }

        if ( ord( $num ) >= ord( "A") && ord( $num ) <= ord( "Z") ) {
            return 36 + ( ord( $num ) - ord( "A" ) );
        }

        return 0;
    }

}