<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class MediaLibraryPathGenerator implements PathGenerator
{
	/**
	 * Get the path for the given media, relative to the root storage path.
	 *
	 * @param \Spatie\MediaLibrary\Media $media
	 *
	 * @return string
	 */
	public function getPath(Media $media):string
	{
		return md5($media->id) . '/';
	}

	/**
	 * Get the path for conversions of the given media, relative to the root storage path.
	 *
	 * @param \Spatie\MediaLibrary\Media $media
	 *
	 * @return string
	 */
	public function getPathForConversions(Media $media):string
	{
		return md5($media->id). '/c/';
	}
}
