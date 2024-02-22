<?php

declare(strict_types=1);

namespace Domain\Shared\Services;

use DateTimeInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class Image
{
    public function getFileTemporaryUrl(?string $storageUrl): ?string
    {
        if ($storageUrl === null) {
            return null;
        }

        $defaultTime = now()->addHours(24);

        return Cache::remember(
            key: $storageUrl,
            ttl: $defaultTime->subHours(6),
            callback: fn () => $this->getFromS3($storageUrl, $defaultTime)
        );
    }

    private function getFromS3(string $storageUrl, DateTimeInterface $expirationTime): ?string
    {
        try {
            $displayUrl = Storage::disk('s3')->exists($storageUrl) ? Storage::disk('s3')->temporaryUrl($storageUrl, $expirationTime) : null;
        } catch (Throwable $e) {
            $displayUrl = null;
            Log::error($e->getMessage());
        }
        return $displayUrl;
    }
}
