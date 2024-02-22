<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Enums;

enum OrderStatus: int
{
    case Created = 0;
    
    case Accepted = 1;
    case Delivering = 2;
    case Delivered = 3;
    case Done = 4;
    case Cancelled = 5;

    case Confirmed = 6;
    public static function getVerb(OrderStatus $status): string
    {
        //TODO: localization
        return match ($status) {
            self::Created => 'đã được tạo',
            self::Accepted => 'đã được nhận tại',
            self::Delivering => 'đã xuất phát khỏi',
            self::Delivered => 'đã đến',
            self::Done => 'đã đến tay người nhận',
            self::Cancelled => 'đã bị hủy',
        };
    }
}
