<?php

return [
    'account' => [
        'sameStatus' => 'Trạng thái không bị thay đổi',
        'updateFailed' => 'Cập nhật trạng thái thất bại',
        'inactive' => 'Tài khoản bị khóa.',
    ],

    'driver' => [
        'deleteFail' => 'Xoá tài xế thất bại',
        'updateFail' => 'Cập nhật thông tin thất bại',
        'unauthorized' => 'Tài xế không thuộc quyền quản lí của bạn.',
        'createFail' => 'Tạo tài xế thất bại',
    ],

    'order' => [
        'notFound' => 'Đơn hàng với code :value không tồn tại',
        'invalidStatus' => 'Trạng thái không hợp lệ',
        'unauthorized' => 'Bạn không có quyền tương tác với đơn hàng này',
        'notPaid' => 'Đơn hàng này chưa được thanh toán',
        'updateStatusFailed' => 'Cập nhật trạng thái thất bại',
        'confirmFailed' => 'Xác nhận đơn hàng thất bại',
        'confirmed' => 'Đơn hàng này đã được xác nhận',
        'notConfirmed' => 'Đơn hàng này chưa được xác nhận',
        'cancelled' => 'Đơn hàng này đã bị hủy',
        'missingIdentifier' => 'Cần phải có SĐT hoặc địa chỉ email',
        'updateFailed' => 'Cập nhật đơn hàng thất bại',
        'unsupportedPaymentMethod' => 'Phương thức thanh toán không hợp lệ',
        'lost' => 'Đơn hàng đã bị mất',
        'orderNotAtHub' => 'Đơn hàng đang không ở hub',
        'updateCheckpointFailed' => 'Cập nhật thông tin thất bại',
        'driverNotBelongToPartner' => 'Tài xế không thuộc quyền quản lí của chành',
        'vehicleNotBelongToPartner' => 'Phương tiện không thuộc quyền quản lí của chành',
        'receiveTokenNotMatch' => 'Mã giao hàng không đúng',
    ],

    'payment' => [
        'paid' => 'Đơn hàng này chưa được thanh toán',
        'orderNotFound' => 'Đơn hàng này không tồn tại',
        'invalidSignature' => 'Chữ ký không hợp lệ',
        'invalidAmount' => 'Giá trị không hợp lệ',
        'transactionFailed' => 'Giao dịch thất bại',
        'paymentMethodConflicted' => 'Phương thức thanh toán không đúng',
        'invalidOrderStatus' => 'Trạng thái đơn hàng không hợp lệ',
        'orderNotConfirmed' => 'Đơn hàng này chưa dược xác nhận',
        'orderCancelled' => 'Đơn hàng này đã bị hủy',
    ],

    'priceCalculation' => [
        'unavailable' => 'Kiện hàng nằm ngoài bảng giá',
    ],

    'profile' => [
        'updateFailed' => 'Cập nhật thất bại',
        'phoneNumberExisted' => 'Số điện thoại này đã tồn tại',
        'emailExisted' => 'Email này đã tồn tại',
    ],

    'searchRoute' => [
        'noRoute' => 'Không có tuyến đường nào được tìm thấy',
        'noStation' => 'Không có trạm nào gần vị trí của bạn',
    ],

    'station' => [
        'approved' => 'Trạm dừng này đã được phê duyệt',
    ],

    'transaction' => [
        'insufficentBalance' => 'Số dư không khả dụng',
        'proceeded' => 'Đề nghị giao dịch đã được xử lý',
        'unauthorized' => 'Bạn không có quyền xử lý đề nghị giao dịch này',
    ],
];
