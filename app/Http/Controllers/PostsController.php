<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{
    /**
     * Get all posts
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Get all enabled posts
        $posts = Posts::where('enabled', -1)->get();
        return response()->json($posts);
    }

    /**
     * Get specific post
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $post = Posts::find($id);

        // check of post exists and return or else return error message
        if (empty($post)) {
            return response()->json(['message' => '404 - Post not found'], 404);
        } else {
            return response()->json($post);
        }
    }

    /**
     * Store a new post
     * 
     * @param PostsRequest $request
     * @return JsonResponse
     */
    public function store(PostsRequest $request): JsonResponse
    {
        $slug = strtolower(str_replace(' ', '-', $request->title));

        // Check if slug is valid, other rules are checked in PostsRequest
        // Slug can't be checked there because it is dynamically populated by title
        if (!preg_match('/^[a-z0-9-_]+$/', $slug)) {
            return response()->json(['message' => 'Slug is invalid. Can only contains a-z, 0-9 or _'], 422);
        }

        // Add new Posts model
        $post = new Posts;
        $post->slug = $slug;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->enabled = $request->enabled;
        $post->save();

        return response()->json(["message" => "201 - Post added"], 201);
    }

    /**
     * Update an existing post
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Find post and then update it or else show error message
        if (Posts::where('id', $id)->exists()) {
            if ($request->title) {
                $slug = strtolower(str_replace(' ', '-', $request->title));

                // Check if slug is valid, other rules are checked in PostsRequest
                // Slug can't be checked there because it is dynamically populated by title
                if (!preg_match('/^[a-z0-9-_]+$/', $slug)) {
                    return response()->json(['message' => 'Slug is invalid. Can only contains a-z, 0-9 or _'], 422);
                }
            }

            $post = Posts::find($id);
            $post->slug = is_null($request->title) ? $post->slug : $slug;
            $post->title = is_null($request->title) ? $post->title : $request->title;
            $post->content = is_null($request->content) ? $post->content : $request->content;
            $post->enabled = is_null($request->enabled) ? $post->enabled : $request->enabled;
            $post->save();

            return response()->json(["message" => "201 - Post updated"], 201);
        } else {
            return response()->json(['message' => '404 - Post not found'], 404);
        }
    }

    /**
     * Enable an existing post
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function enable(int $id): JsonResponse
    {
        // Find post and then set to enabled or else show error message
        if (Posts::where('id', $id)->exists()) {
            $post = Posts::find($id);
            $post->enabled = -1;
            $post->save();

            return response()->json(["message" => "201 - Post enabled"], 201);
        } else {
            return response()->json(['message' => '404 - Post not found'], 404);
        }
    }

    /**
     * Disable an existing post
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function disable(int $id): JsonResponse
    {
        // Find post and then set to disabled or else show error message
        if (Posts::where('id', $id)->exists()) {
            $post = Posts::find($id);
            $post->enabled = 0;
            $post->save();

            return response()->json(["message" => "201 - Post disabled"], 201);
        } else {
            return response()->json(['message' => '404 - Post not found'], 404);
        }
    }

    /**
     * Destroy an existing post
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Find post and then delete it or else show error message
        if (Posts::where('id', $id)->exists()) {
            $post = Posts::find($id);
            $post->delete();

            return response()->json(["message" => "200 - Post deleted"], 200);
        } else {
            return response()->json(['message' => '404 - Post not found'], 404);
        }
    }
}
