<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store (array $input, UploadedFile $photo)
    {
        DB::beginTransaction();

        try {

            $path = $photo->store('public/images');
            $url = Storage::url($path);

            $post = $this->repository->create([
                'image' => $url,
                'description' => $input['description'],
                'user_id' => $input['user_id'],
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th);
            return [
                'success' => false,
                'message' => 'Erro ao gravar o post'
            ];
        }

        DB::commit();
        return [
            'success' => true,
            'message' => 'Post criado com sucesso',
            'data' => $post
        ];
    }
}
