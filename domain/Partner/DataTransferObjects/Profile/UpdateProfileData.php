<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Profile;

use App\Models\Partner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

final readonly class UpdateProfileData
{
    /**
     * @param  null|Collection<string>  $phones
     */
    public function __construct(
        public string $name,
        public ?Collection $phones = null,
        public ?string $description = null,
    ) {
    }
}
