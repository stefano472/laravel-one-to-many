<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Post extends Model
{
    //
    protected $guarded = [];
    // posso definire i campi che andró a fillare col form, con il guarded 
    // ed in quel caso li prende tutti oppure con il 
    // fillable vado a specificare solo quelli di interesse

    // protected $fillable = ['title', 'content', 'slug', 'category_id'];

    // utilizzo funzione public non static xk dovró richiamarla solo 
    // nell'istanza (ovvero quando avró giá creato la classe category
    // che qua per ora é solo definita
    public function category(){
        return $this->belongsTo('App\Category');
    }

    // in questo caso utilizzo funz static perché volendo la potrei richiamare
    // anche se non ho giá creato la classe
    public static function convertToSlug($title) {
        $slugPrefix = Str::slug($title);
        $slug = $slugPrefix;

        $postFound = Post::where('slug', $slug)->first();
        $counter = 1;
        while($postFound){
            $slug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $slug)->first();
        }

        return $slug;
    }
}
