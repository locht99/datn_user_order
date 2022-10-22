<?php
return [
    'config' => [
        'EXCHANGE_RATE' => 'EXCHANGE_RATE',
        'CHECKING_FEE' => 'CHECKING_FEE',
        'WOOD_FEE' => 'WOOD_FEE',
        'OWN_WOOD_FEE' => 'OWN_WOOD_FEE',
        'DEPOSIT_FEE' => 'DEPOSIT_FEE',
        'AUTO_DELIVERY_FEE' => 'AUTO_DELIVERY_FEE',
        'SAVINGS_DELIVERY_FEE' => 'SAVINGS_DELIVERY_FEE',
        'FAST_DELIVERY_FEE' => 'FAST_DELIVERY_FEE',
        'PURCHASE_FEE' => 'PURCHASE_FEE',
        'TRANSPORT_CN_VN_FEE' => 'TRANSPORT_CN_VN_FEE',
    ],
    'order_status' => [
        'deposited' => 1,
        'purchased' => 4,
        'shop_delivery' => 5,
        'received_warehouse' => 6,
        'transport' => 7,
        'wait_delivery' => 8,
        'wait_delivery_request' => 9,
        'delivering' => 10,
        'customers_received' => 11,
        'cancel' => 13,
        'lost' => 14,
    ],
    'price' => [
        'price_unit' => 3400,
    ],
    'type_transaction' => [
        'deposited' => 3,
        'pay' => 4
    ],
];