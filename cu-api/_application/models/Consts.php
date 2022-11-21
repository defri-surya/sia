<?php

/**
 * Consts class for constants
 * @author Yuana <andhikayuana@gmail.com>
 * @since October, 4 2016
 */
class Consts {
    
    /**
     * @var const type per feature
     */
    const TYPE_EVOUCHER  = 1;
    const TYPE_HOTPROMO  = 2;
    const TYPE_LELANG    = 3;
    const TYPE_HOTDEALS  = 4;
    const TYPE_LUCKYDRAW = 5;
    const BASE_URL = 'https://lakupay.id/';
    const USERNAME = 'adminfdv';
    const PASSWORD = 'digitalmind12345';
    const MEMBER_SOURCE = 'superpromo.id';

    /**
     * [$titleFeatures]
     * @var array title/label features
     */
    public static $titleFeatures = array(
        self::TYPE_EVOUCHER     => 'E-Voucher',
        self::TYPE_HOTPROMO     => 'Hot Promo',
        self::TYPE_LELANG       => 'Lelang',
        self::TYPE_HOTDEALS     => 'Hot Deals',
        self::TYPE_LUCKYDRAW    => 'Lucky Draw'
    );

    /**
     * @var String args token
     */
    const ARG_TOKEN = 'Token';


    /**
     * @var APP_NAME
     */
    const APP_NAME = 'superpromo';

    /**
     * [$msgByCode]
     * @var array msg by code
     */
    public static $msgByCode = array(
        200 => 'OK',
        201 => 'Created',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        409 => 'Conflict',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
    );

}
