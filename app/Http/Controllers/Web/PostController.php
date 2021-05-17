<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Post;
use App\Models\PostCategory;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PostController extends AppBaseController
{
    /** @var  PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function getBlogLists()
    {
        $data = $this->postRepository->getBlogLists();
        
        return view('web.blogs.index')->with($data);
    }

    /**
     * @param  Post  $post
     *
     * @return Application|Factory|View
     */
    public function getBlogDetails(Post $post)
    {
        $data = $this->postRepository->getBlogDetails($post);

        return view('web.blogs.blogs_details')->with($data);
    }

    /**
     * @param  PostCategory  $postCategory
     *
     * @return Application|Factory|View
     */
    public function getBlogDetailsByCategory(PostCategory $postCategory)
    {
        $data = $this->postRepository->getBlogDetailsByCategory($postCategory);

        return view('web.blogs.blogs_based_on_category')->with($data);
    }
}
