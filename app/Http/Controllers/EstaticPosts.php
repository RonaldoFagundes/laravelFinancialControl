<?php

namespace App\Http\Controllers;


use App\Models\EstaticPostsModel;


class EstaticPosts
{

 public function showPosts()
 {
   
   $posts = EstaticPostsModel::getPosts();
   dd($posts);
  
 }



}