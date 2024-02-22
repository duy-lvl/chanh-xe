<x-mail::message>
# Thông báo

Đơn hàng của bạn {{$statusVerb}} {{$locationName}}

ở địa chỉ {{$locationAddress}}
<br>

# Chi tiết đơn hàng
<x-mail::table>
|                           |                                                                                   |
| ------------------------- |-----------------------------------------------------------------------------------|
| Họ và tên người gửi       | {{$orderSenderName}}                                                              |
| Số điện thoại người gửi   | {{$orderSenderPhone}}                                                             |
| Email người gửi           | {{$orderSenderEmail}}                                                             |
| Họ và tên người nhận      | {{$orderReceiverName}}                                                            |
| Số điện thoại người nhận  | {{$orderReceiverPhone}}                                                           |
| Email người nhận          | {{$orderReceiverEmail}}                                                           |
| Ghi chú                   | {{$orderNote}}                                                                    |
| Giá trị đơn hàng          | {{"{$orderPackageValue} VNĐ"}}                                                    |
| Giá vận chuyển            | {{"{$orderPrice} VNĐ"}}                                                           |
| Cân nặng đơn hàng         | {{"{$orderPackageWeight} g"}}                                                     |
| Kích thước đơn hàng       | {{"{$orderPackageWidth}cm x {$orderPackageHeight}cm x {$orderPackageLength}cm "}} |
| Người thanh toán          | {{$orderCollectOnDelivery ? 'người nhận' : 'người gửi'}}                          |
</x-mail::table>

# Địa điểm gửi nhận:

Trạm gửi:<br>
    + Tên: {{$startStation->name}}<br>
    + Địa chỉ: {{$startStation->address}}<br>

Trạm nhận:<br>
    + Tên: {{$endStation->name}}<br>
    + Địa chỉ: {{$endStation->address}}<br>

<x-mail::button :url="$trackingUrl">
Theo dõi đơn hàng
</x-mail::button>

Cảm ơn quý khách đã tin tưởng dịch vụ của chúng tôi,<br>
{{ config('app.name') }}
</x-mail::message>
