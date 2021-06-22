<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store()
    {
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        //return $request->file('file')- >store('public');

        $image =  $request->file('file')->store('public');

        $url = Storage::url($image); 

        return $url;

        Categoria::Create([
          //  'nombre' => $request->nombre,
            'image' =>  $url
            //'descripcion' => $request->descripcion
        ]);
    }
}
