<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Collection;

trait AddMedia
{
    /**
     * Attach a single file to a collection (for singleFile collections or normal ones).
     *
     * @param string|\Illuminate\Http\UploadedFile $fileOrField request field name or UploadedFile
     * @param string $collection
     * @return Media
     * @throws \RuntimeException
     */
    public function attachSingleTo(string $collection, $fileOrField): Media
    {
        // get file
        $file = is_string($fileOrField) ? request()->file($fileOrField) : $fileOrField;

        if (!$file) {
            throw new \RuntimeException("No file provided for collection [{$collection}].");
        }

        // prefer model helper if exists
        if (method_exists($this, 'addMediaToCollection')) {
            return $this->addMediaToCollection($file, $collection);
        }

        if (method_exists($this, 'addMediaFromRequest') && is_string($fileOrField)) {
            return $this->addMediaFromRequest($fileOrField)->toMediaCollection($collection);
        }

        // fallback generic
        return $this->addMedia($file)->toMediaCollection($collection);
    }

    /**
     * Attach multiple files to a collection.
     *
     * @param string|array $filesOrField request field name or array of UploadedFile
     * @param string $collection
     * @return Collection (of Media)
     */
    public function attachMultipleTo(string $collection, $filesOrField): Collection
    {
        if (is_string($filesOrField)) {
            $files = request()->file($filesOrField) ?? [];
        } else {
            $files = is_array($filesOrField) ? $filesOrField : [$filesOrField];
        }

        // prefer bulk helper
        if (method_exists($this, 'addMultipleMediaToCollection')) {
            return $this->addMultipleMediaToCollection($files, $collection);
        }

        $added = collect();
        foreach ($files as $file) {
            if (!$file) {
                continue;
            }
            $added->push($this->attachSingleTo($collection, $file));
        }

        return $added;
    }

    /**
     * Return first media url (or null) for a collection, using conversion if provided.
     *
     * @param string $collection
     * @param string|null $conversion
     * @return string|null
     */
    public function mainMediaUrl(string $collection = 'main_image', ?string $conversion = null): ?string
    {
        if (method_exists($this, 'getFirstMediaUrlForCollection')) {
            return $this->getFirstMediaUrlForCollection($collection, $conversion);
        }

        $url = $this->getFirstMediaUrl($collection, $conversion ?: '');
        return $url === '' ? null : $url;
    }

    /**
     * Return collection media data as array ready for API output.
     *
     * @param string $collection
     * @param string|null $conversion
     * @return array
     */
    public function mediaCollectionData(string $collection, ?string $conversion = null): array
    {
        if (method_exists($this, 'getCollectionMediaData')) {
            return $this->getCollectionMediaData($collection, $conversion);
        }

        $medias = $this->getMedia($collection);

        return $medias->map(function (Media $m) use ($conversion) {
            return [
                'id' => $m->id,
                'file_name' => $m->file_name,
                'size' => $m->size,
                'mime_type' => $m->mime_type,
                'original' => $m->getUrl(),
                'url' => $conversion ? $m->getUrl($conversion) : $m->getUrl(),
                'order' => $m->order_column ?? null,
            ];
        })->toArray();
    }

    /**
     * Delete media by id if it belongs to this model.
     *
     * @param int $mediaId
     * @return bool
     */
    public function deleteMedia(int $mediaId): bool
    {
        if (method_exists($this, 'removeMediaById')) {
            return $this->removeMediaById($mediaId);
        }

        $media = $this->media()->where('id', $mediaId)->first();
        if (!$media) {
            return false;
        }

        return (bool) $media->delete();
    }
}
