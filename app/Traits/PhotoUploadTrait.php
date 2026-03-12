<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

trait PhotoUploadTrait
{
    /**
     * Upload and delete old photo for any model.
     *
     * @param  \Illuminate\Http\Request|\Illuminate\Http\UploadedFile  $request
     * @param  mixed  $model
     * @param  string  $photoColumn
     * @param  string  $folder
     * @return void
     */
    public function uploadPhoto($request, $model, $photoColumn = 'photo', $folder = 'other', $column = null)
    {
        // Handle if $request is an UploadedFile directly
        $file = $request instanceof UploadedFile ? $request : null;

        // Handle if $request is a Request object
        if (!$file && $request->hasFile($photoColumn)) {
            $file = $request->file($photoColumn);
        }

        if ($file) {
            // Store the new photo
            $filename = $file->hashName();
            $path = $file->storeAs('uploads/' . $folder . '/' . $model->id . ($column ? '/' . $column : ''), $filename, 'public');

            // Handle gallery_images (array) vs single photo (string)
            if ($photoColumn === 'gallery_images' || is_array($model->{$photoColumn})) {
                // Add to existing array
                $existing = $model->{$photoColumn} ?? [];
                if (is_string($existing)) {
                    $existing = json_decode($existing, true) ?? [];
                }
                // Clean empty arrays and ensure we only have strings
                $existing = array_filter($existing, function ($item) {
                    return is_string($item) && !empty($item);
                });
                $existing[] = $path;
                $model->{$photoColumn} = array_values($existing);
            } else {
                // Delete the old photo if exists (single photo)
                if ($model->{$photoColumn} && is_string($model->{$photoColumn})) {
                    Storage::disk('public')->delete($model->{$photoColumn});
                }
                // Update with new photo path
                $model->{$photoColumn} = $path;
            }

            $model->save();
        }
    }

    public function deletePhoto($model, $photoColumn = 'photo')
    {
        // Check if the photo exists before attempting to delete it
        if (!empty($model->{$photoColumn})) {
            // Delete the photo
            Storage::disk($model->disk ?? 'public')->delete($model->{$photoColumn});

            // Delete the folder if it's empty
            $folderPath = dirname($model->{$photoColumn});
            if (Storage::disk('public')->exists('uploads/' . $folderPath) && count(Storage::disk('public')->files('uploads/' . $folderPath)) == 0) {
                Storage::disk('public')->deleteDirectory('uploads/' . $folderPath);
            }
        }
    }


    public function deleteMedia($model, $collection)
    {
        $model->media()->where('collection_name', $collection)->get()->each(function ($media) {
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        });
    }

    public function uploadSinglePhoto(Request $request, Model $model, string $column = 'photo', string $folder = 'other', string $option = null)
    {
        if (!$request->hasFile($column)) {
            return;
        }
        // Store old photo path BEFORE any updates
        $oldPhoto = $model->{$column};

        // Upload new photo
        $path = $request->file($column)->store("uploads/{$folder}/{$model->id}/" . ($option ? $option . '/' : ''), 'public');

        // Update model with new path
        $model->update([$column => $path]);

        // Delete old photo AFTER successful update
        if (!empty($oldPhoto)) {
            if (Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            // Delete the folder if empty
            $folderPath = "uploads/{$folder}/{$model->id}/" . ($option ? $option . '/' : '');
            if (Storage::disk('public')->exists($folderPath)) {
                $files = Storage::disk('public')->files($folderPath);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($folderPath);
                }
            }
        }
    }

    public function uploadFiles($request, Model $model, string $column = 'files', string $folder = 'other')
    {
        $filesToUpload = [];

        // Check if $request is an UploadedFile directly
        if ($request instanceof UploadedFile) {
            if (!$request) {
                throw new \Exception("File object is empty");
            }
            $filesToUpload[] = $request;
        }
        // Check if $request is a Request object
        elseif ($request instanceof Request) {
            if (!$request->hasFile($column)) {
                throw new \Exception("No files found in the '{$column}' field");
            }
            $filesToUpload = $request->file($column);
        } else {
            throw new \Exception("Invalid request parameter. Expected Request or UploadedFile");
        }

        $files = $model->{$column} ?? [];
        foreach ($filesToUpload as $file) {
            $files[] = $file->store("uploads/{$folder}/{$model->id}/{$column}", 'public');
        }
        $model->update([$column => array_values($files)]);
    }

    public function deleteFiles(Model $model, array $indexes, string $column = 'files')
    {
        $files = $model->{$column} ?? [];
        foreach ($indexes as $index) {
            if (!isset($files[$index])) continue;
            Storage::disk('public')->delete($files[$index]);
            unset($files[$index]);
        }
        $model->update([$column => array_values($files)]);
    }
}
