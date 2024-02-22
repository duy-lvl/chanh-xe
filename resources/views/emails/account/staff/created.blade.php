<x-mail::message>
# Tài khoản đã được tạo

Xin chào, {{$username}}

Tài khoản nhân viên của bạn đã được tạo với mật khẩu tự động là {{$newPassword}}.

Vui lòng tiến hành đổi lại mật khẩu tại trang web hệ thống để đảm bảo bảo mật.

<x-mail::button :url="config('services.partner_frontend.baseUrl')">
Truy cập hệ thống
</x-mail::button>

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
