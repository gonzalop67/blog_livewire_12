<?php

namespace App\Observers;

class PostObserver
{
    //creating ... antes de crear el registro
    //created ... despueés de crear el registro
    //updating ... antes de actualizar el registro
    public function updating($post)
    {
        if ($post->is_published && !$post->published_at) {
            $post->published_at = now();
        }
    }
    //updated ... después de actualizar el registro
    //deleting ... antes de eliminar el registro
    //deleted ... después de eliminar el registro
}
