<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TimeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     * (Saat mengambil data dari DB)
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, $value, array $attributes)
    {
        // $value dari DB adalah '10:34:00'
        // Kita parse dan format jadi '10:34'
        return Carbon::parse($value)->format('H:i');
    }

    /**
     * Prepare the given value for storage.
     * (Saat menyimpan data ke DB)
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
