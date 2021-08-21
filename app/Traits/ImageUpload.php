<?php

namespace App\Traits;

trait ImageUpload
{
    public function ImageUpload($query)
    {
        $ext = strtolower($query->getClientOriginalExtension());
        $image = '/profile/images/' . time() . '.' . $ext;
        $query->move(public_path('profile/images'), $image);

        return $image;
    }
}
