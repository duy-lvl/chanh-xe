<?php

declare(strict_types=1);

namespace App\Rules\Internal\Price;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

final class PriceCreation implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $this->validateDistanceContinuation($this->data['items'], $fail);

    }

    private function validateDistanceContinuation(array $items, Closure $fail): void
    {
        for ($i = 0; $i < count($items) - 1; $i++) {

            $thisToKilometer = $items[$i]['to_kilometer'];
            $nextFromKilometer = $items[$i + 1]['from_kilometer'];
            if (null === $thisToKilometer || null === $nextFromKilometer || $thisToKilometer !== $nextFromKilometer) {
                $fail("Item {$i}'s to_kilometer not match item " . ($i + 1) . "'s from_kilometer");
            }
        }
    }
}
