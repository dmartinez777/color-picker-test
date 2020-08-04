<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    protected $fillable = ['red', 'green', 'blue'];

    protected $appends = ['hex'];

    public function getHexAttribute() {
        return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
    }
}
