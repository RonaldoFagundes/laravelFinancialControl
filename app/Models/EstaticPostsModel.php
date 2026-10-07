<?php

namespace App\Models;


class EstaticPostsModel
{



  public static function getPosts()
  {
    
   $posts =
    [
        "id"    => 1,
        "date"  =>"2026-05-31",
        "type"  =>"online",
        "flag"  =>"Visa",
        "price" =>37.45
   ];

    return $posts;

  }




}