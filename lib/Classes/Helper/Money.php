<?php
/**
 * Part of the dsa blacksmith
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
namespace Helper;

/**
 * Helper class for the currencies.
 *
 * @package Helper
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */
class Money
{
    /**
     * The base currency (Kreuzer)
     *
     * @var string
     */
    protected $baseCurrency = 'K';

    /**
     * A list of currencies with the exchange rate to Kreuzer and the full name.
     *
     * @var array
     */
    protected $currencyList = array(
        'Db' => array(
            'name' => 'Dublone',
            'value' => 2000,
        ),
        'O' => array(
            'name' => 'Oreal',
            'value' => 100,
        ),
        'o' => array(
            'name' => 'Kleiner Oreal',
            'value' => 50,
        ),
        'Di' => array(
            'name' => 'Dirham',
            'value' => 1,
        ),
        'Ak' => array(
            'name' => 'Amazonenkrone',
            'value' => 1200,
        ),
        'B' => array(
            'name' => 'Batzen',
            'value' => 1000,
        ),
        'G' => array(
            'name' => 'Groschen',
            'value' => 100,
        ),
        'd' => array(
            'name' => 'Deut',
            'value' => 10,
        ),
        'Ho' => array(
            'name' => 'Kusliker Rad / Horasdor',
            'value' => 20000,
        ),
        'M' => array(
            'name' => 'Marawedi',
            'value' => 2000,
        ),
        'Z' => array(
            'name' => 'Zechine',
            'value' => 200,
        ),
        'm' => array(
            'name' => 'Muwlat',
            'value' => 5,
        ),
        'D' => array(
            'name' => 'Dukate',
            'value' => 1000,
        ),
        'S' => array(
            'name' => 'Silbertaler',
            'value' => 100,
        ),
        'H' => array(
            'name' => 'Heller',
            'value' => 10,
        ),
        'K' => array(
            'name' => 'Kreuzer',
            'value' => 1,
        ),
        'Su' => array(
            'name' => 'Suvar',
            'value' => 1000,
        ),
        'He' => array(
            'name' => 'Hedsch',
            'value' => 100,
        ),
        'Ch' => array(
            'name' => 'Ch\'ryskl',
            'value' => 10,
        ),
        'W' => array(
            'name' => 'Witten',
            'value' => 1000,
        ),
        'St' => array(
            'name' => 'Stüber',
            'value' => 100,
        ),
        'f' => array(
            'name' => 'Findrich',
            'value' => 10,
        ),
        'Zt' => array(
            'name' => 'Zwergentaler',
            'value' => 1200,
        ),
    );

    /**
     * Get the base currency.
     *
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * Get the list of currencies.
     *
     * @return array
     */
    public function getCurrencyList()
    {
        return $this->currencyList;
    }

    /**
     * Exchange the given value to the target currency
     *
     * @param integer $value   The value to exchange
     * @param string  $current The current currency
     * @param string  $target  The target currency
     *
     * @return integer|float
     */
    public function exchange($value, $current, $target = '')
    {
        $currency = $this->currencyList[$current];

        if (!$target)
        {
            return $currency['value'] * $value;
        }
        else
        {
            return floatval(($currency['value'] * $value) / $this->currencyList[$target]['value']);
        }
    }
}
