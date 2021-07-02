<?php

namespace Realodix\Utils\Number;

class Iban
{
    /**
     * IBAN per country validation rules
     */
    public const IBAN_COUNTRY_CODE = [
        'AD' => 'AD\d{2}\d{4}\d{4}[\dA-Z]{12}', // Andorra
        'AE' => 'AE\d{2}\d{3}\d{16}', // United Arab Emirates
        'AL' => 'AL\d{2}\d{8}[\dA-Z]{16}', // Albania
        'AO' => 'AO\d{2}\d{21}', // Angola
        'AT' => 'AT\d{2}\d{5}\d{11}', // Austria
        'AX' => 'FI\d{2}\d{6}\d{7}\d{1}', // Aland Islands
        'AZ' => 'AZ\d{2}[A-Z]{4}[\dA-Z]{20}', // Azerbaijan
        'BA' => 'BA\d{2}\d{3}\d{3}\d{8}\d{2}', // Bosnia and Herzegovina
        'BE' => 'BE\d{2}\d{3}\d{7}\d{2}', // Belgium
        'BF' => 'BF\d{2}\d{23}', // Burkina Faso
        'BG' => 'BG\d{2}[A-Z]{4}\d{4}\d{2}[\dA-Z]{8}', // Bulgaria
        'BH' => 'BH\d{2}[A-Z]{4}[\dA-Z]{14}', // Bahrain
        'BI' => 'BI\d{2}\d{12}', // Burundi
        'BJ' => 'BJ\d{2}[A-Z]{1}\d{23}', // Benin
        'BY' => 'BY\d{2}[\dA-Z]{4}\d{4}[\dA-Z]{16}', // Belarus - https://bank.codes/iban/structure/belarus/
        'BL' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Saint Barthelemy
        'BR' => 'BR\d{2}\d{8}\d{5}\d{10}[A-Z][\dA-Z]', // Brazil
        'CG' => 'CG\d{2}\d{23}', // Congo
        'CH' => 'CH\d{2}\d{5}[\dA-Z]{12}', // Switzerland
        'CI' => 'CI\d{2}[A-Z]{1}\d{23}', // Ivory Coast
        'CM' => 'CM\d{2}\d{23}', // Cameron
        'CR' => 'CR\d{2}0\d{3}\d{14}', // Costa Rica
        'CV' => 'CV\d{2}\d{21}', // Cape Verde
        'CY' => 'CY\d{2}\d{3}\d{5}[\dA-Z]{16}', // Cyprus
        'CZ' => 'CZ\d{2}\d{20}', // Czech Republic
        'DE' => 'DE\d{2}\d{8}\d{10}', // Germany
        'DO' => 'DO\d{2}[\dA-Z]{4}\d{20}', // Dominican Republic
        'DK' => 'DK\d{2}\d{4}\d{10}', // Denmark
        'DZ' => 'DZ\d{2}\d{20}', // Algeria
        'EE' => 'EE\d{2}\d{2}\d{2}\d{11}\d{1}', // Estonia
        'ES' => 'ES\d{2}\d{4}\d{4}\d{1}\d{1}\d{10}', // Spain (also includes Canary Islands, Ceuta and Melilla)
        'FI' => 'FI\d{2}\d{6}\d{7}\d{1}', // Finland
        'FO' => 'FO\d{2}\d{4}\d{9}\d{1}', // Faroe Islands
        'FR' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // France
        'GF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // French Guyana
        'GB' => 'GB\d{2}[A-Z]{4}\d{6}\d{8}', // United Kingdom of Great Britain and Northern Ireland
        'GE' => 'GE\d{2}[A-Z]{2}\d{16}', // Georgia
        'GI' => 'GI\d{2}[A-Z]{4}[\dA-Z]{15}', // Gibraltar
        'GL' => 'GL\d{2}\d{4}\d{9}\d{1}', // Greenland
        'GP' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Guadeloupe
        'GR' => 'GR\d{2}\d{3}\d{4}[\dA-Z]{16}', // Greece
        'GT' => 'GT\d{2}[\dA-Z]{4}[\dA-Z]{20}', // Guatemala
        'HR' => 'HR\d{2}\d{7}\d{10}', // Croatia
        'HU' => 'HU\d{2}\d{3}\d{4}\d{1}\d{15}\d{1}', // Hungary
        'IE' => 'IE\d{2}[A-Z]{4}\d{6}\d{8}', // Ireland
        'IL' => 'IL\d{2}\d{3}\d{3}\d{13}', // Israel
        'IR' => 'IR\d{2}\d{22}', // Iran
        'IS' => 'IS\d{2}\d{4}\d{2}\d{6}\d{10}', // Iceland
        'IT' => 'IT\d{2}[A-Z]{1}\d{5}\d{5}[\dA-Z]{12}', // Italy
        'JO' => 'JO\d{2}[A-Z]{4}\d{4}[\dA-Z]{18}', // Jordan
        'KW' => 'KW\d{2}[A-Z]{4}\d{22}', // KUWAIT
        'KZ' => 'KZ\d{2}\d{3}[\dA-Z]{13}', // Kazakhstan
        'LB' => 'LB\d{2}\d{4}[\dA-Z]{20}', // LEBANON
        'LI' => 'LI\d{2}\d{5}[\dA-Z]{12}', // Liechtenstein (Principality of)
        'LT' => 'LT\d{2}\d{5}\d{11}', // Lithuania
        'LU' => 'LU\d{2}\d{3}[\dA-Z]{13}', // Luxembourg
        'LV' => 'LV\d{2}[A-Z]{4}[\dA-Z]{13}', // Latvia
        'MC' => 'MC\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Monaco
        'MD' => 'MD\d{2}[\dA-Z]{2}[\dA-Z]{18}', // Moldova
        'ME' => 'ME\d{2}\d{3}\d{13}\d{2}', // Montenegro
        'MF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Saint Martin (French part)
        'MG' => 'MG\d{2}\d{23}', // Madagascar
        'MK' => 'MK\d{2}\d{3}[\dA-Z]{10}\d{2}', // Macedonia, Former Yugoslav Republic of
        'ML' => 'ML\d{2}[A-Z]{1}\d{23}', // Mali
        'MQ' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Martinique
        'MR' => 'MR13\d{5}\d{5}\d{11}\d{2}', // Mauritania
        'MT' => 'MT\d{2}[A-Z]{4}\d{5}[\dA-Z]{18}', // Malta
        'MU' => 'MU\d{2}[A-Z]{4}\d{2}\d{2}\d{12}\d{3}[A-Z]{3}', // Mauritius
        'MZ' => 'MZ\d{2}\d{21}', // Mozambique
        'NC' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // New Caledonia
        'NL' => 'NL\d{2}[A-Z]{4}\d{10}', // The Netherlands
        'NO' => 'NO\d{2}\d{4}\d{6}\d{1}', // Norway
        'PF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // French Polynesia
        'PK' => 'PK\d{2}[A-Z]{4}[\dA-Z]{16}', // Pakistan
        'PL' => 'PL\d{2}\d{8}\d{16}', // Poland
        'PM' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Saint Pierre et Miquelon
        'PS' => 'PS\d{2}[A-Z]{4}[\dA-Z]{21}', // Palestine, State of
        'PT' => 'PT\d{2}\d{4}\d{4}\d{11}\d{2}', // Portugal (plus Azores and Madeira)
        'QA' => 'QA\d{2}[A-Z]{4}[\dA-Z]{21}', // Qatar
        'RE' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Reunion
        'RO' => 'RO\d{2}[A-Z]{4}[\dA-Z]{16}', // Romania
        'RS' => 'RS\d{2}\d{3}\d{13}\d{2}', // Serbia
        'SA' => 'SA\d{2}\d{2}[\dA-Z]{18}', // Saudi Arabia
        'SE' => 'SE\d{2}\d{3}\d{16}\d{1}', // Sweden
        'SI' => 'SI\d{2}\d{5}\d{8}\d{2}', // Slovenia
        'SK' => 'SK\d{2}\d{4}\d{6}\d{10}', // Slovak Republic
        'SM' => 'SM\d{2}[A-Z]{1}\d{5}\d{5}[\dA-Z]{12}', // San Marino
        'SN' => 'SN\d{2}[A-Z]{1}\d{23}', // Senegal
        'TF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // French Southern Territories
        'TL' => 'TL\d{2}\d{3}\d{14}\d{2}', // Timor-Leste
        'TN' => 'TN59\d{2}\d{3}\d{13}\d{2}', // Tunisia
        'TR' => 'TR\d{2}\d{5}[\dA-Z]{1}[\dA-Z]{16}', // Turkey
        'UA' => 'UA\d{2}\d{6}[\dA-Z]{19}', // Ukraine
        'VA' => 'VA\d{2}\d{3}\d{15}', // Vatican City State
        'VG' => 'VG\d{2}[A-Z]{4}\d{16}', // Virgin Islands, British
        'WF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Wallis and Futuna Islands
        'XK' => 'XK\d{2}\d{4}\d{10}\d{2}', // Republic of Kosovo
        'YT' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}', // Mayotte
    ];

    /**
     * Ensure that a bank account number has the proper format of an International Bank
     * Account Number (IBAN).
     *
     * @param string $iban
     * @param bool   $machineFormatOnly
     *
     * @return bool
     */
    public static function verify(string $iban, bool $machineFormatOnly = false): bool
    {
        // Per country validation rules
        $formats = self::IBAN_COUNTRY_CODE;

        // First convert to machine format.
        if (! $machineFormatOnly) {
            $iban = self::toMachineFormat($iban);
        }

        // The IBAN must contain only digits and characters...
        $countryCode = substr($iban, 0, 2);
        if (! ctype_alnum($iban)
            || ! ctype_alpha($countryCode) // ..start with a two-letter country code
            || ! array_key_exists($countryCode, $formats) // ..have a format available
            || ! preg_match('/^'.$formats[$countryCode].'$/', $iban) // ..and have a valid format
        ) {
            return false;
        }

        // Move the first four characters to the end
        // e.g. CH93 0076 2011 6238 5295 7
        //   -> 0076 2011 6238 5295 7 CH93
        $iban = substr($iban, 4).substr($iban, 0, 4);

        // Convert all remaining letters to their ordinals. The result is an integer,
        // which is too large for PHP's int data type, so we store it in a string instead.
        // e.g. 0076 2011 6238 5295 7 CH93
        //   -> 0076 2011 6238 5295 7 121893
        $checkSum = Number::charToInt($iban, 1);

        // Do a modulo-97 operation on the large integer. We cannot use PHP's modulo
        // operator, so we calculate the modulo step-wisely instead
        if (1 !== Number::mod97($checkSum)) {
            return false;
        }

        return true;
    }

    /**
     * Convert an IBAN to human format. To do this, we simply insert spaces right now, as
     * per the ECBS (European Committee for Banking Standards)
     *
     * recommendations available at:
     * http://www.europeanpaymentscouncil.eu/knowledge_bank_download.cfm?file=ECBS%20standard%20implementation%20guidelines%20SIG203V3.2.pdf
     *
     * @param string $iban
     *
     * @return string
     */
    public static function toHumanFormat($iban)
    {
        // Remove all spaces
        $iban = str_replace(' ', '', $iban);

        // Add spaces every four characters
        return wordwrap($iban, 4, ' ', true);
    }

    /**
     * Convert an IBAN to machine format. To do this, we remove IBAN from the start, if
     * present, and remove non basic roman letter / digit characters
     *
     * @param string $iban
     *
     * @return string
     */
    public static function toMachineFormat($iban)
    {
        // Uppercase and trim spaces from left
        $iban = ltrim(strtoupper($iban));

        // Remove IIBAN or IBAN from start of string, if present
        $iban = preg_replace('/^I?IBAN/', '', $iban);

        // Remove all non basic roman letter / digit characters
        $iban = preg_replace('/[^a-zA-Z0-9]/', '', $iban);

        return $iban;
    }

    /**
     * Convert an IBAN to obfuscated presentation. To do this, we replace the checksum and
     * all subsequent characters with an asterisk, except for the final four characters,
     * and then return in human format
     *
     * ie.
     * HU69107000246667654851100005 -> HU** **** **** **** **** **** 0005
     *
     * We avoid the checksum as it may be used to infer the rest of the IBAN in cases
     * where the country has few valid banks and branches, or other information about the
     * account such as bank, branch, or date issued is known (where a sequential issuance
     * scheme is in use).
     *
     * Note that output of this function should be presented with other information to a
     * user, such as the date last used or the date added to their account, in order to
     * better facilitate unambiguous relative identification.
     *
     * @param mixed $iban
     *
     * @return string
     */
    public static function toObfuscatedFormat($iban)
    {
        $iban = self::toMachineFormat($iban);
        $tr = substr($iban, 0, 2);

        for ($i = 2; $i < strlen($iban) - 4; $i++) {
            $tr .= '*';
        }

        $tr .= substr($iban, strlen($iban) - 4);

        return self::toHumanFormat($tr);
    }

    /**
     * Get the BBAN part from an IBAN
     *
     * @param string $iban
     *
     * @return string
     */
    public static function getBban(string $iban)
    {
        $iban = self::toMachineFormat($iban);

        return substr($iban, 4);
    }

    /**
     * Find the correct checksum for an IBAN
     *
     * @param string $iban The IBAN whose checksum should be calculated
     *
     * @return string
     */
    public static function getChecksum(string $iban)
    {
        $iban = self::toMachineFormat($iban);
        $charToInt = Number::charToInt(substr($iban, 4).substr($iban, 0, 2).'00', 1);
        $checksum = Number::mod97($charToInt);

        // return 98 minus the mod97-10 output, left zero padded to two digits
        return str_pad((98 - $checksum), 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $iban
     *
     * @return string
     */
    public static function setChecksum(string $iban)
    {
        $iban = self::toMachineFormat($iban);

        return substr($iban, 0, 2).self::getChecksum($iban).substr($iban, 4);
    }
}
