<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactReactionRequest;
use App\Models\Recipe;
use App\Models\RecipeReaction;
use App\Http\Resources\RecipeResource;

class ReactionController extends Controller
{
    public function react(ReactReactionRequest $request, Recipe $recipe)
    {
        $userId = $request->user()->id;
        $type = $request->input('type');

        $existingReaction = RecipeReaction::where('recipe_id', $recipe->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $type) {
                $existingReaction->delete();
            } else {
                $existingReaction->update(['type' => $type]);
            }
        } else {
            RecipeReaction::create([
                'user_id' => $userId,
                'recipe_id' => $recipe->id,
                'type' => $type,
            ]);
        }

        return RecipeResource::make($recipe);
    }
}
