<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    public function storeImage($file)
    {
        $this->addMedia($file)
            ->toMediaCollection('productos'); // Asegúrate de que coincida con el nombre de tu colección
    }

    public function images()
    {
        return $this->media('productos');
    }
}
