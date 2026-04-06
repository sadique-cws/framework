<?php

namespace Illuminate\Database\Eloquent\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Asset;

class AsAsset implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return \Illuminate\Contracts\Database\Eloquent\CastsAttributes<\Illuminate\Support\Asset, string|Asset>
     */
    public static function castUsing(array $arguments)
    {
        return new class($arguments) implements CastsAttributes
        {
            /**
             * The storage disk name.
             *
             * @var string|null
             */
            protected $disk;

            /**
             * Create a new caster instance.
             *
             * @param  array  $arguments
             */
            public function __construct(array $arguments)
            {
                $this->disk = $arguments[0] ?? null;
            }

            public function get($model, $key, $value, $attributes)
            {
                return isset($value) ? new Asset($value, $this->disk) : null;
            }

            public function set($model, $key, $value, $attributes)
            {
                return isset($value) ? (string) $value : null;
            }
        };
    }
}
