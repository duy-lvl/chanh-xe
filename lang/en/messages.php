<?php

return [
    'transaction' => [
        'collectionOnBehalf' => 'Collection on behalf fee of order :orderCode',
        'lostOrderPunishment' => 'Punishment for losing order :orderCode',
        'requestApproved' => 'Approval of transfer request number :id',
        'revenueAdded' => 'Your revenue for order :orderCode',
    ],
    'partner_driver' => [
        'created' => 'Driver has been created',
        'deleted' => 'Driver has been deleted',
        'updated' => 'Driver has been updated',
    ],
    'partner_vehicle' => [
        'created' => 'Vehicle has been created',
        'deleted' => 'Vehicle has been deleted',
        'updated' => 'Vehicle has been updated',
    ],
    'notification' => [
        'header' => [
            'orderAccepted' => 'Order accepted',
            'orderDelivering' => 'Order delivering',
            'orderDelivered' => 'Order delivered',
            'orderDone' => 'Order done',
        ],
        'content' => [
            'orderCreated' => 'Your order has been created',
            'orderAccepted' => 'Your order has been accepted',
            'orderDelivering' => 'Your order has been delivering',
            'orderDelivered' => 'Your order has been delivered',
            'orderDone' => 'Your order has been done',
            'orderCancelled' => 'Your order has been cancelled',
        ]
    ]
];
