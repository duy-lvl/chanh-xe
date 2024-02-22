<?php

return [
    'account' => [
        'sameStatus' => 'Status is unchanged',
        'updateFailed' => 'Update failed',
        'inactive' => 'Inactive Account',
    ],

    'driver' => [
        'deleteFail' => 'Delete driver failed',
        'updateFail' => 'Update driver failed',
        'unauthorized' => 'You dont have the right to access.',
        'createFail' => 'Create driver failed.',
    ],

    'order' => [
        'orderNotFound' => 'Order with code :value not found',
        'invalidStatus' => 'Invalid status',
        'unauthorized' => 'You have no access to this order',
        'notPaid' => 'This order has not been paid yet',
        'updateStatusFailed' => 'Update status failed',
        'confirmFailed' => 'Order confirm failed',
        'confirmed' => 'This order has been confirmed',
        'notConfirmed' => 'This order has not been confirmed',
        'cancelled' => 'This order has been cancelled',
        'missingIdentifier' => 'You need to provide phone or email address',
        'updateFailed' => 'Update Failed',
        'unsupportedPaymentMethod' => 'Unsupported Payment Method',
        'lost' => 'This order is lost',
        'orderNotAtHub' => 'This order is not at hub',
        'updateCheckpointFailed' => 'Checkpoint updated fail',
        'driverNotBelongToPartner' => 'Driver not belong to partner',
        'vehicleNotBelongToPartner' => 'Vehicle not belong to partner',
        'receiveTokenNotMatch' => 'Receive Token not match',
    ],

    'payment' => [
        'paid' => 'This order had been paid',
        'orderNotFound' => 'Order not found',
        'invalidSignature' => 'Invalid signature',
        'invalidAmount' => 'Invalid amount',
        'transactionFailed' => 'Transaction failed',
        'paymentMethodConflicted' => 'Conflict payment method',
        'invalidOrderStatus' => 'Invalid order status',
        'orderNotConfirmed' => 'This order has not been confirmed',
        'orderCancelled' => 'This order has been cancelled',
    ],

    'priceCalculation' => [
        'unavailable' => 'No available price for this package',
    ],

    'profile' => [
        'updateFailed' => 'Update profile failed',
        'phoneNumberExisted' => 'Phone number already exists',
        'emailExisted' => 'Email already exists',
    ],

    'searchRoute' => [
        'noRoute' => 'No routes found',
        'noStation' => 'There are no stations near your location',
    ],

    'station' => [
        'approved' => 'This station has been approved',
    ],

    'transaction' => [
        'insufficentBalance' => 'Insufficent balance',
        'proceeded' => 'Transaction has been proceeded',
        'unauthorized' => 'You are not authorized to proceed this request',
    ],

    
];
