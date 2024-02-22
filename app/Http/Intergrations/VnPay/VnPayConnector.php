<?php
// declare(strict_types=1);
 
// namespace App\Http\Integrations\VnPay;
 
// use Illuminate\Contracts\Foundation\Application;
// use Illuminate\Http\Client\PendingRequest;
// use Illuminate\Support\Facades\Http;
 
// final readonly class VnPayConnector
// {
//     public function __construct(
//         private PendingRequest $request,
//     ) {}
 
//     public static function register(Application $app): void
//     {
//         $app->bind(
//             abstract: VnPayConnector::class,
//             concrete: fn () => new VnPayConnector(
//                 request: Http::baseUrl(
//                     url: config('services.vnpay.vnp_Url'),
//                 )->timeout(
//                     seconds: 15,
//                 )->withHeaders(
//                     headers: [
                
//                 ],
//                 )->asJson()->acceptJson(),
//             ),
//         );
//     }
// }