<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;

use libphonenumber\PhoneNumberUtil;
use Illuminate\Support\Facades\Log;

Trait GeneralTrait
{

    public function upload_file($file,$model)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() .'.'.$extension;
        Storage::disk('public')->put($filename, $model);
        $path = $file->move('storage/'.$model.'/', $filename);
        return $path;
    }



    public function upload($requestAttributeName = null, $folder = '', $disk = 'public')
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid())
        {
            $path = 'storage/'.request()->file($requestAttributeName)->store($folder, $disk);
        }
        return $path;
    }

    public function updateFile($requestAttributeName = null, $folder = '',$oldPath)
    {
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid())
        {
            $path = $this->upload($requestAttributeName,$folder);
            if(file_exists($oldPath))
            {
                unlink($oldPath);
            }
        }
        return $path;
    }

    public function deleteFile($oldPath)
    {
        if(file_exists($oldPath))
        {
            unlink($oldPath);
        }
    }

    public function handle($requestAttributeName, $folderName, $target = null)
    {
        $path = $this->upload($requestAttributeName, $folderName);
        if (!is_null($target))
        {
            $this->deleteFile($target);
        }
        return $path;
    }

    

        public function handleIsActive($request)
        {
            return $request->is_active ? 1 : 0;
        }


}

?>
