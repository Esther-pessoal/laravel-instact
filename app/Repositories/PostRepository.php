<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository
{
    public function Model ()
    {
        return 'App\Models\Post';
    }   
}
