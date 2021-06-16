<?php

namespace Realodix\Utils\Test\Validators;

trait IdentificationsTestProvider
{
    public function creditCardProvider()
    {
        return [
            ['AMEX', '378282246310005'],
            ['AMEX', '371449635398431'],
            ['AMEX', '378734493671000'],
            ['AMEX', '347298508610146'],
            ['CHINA_UNIONPAY', '6228888888888888'],
            ['CHINA_UNIONPAY', '62288888888888888'],
            ['CHINA_UNIONPAY', '622888888888888888'],
            ['CHINA_UNIONPAY', '6228888888888888888'],
            ['DINERS', '30569309025904'],
            ['DINERS', '36088894118515'],
            ['DINERS', '38520000023237'],
            ['DISCOVER', '6011111111111117'],
            ['DISCOVER', '6011000990139424'],
            ['INSTAPAYMENT', '6372476031350068'],
            ['INSTAPAYMENT', '6385537775789749'],
            ['INSTAPAYMENT', '6393440808445746'],
            ['JCB', '3530111333300000'],
            ['JCB', '3566002020360505'],
            ['JCB', '213112345678901'],
            ['JCB', '180012345678901'],
            ['LASER', '6304678107004080'],
            ['LASER', '6706440607428128629'],
            ['LASER', '6771656738314582216'],
            ['MAESTRO', '6759744069209'],
            ['MAESTRO', '5020507657408074712'],
            ['MAESTRO', '5612559223580173965'],
            ['MAESTRO', '6759744069209'],
            ['MAESTRO', '6594371785970435599'],
            ['MASTERCARD', '5555555555554444'],
            ['MASTERCARD', '5105105105105100'],
            ['MASTERCARD', '2221005555554444'],
            ['MASTERCARD', '2230000000000000'],
            ['MASTERCARD', '2300000000000000'],
            ['MASTERCARD', '2699999999999999'],
            ['MASTERCARD', '2709999999999999'],
            ['MASTERCARD', '2720995105105100'],
            ['MIR', '2200381427330082'],
            ['UATP', '110165309696173'],
            ['VISA', '4111111111111111'],
            ['VISA', '4012888888881881'],
            ['VISA', '4222222222222'],
            ['VISA', '4917610000000000003'],
            [['AMEX', 'VISA'], '4111111111111111'],
            [['AMEX', 'VISA'], '378282246310005'],
            [['JCB', 'MASTERCARD'], '5105105105105100'],
            [['VISA', 'MASTERCARD'], '5105105105105100'],
        ];
    }

    public function creditCardInvalidProvider()
    {
        return [
            // Not numeric error
            ['AMEX', 'invalid'], // A string

            // Invalid format error
            ['VISA', '42424242424242424242'],
            ['AMEX', '357298508610146'],
            ['DINERS', '31569309025904'],
            ['DINERS', '37088894118515'],
            ['INSTAPAYMENT', '6313440808445746'],
            ['CHINA_UNIONPAY', '622888888888888'],
            ['CHINA_UNIONPAY', '62288888888888888888'],
            ['AMEX', '30569309025904'], // DINERS number
            ['AMEX', 0], // a lone number
            ['AMEX', '0'], // a lone number
            ['AMEX', '000000000000'], // a lone number
            ['DINERS', '3056930'], // only first part of the number
            ['DISCOVER', '1117'], // only last 4 digits
            ['MASTERCARD', '2721001234567890'], // Not assigned yet
            ['MASTERCARD', '2220991234567890'], // Not assigned yet
            ['UATP', '11016530969617'], // invalid length
            ['MIR', '22003814273300821'], // invalid length
        ];
    }

    public function isbn10Provider()
    {
        return [
            ['1338218395'],
            ['133821666X'],

            ['0-45122-5244'],
            ['0-4712-92311'],
            ['0_45122_5244'],
            ['2870#971#648'],
            ['0-9752298-0-X'],
            ['ISBN 1-58182-008-9'],
            ['ISBN-10: 0451225244'],
        ];
    }

    public function isbn10InvalidProvider()
    {
        return [
            ['27234422841'],
            ['272344228'],
            ['0-4712-9231'],
            ['1234567890'],
            ['0987656789'],
            ['7-35622-5444'],
            ['0-4X19-92611'],
            ['1A34567890'],
            // chr(1) evaluates to 0
            // 2070546810 is valid
            ['2'.\chr(1).'70546810'],
        ];
    }

    public function isbn13Provider()
    {
        return [
            ['978-1338345728'],
            ['978_1338345728'],
            ['978#1338345728'],

            ['978-1-338-34572-8'],
            ['978 1 338 34572 8'],

            ['ISBN 978-1-338-34572-8'],
            ['ISBN: 978-1-338-34572-8'],
            // ['ISBN13 978-1-338-34572-8'],
            ['ISBN-13: 978-1-338-34572-8'],
        ];
    }

    public function isbn13InvalidProvider()
    {
        return [
            ['978-27234422821'],
            ['978-272344228'],
            ['978-2723442-82'],
            ['978-2723442281'],
            ['978-0321513774'],
            ['979-0431225385'],
            ['980-0474292319'],
            ['0-4X19-92619812'],
            ['978-272C442282'],
            // chr(1) evaluates to 0
            // 978-2070546817 is valid
            ['978-2'.\chr(1).'70546817'],
        ];
    }

    public function issnProvider()
    {
        return [
            // Valid lower cased issn
            ['2162-321x'],
            ['2160-200x'],
            ['1537-453x'],
            ['1937-710x'],
            ['0002-922x'],
            ['1553-345x'],
            ['1553-619x'],

            // Valid non hyphenated issn
            ['2162321X'],
            ['01896016'],
            ['15744647'],
            ['14350645'],
            ['07174055'],
            ['20905076'],
            ['14401592'],

            // Full valid issn
            ['1550-7416'],
            ['1539-8560'],
            ['2156-5376'],
            ['1119-023X'],
            ['1684-5315'],
            ['1996-0786'],
            ['1684-5374'],
            ['1996-0794'],
        ];
    }

    public function issnInvalidProvider()
    {
        return [
            // Too short error
            [0],
            [null],
            ['1539'],

            // Invalid characters error
            ['2156-537y'],
            ['1996-07y4'],

            // Checksum failed error
            ['1119-0231'],
            ['1684-5312'],
            ['1996-0783'],
            ['1684-537X'],
            ['1996-0795'],
        ];
    }

    public function issnInvalidWithOptionsProvider()
    {
        return [
            ['2162321x', true],
        ];
    }

    public function luhnProvider()
    {
        return [
            ['42424242424242424242'],
            ['5610591081018250'],
            ['6011111111111117'],
            ['6011000990139424'],
            ['3530111333300000'],
            ['3566002020360505'],
            ['5555555555554444'],
            ['5105105105105100'],
            ['4111111111111111'],
            ['4012888888881881'],
            ['5019717010103742'],
            ['6331101999990016'],
            ['371449635398431'],
            ['378734493671000'],
            ['30569309025904'],
            ['38520000023237'],
            ['4222222222222'],
            ['79927398713'],
        ];
    }

    public function luhnInvalidProvider()
    {
        return [
            // Checksum failed error
            ['1234567812345678'],
            ['4222222222222222'],
            ['0000000000000000'],
            ['79927398710'],
            ['79927398711'],
            ['79927398712'],
            ['79927398714'],
            ['79927398715'],
            ['79927398716'],
            ['79927398717'],
            ['79927398718'],
            ['79927398719'],

            // Invalid characters error
            ['000000!000000000'],
            ['42-22222222222222'],
        ];
    }

    public function uuidProvider(): array
    {
        $hexMutations = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f'];

        $testValues = [];

        foreach ($hexMutations as $version) {
            foreach ($hexMutations as $variant) {
                $testValues[] = [
                    'value'    => "ff6f8cb0-c57d-{$version}1e1-{$variant}b21-0800200c9a66",
                    'expected' => true,
                ];
            }
        }

        return array_merge($testValues, [
            [
                'value'    => 'zf6f8cb0-c57d-11e1-9b21-0800200c9a66',
                'expected' => false,
            ],
            [
                'value'    => '3f6f8cb0-c57d-11e1-9b21-0800200c9a6',
                'expected' => false,
            ],
            [
                'value'    => 'af6f8cb-c57d-11e1-9b21-0800200c9a66',
                'expected' => false,
            ],
            [
                'value'    => 'af6f8cb0c57d11e19b210800200c9a66',
                'expected' => false,
            ],
            [
                'value'    => 'ff6f8cb0-c57da-51e1-9b21-0800200c9a66',
                'expected' => false,
            ],
            [
                'value'    => "ff6f8cb0-c57d-11e1-1b21-0800200c9a66\n",
                'expected' => false,
            ],
            [
                'value'    => "\nff6f8cb0-c57d-11e1-1b21-0800200c9a66",
                'expected' => false,
            ],
            [
                'value'    => "\nff6f8cb0-c57d-11e1-1b21-0800200c9a66\n",
                'expected' => false,
            ],
        ]);
    }
}
