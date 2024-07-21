<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

/**
 * Delete the specified image if it exists.
 *
 * @param  string  $imageName The name of the image to delete.
 * @return void
 */
function deleteImage($imageName)
{
    if (File::exists(public_path('images/' . $imageName))) {
        File::delete(public_path('images/' . $imageName));
    }
}

/**
 * Store the image in the public/images directory.
 *
 * @param  \Illuminate\Http\UploadedFile  $imageFile The uploaded file instance.
 * @return string The generated name of the stored image.
 */
function storeImage($imageFile)
{
    // Generate a unique name for the image
    $mainImageName = Str::random(25) . '_' . time() . '.' . $imageFile->getClientOriginalExtension();

    // Move the uploaded file to the public/images directory
    $imageFile->move(public_path('images'), $mainImageName);

    // Return the generated image name
    return $mainImageName;
}
