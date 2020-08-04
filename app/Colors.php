<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Colors
 *
 * @package App
 */
class Colors extends Model
{
    protected $fillable = ['red', 'green', 'blue'];

    protected $appends = ['hex', 'rgb'];

    /**
     * @return string
     */
    public function getHexAttribute()
    {
        return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue);
    }

    /**
     * @return array[]
     */
    public function getRGBAttribute()
    {
        return ['red' => $this->red, 'green'=> $this->green, 'blue' => $this->blue];
    }
}
