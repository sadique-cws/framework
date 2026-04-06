<?php

namespace Illuminate\Support;

use Illuminate\Support\Facades\Storage;
use Stringable;

class Asset implements Stringable
{
    /**
     * The underlying path.
     *
     * @var string
     */
    protected $path;

    /**
     * The storage disk name.
     *
     * @var string|null
     */
    protected $disk;

    /**
     * Create a new Asset instance.
     *
     * @param  string  $path
     * @param  string|null  $disk
     */
    public function __construct($path = '', $disk = null)
    {
        $this->path = $path;
        $this->disk = $disk;
    }

    /**
     * Get the full URL for the asset.
     *
     * @return string
     */
    public function url()
    {
        if (is_null($this->disk)) {
            return asset($this->path);
        }

        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Get the raw path.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Dynamically access logical properties.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return match ($key) {
            'url' => $this->url(),
            'path' => $this->path(),
            default => null,
        };
    }

    /**
     * Determine if the asset is currently an empty string.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return trim((string) $this->path) === '';
    }

    /**
     * Determine if the asset is not an empty string.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return ! $this->isEmpty();
    }

    /**
     * Get the string representation of the asset (full URL).
     *
     * @return string
     */
    public function __toString()
    {
        return $this->url() ?: '';
    }
}
