<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;

trait HasMediaCollections
{

    protected array $mediaCollections = [];

    protected array $mediaConversions = [];


    protected function defaultMediaDisk(): string
    {
        return config('medialibrary.disk_name') ?? config('filesystems.default', 'public');
    }


    public function registerMediaCollections(): void
    {
        foreach ($this->mediaCollections as $name => $opts) {
            $opts = is_array($opts) ? $opts : [];

            $disk = $opts['disk'] ?? $this->defaultMediaDisk();

            $collection = $this->addMediaCollection($name)->useDisk($disk);

            if (!empty($opts['single']) || (!empty($opts['single_file']) && $opts['single_file'] === true)) {
                $collection->singleFile();
            }

        }
    }


    public function registerMediaConversions(Media $media = null): void
    {
        foreach ($this->mediaConversions as $conv) {
            if (empty($conv['name'])) {
                continue;
            }

            $conversion = $this->addMediaConversion($conv['name']);

            if (!empty($conv['width'])) {
                $conversion->width((int) $conv['width']);
            }
            if (!empty($conv['height'])) {
                $conversion->height((int) $conv['height']);
            }
            if (!empty($conv['format'])) {
                $conversion->format($conv['format']);
            }
            if (!empty($conv['sharpen'])) {
                $conversion->sharpen((int) $conv['sharpen']);
            }
            if (!empty($conv['nonQueued'])) {
                $conversion->nonQueued();
            } elseif (isset($conv['queued']) && $conv['queued'] === false) {
                $conversion->nonQueued();
            }
            // apply to collections
            $collections = $conv['collections'] ?? [];
            if (!empty($collections)) {
                $conversion->performOnCollections(...$collections);
            }
        }
    }

    /* -------------------------
       Helper methods
       ------------------------- */

    /**
     * Add an uploaded file (or UploadedFile instance) to a specific collection.
     *
     * @param UploadedFile|string $fileOrRequestField If string -> treated as request field name.
     * @param string $collection
     * @return Media
     *
     * @throws \RuntimeException when collection limit exceeded or invalid
     */
    public function addMediaToCollection($fileOrRequestField, string $collection): Media
    {
        if (!array_key_exists($collection, $this->mediaCollections)) {
            throw new \RuntimeException("Media collection [{$collection}] is not defined on model.");
        }

        $opts = $this->mediaCollections[$collection];
        $disk = $opts['disk'] ?? $this->defaultMediaDisk();

        // get UploadedFile
        if (is_string($fileOrRequestField)) {
            $file = request()->file($fileOrRequestField);
        } else {
            $file = $fileOrRequestField;
        }

        if (!$file) {
            throw new \RuntimeException("No file provided for collection [{$collection}].");
        }

        // enforce limit if exists
        if (!empty($opts['limit'])) {
            $existing = $this->getMedia($collection)->count();
            if ($existing + 1 > (int) $opts['limit']) {
                throw new \RuntimeException("Collection [{$collection}] limit ({$opts['limit']}) exceeded.");
            }
        }

        return $this->addMedia($file)->toMediaCollection($collection, $disk);
    }

    /**
     * Add multiple files (array or request field) to a collection.
     *
     * @param array|string $filesOrRequestField
     * @param string $collection
     * @return Collection  (of Media)
     */
    public function addMultipleMediaToCollection($filesOrRequestField, string $collection): Collection
    {
        if (is_string($filesOrRequestField)) {
            $files = request()->file($filesOrRequestField) ?? [];
        } else {
            $files = $filesOrRequestField instanceof Collection ? $filesOrRequestField->toArray() : (array) $filesOrRequestField;
        }

        $added = collect();

        foreach ($files as $file) {
            $added->push($this->addMediaToCollection($file, $collection));
        }

        return $added;
    }

    /**
     * Get array of URLs / metadata for a collection.
     *
     * @param string $collection
     * @param string|null $conversion
     * @return array
     */
    public function getCollectionMediaData(string $collection, ?string $conversion = null): array
    {
        $medias = $this->getMedia($collection);

        return $medias->map(function (Media $m) use ($conversion) {
            return [
                'id' => $m->id,
                'file_name' => $m->file_name,
                'mime_type' => $m->mime_type,
                'size' => $m->size,
                'order' => $m->order_column ?? null,
                'original_url' => $m->getUrl(),
                'url' => $conversion ? $m->getUrl($conversion) : $m->getUrl(),
            ];
        })->toArray();
    }

    /**
     * Get first media url for collection (or null)
     *
     * @param string $collection
     * @param string|null $conversion
     * @return string|null
     */
    public function getFirstMediaUrlForCollection(string $collection, ?string $conversion = null): ?string
    {
        $url = $this->getFirstMediaUrl($collection, $conversion ?: '');
        return $url === '' ? null : $url;
    }

    /**
     * Remove media by id if it belongs to this model.
     *
     * @param int $mediaId
     * @return bool
     */
    public function removeMediaById(int $mediaId): bool
    {
        $media = $this->media()->where('id', $mediaId)->first();

        if (!$media) {
            return false;
        }

        return (bool) $media->delete();
    }
}
