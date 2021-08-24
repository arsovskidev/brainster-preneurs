<?php

namespace App\Traits;

trait ImageUpload
{
    public function ImageUpload($query)
    {
        $ext = strtolower($query->getClientOriginalExtension());
        $image = '/users/images/' . time() . '.' . $ext;
        $query->move(public_path('users/images'), $image);

        return $image;
    }
}
