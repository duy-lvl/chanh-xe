<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use DateTimeImmutable;
use Domain\Shared\DataTransferObjects\LocationData;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class OrderDone extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private Order $order,
        private DateTimeImmutable $reachedtime,
        private LocationData $location
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Done',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $trackingUrl = config('services.customer_frontend.baseUrl') . '/' . config('services.customer_frontend.trackingOrderUrl') . '?' . Arr::query(['code' => $this->order->code]);

        $this->order->loadMissing(['startStation', 'endStation']);
        $dimensions = new Dimensions(
            $this->order->width,
            $this->order->height,
            $this->order->length,
            LengthUnit::Milimeter
        );
        $weight = new Weight($this->order->weight, MassUnit::Gram);
        return new Content(
            markdown: 'emails.orders.done',
            with: [
                'orderCode' => Str::upper($this->order->code),
                'orderSenderName' => $this->order->sender_name,
                'orderSenderPhone' => $this->order->sender_phone,
                'orderSenderEmail' => $this->order->sender_email,
                'orderReceiverName' => $this->order->receiver_name,
                'orderReceiverPhone' => $this->order->receiver_phone,
                'orderReceiverEmail' => $this->order->receiver_email,
                'orderNote' => $this->order->note,
                'orderPackageValue' => $this->order->package_value,
                'orderPrice' => $this->order->delivery_price,
                'orderPackageWeight' => $weight->convertValue(MassUnit::Gram),
                'orderPackageHeight' => $dimensions->convertHeight(LengthUnit::Centimeter),
                'orderPackageLength' => $dimensions->convertLength(LengthUnit::Centimeter),
                'orderPackageWidth' => $dimensions->convertWidth(LengthUnit::Centimeter),
                'orderCollectOnDelivery' => $this->order->collect_on_delivery,
                'orderPackageTypes' => $this->order->package_types,
                'orderPaymentMethod' => $this->order->payment_method,
                'locationName' => $this->location->name,
                'locationAddress' => $this->location->address,
                'trackingUrl' => $trackingUrl,
                'startStation' => $this->order->startStation,
                'endStation' => $this->order->endStation,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
