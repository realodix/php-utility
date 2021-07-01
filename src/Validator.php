<?php

namespace Realodix\Utils;

class Validator
{
    use Validator\IdentificationsTrait;
    use Validator\NumberTrait;
    use Validator\StringTrait;

    public const CARD_SCHEMES = [
        // American Express card numbers start with 34 or 37 and have 15 digits.
        'AMEX' => [
            '/3[47][0-9]{13}/',
        ],
        // China UnionPay cards start with 62 and have between 16 and 19 digits. Please
        // note that these cards do not follow Luhn Algorithm as a checksum.
        'CHINA_UNIONPAY' => [
            '/^62[0-9]{14,17}$/',
        ],
        // Diners Club card numbers begin with 300 through 305, 36 or 38. All have 14
        // digits. There are Diners Club cards that begin with 5 and have 16 digits.
        // These are a joint venture between Diners Club and MasterCard, and should
        // be processed like a MasterCard.
        'DINERS' => [
            '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
        ],
        // Discover card numbers begin with 6011, 622126 through 622925, 644 through
        // 649 or 65. All have 16 digits.
        'DISCOVER' => [
            '/^6011[0-9]{12}$/',
            '/^64[4-9][0-9]{13}$/',
            '/^65[0-9]{14}$/',
            '/^622(12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|91[0-9]|92[0-5])[0-9]{10}$/',
        ],
        // InstaPayment cards begin with 637 through 639 and have 16 digits.
        'INSTAPAYMENT' => [
            '/^63[7-9][0-9]{13}$/',
        ],
        // JCB cards beginning with 2131 or 1800 have 15 digits. JCB cards beginning
        // with 35 have 16 digits.
        'JCB' => [
            '/^(?:2131|1800|35[0-9]{3})[0-9]{11}$/',
        ],
        // Laser cards begin with either 6304, 6706, 6709 or 6771 and have between 16
        // and 19 digits.
        'LASER' => [
            '/^(6304|670[69]|6771)[0-9]{12,15}$/',
        ],
        // Maestro international cards begin with 675900..675999 and have between 12
        // and 19 digits. Maestro UK cards begin with either 500000..509999 or
        // 560000..699999 and have between 12 and 19 digits.
        'MAESTRO' => [
            '/^(6759[0-9]{2})[0-9]{6,13}$/',
            '/^(50[0-9]{4})[0-9]{6,13}$/',
            '/^5[6-9][0-9]{10,17}$/',
            '/^6[0-9]{11,18}$/',
        ],
        // All MasterCard numbers start with the numbers 51 through 55. All have 16
        // digits. October 2016 MasterCard numbers can also start with 222100
        // through 272099.
        'MASTERCARD' => [
            '/^5[1-5][0-9]{14}$/',
            '/^2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12})$/',
        ],
        // Payment system MIR numbers start with 220, then 1 digit from 0 to 4, then
        // 12 digits.
        'MIR' => [
            '/^220[0-4][0-9]{12}$/',
        ],
        // All UATP card numbers start with a 1 and have a length of 15 digits.
        'UATP' => [
            '/^1[0-9]{14}$/',
        ],
        // All Visa card numbers start with a 4 and have a length of 13, 16, or 19
        // digits.
        'VISA' => [
            '/^4([0-9]{12}|[0-9]{15}|[0-9]{18})$/',
        ],
    ];

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
}
