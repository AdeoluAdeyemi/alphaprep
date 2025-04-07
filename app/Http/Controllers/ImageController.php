<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Image', [
            'csrf_token' => csrf_token(),
        ]);
    }

    public function store(StoreImageRequest $request) : JsonResponse
    {
        // Check if request has a file
        if ($request->hasFile('upload')) {
            // Get the uploaded image from the request
            $image = $request->file('upload');

            // Retrieve the validated input data...
            // Validate the image for acceptable image formats and max upload size(Max upto 2MB)
            //If it's valid, it will proceed. If it's not valid, throws a ValidationException.
            $validatedData = $request->validated();

            // Validate the image for acceptable image formats and max upload size(Max upto 5MB)
            // $this->validate($request, [
            //     'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
            // ]);

            // Generate a unique filename for the uploaded image
            $timestamp = time();
            $imageName= $timestamp.'.'.$image->getClientOriginalExtension();

            // Saving original image to azure container
            $disk = Storage::disk('azure');
            $disk->put($imageName,file_get_contents($image));
            //$url = Storage::disk('azure')->url($imageName);
            $url = env('AZURE_BLOB_PATH').$imageName;
            Log::info('Image URL'.$url);
            //AZURE_STORAGE_URL

            // Creating Multiple Image Copies of different sizes and saving to Azure blob container
            //$sizes = ['240x100', '300x200', '900x300'];
            //$this->resizeAndSaveToAzureBlob($image,$sizes,$imageName);
        }

        //Send the user back to the upload page with success message and image URL in session

        return response()->json(['fileName' => $imageName, 'uploaded' => 1, 'url' => $url]);
        //return back()->with('success','Image has successfully uploaded.');
    }

    public function uploadImage(Request $request, string $requestFileName)
    {
        $image_path = '';
        $image_name = '';

        if ($request->hasFile($requestFileName)) {
            $originName = $request->file($requestFileName)->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            Log::info('filename is: '.$fileName);

            $extension = $request->file($requestFileName)->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            Log::info('filename again is: '.$fileName);

            $image_name = $fileName;

            // Saving original image to azure container
            $disk = Storage::disk('azure');
            $disk->put($image_name,file_get_contents($request->file($requestFileName)));

            //$image_path = $request->file('image')->store('images', 'public');
            //$image_path = $request->file($requestFileName)->move(public_path('images'), $fileName);

        }
        return $image_name;
    }

    function resizeAndSaveToAzureBlob($file, $sizes, $imgName)
    {
        foreach ($sizes as $size) {
            [$width, $height] = explode('x', $size);

            $sourceImage = imagecreatefromstring(file_get_contents($file));

            // Get the original image dimensions
            $sourceWidth = imagesx($sourceImage);
            $sourceHeight = imagesy($sourceImage);

            // Calculate the aspect ratios of both images
            $sourceAspectRatio = $sourceWidth / $sourceHeight;
            $targetAspectRatio = $width / $height;

            // Calculate the new dimensions for the resized image
            if ($sourceAspectRatio > $targetAspectRatio) {
                $resizeWidth = $width;
                $resizeHeight = $width / $sourceAspectRatio;
            } else {
                $resizeHeight = $height;
                $resizeWidth = $height * $sourceAspectRatio;
            }

            // Creating white background
            $targetImage = imagecreatetruecolor($width, $height);
            $whiteColor = imagecolorallocate($targetImage, 255, 255, 255);
            imagefill($targetImage, 0, 0, $whiteColor);

            // Calculate the center position for the resized image on the new background
            $centerX = ($width - $resizeWidth) / 2;
            $centerY = ($height - $resizeHeight) / 2;
            // Resize the source image to the calculated dimensions
            imagecopyresampled(
                $targetImage,
                $sourceImage,
                $centerX,
                $centerY,
                0,
                0,
                $resizeWidth,
                $resizeHeight,
                $sourceWidth,
                $sourceHeight
            );
            $outputImagePath = 'resized_image.png';
            imagepng($targetImage, $outputImagePath);

            // Generate a unique filename for the resized image
            $resizedFilename = $width . 'x' . $height . $imgName;

            // Save the resized image to Azure Blob Storage
            Storage::disk('azure')->put($resizedFilename, file_get_contents($outputImagePath));
        }
    }

}
