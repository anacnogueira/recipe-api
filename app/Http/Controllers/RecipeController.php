<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateImageRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $recipes = Recipe::query()
            ->when(request()->string('with', '')->contains('user'),
                fn($query) => $query->with(['user'])
            )
            ->when(request()->string('with', '')->contains('logs'),
                fn($query) => $query->with(['logs'])
            )
            ->simplePaginate();
        return RecipeResource::collection($recipes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        $recipe = Auth::user()->recipes()->create($request->all());

        return RecipeResource::make($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return RecipeResource::make($recipe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        Gate::authorize('update', $recipe);

        $recipe->update( $request->all());

        return RecipeResource::make($recipe);
    }

    public function uploadImage(UpdateImageRecipeRequest $request, Recipe $recipe)
    {
        Gate::authorize('update', $recipe);

        if ($recipe->image_url) {
            $relativePath = str_replace(asset('storage/'), '', $recipe->image_url);
            Storage::disk('public')->delete($relativePath);
        }
        $path = $request->file('image')->store('recipes', 'public');

        $url = asset('storage/' . $path);

        $recipe->update([
            'url_image' => $url,
        ]);

        return RecipeResource::make($recipe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        Gate::authorize('delete', $recipe);

        $recipe->reactions()->delete();

        $recipe->delete();

        return response()->noContent();
    }
}
