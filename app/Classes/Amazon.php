<?php
namespace App\Classes;

class Amazon
{
    private string $searchURL;
    private string $detailURL;
    private string $image_url_large;
    private string $image_url_medium;
    private string $image_url_small;
    private string $title;
    private int $price;

    public function set($key,$value):Amazon{
        $this->$key=$value;
        return $this;
    }

    function searchURL():String{
        return $this->searchURL;
    }
    function detailURL():String{
        return $this->detailURL;
    }
    function image_url_large():String{
        return $this->image_url_large;
    }
    function image_url_medium():String{
        return $this->image_url_medium;
    }

    function image_url_small():String{
        return $this->image_url_small;
    }
    public function title():String{
        return $this->title;
    }
    function price():int{
        return $this->price;
    }
}
