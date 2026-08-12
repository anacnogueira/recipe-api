<?php

namespace App\Console\Commands;

use App\Mail\TopWeeklyRecipesMail;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('reports:send-global-top-recipes')]
#[Description('Envia o e-mail com as 10 receitas mais vistas da semana para todos os usuários')]
class SendWeeklyGlobalTopRecipes extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startOfWeek = now()->subDays(7)->startOfDay();
        $endOfWeek = now();

        $topRecipes = Recipe::topViewedBetween($startOfWeek, $endOfWeek, 10)->get();

        if ($topRecipes->isEmpty()) {
            $this->info('Nenhuma visualização registrada nesta semana.');
            return;
        }

        User::select('id', 'email')->chunk(200, function ($users) use ($topRecipes) {
            foreach ($users as $user) {
                Mail::to($user->email)->queue(new TopWeeklyRecipesMail($topRecipes));
            }
        });

        $this->info('Relatório geral da semana enviado para a fila com sucesso!');
    }
}
