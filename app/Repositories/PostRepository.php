<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCategory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PostCategoryRepository
 */
class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    public function store($input)
    {
        try {
            /** @var Post $post */
            $input['created_by'] = getLoggedInUserId();
            $blogInput = Arr::only($input, ['title', 'description', 'created_by']);
            $post = $this->create($blogInput);

            //update blog assign Categories
            if (isset($input['blogCategories']) && ! empty($input['blogCategories'])) {
                $post->postAssignCategories()->sync($input['blogCategories']);
            }

            if (isset($input['image']) && ! empty($input['image'])) {
                $post->addMedia($input['image'])->toMediaCollection(Post::PATH,
                    config('app.media_disc'));
            }

        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     * @param $blog
     *
     * @param $input
     *
     * @return bool
     */
    public function updateBlog($blog, $input)
    {
        try {
            /** @var Post $blog */
            $blog->update($input);

            //update blog assign Categories
            if (isset($input['blogCategories']) && ! empty($input['blogCategories'])) {
                $blog->postAssignCategories()->sync($input['blogCategories']);
            }

            if (isset($input['image']) && ! empty($input['image'])) {
                $blog->clearMediaCollection(Post::PATH);
                $blog->addMedia($input['image'])->toMediaCollection(Post::PATH,
                    config('app.media_disc'));
            }

        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     *
     * @return mixed
     */
    public function getBlogLists()
    {
        $data['blogs'] = Post::with('media', 'postAssignCategories', 'user')->orderByDesc('created_at')->get();
        $data['blogCategories'] = PostCategory::pluck('name', 'id');
        $data['popularBlogs'] = Post::with('media')->orderByDesc('created_at')->take(3)->get();

        return $data;
    }

    /**
     * @param $blog
     *
     * @return mixed
     */
    public function getBlogDetails($blog)
    {
        $data['blog'] = Post::with('media', 'postAssignCategories', 'user')->findOrFail($blog->id);
        $data['blogCategories'] = PostCategory::pluck('name', 'id');
        $data['popularBlogs'] = Post::with('media')->whereNotIn('id',
            [$blog->id])->orderByDesc('created_at')->take(3)->get();

        return $data;
    }

    /**
     * @param  PostCategory  $blogCategory
     *
     * @return mixed
     */
    public function getBlogDetailsByCategory($blogCategory)
    {
        $categoryId = $blogCategory->id;
        $data['blogs'] = Post::with('postAssignCategories', 'user', 'media')
            ->whereHas('postAssignCategories', function (Builder $q) use ($categoryId) {
                $q->where('post_categories_id', '=', $categoryId);
            })->get();
        $blogIds = $data['blogs']->pluck('id')->toArray();
        $data['blogCategories'] = PostCategory::pluck('name', 'id');
        $data['popularBlogs'] = Post::with('media')->whereNotIn('id',
            $blogIds)->orderByDesc('created_at')->take(3)->get();
        $data['categoryId'] = $categoryId;

        return $data;
    }
}
