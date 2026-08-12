<?php

namespace App\Console\Commands;

use App\Mail\PersonalWeeklyDigestMail;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('reports:send-personal-digest')]
#[Description('Envia para cada usuário o desempenho individual das suas receitas na semana')]
class SendWeeklyPersonalDigest extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startOfWeek = now()->subDays(7)->startOfDay();
        $endOfWeek = now();

        User::whereHas('recipes')->chunk(100, function ($users) use ($startOfWeek, $endOfWeek) {
            foreach ($users as $user) {
                $topViewed = Recipe::where('user_id', $user->id)
                    ->topViewedBetween($startOfWeek, $endOfWeek, 5)
                    ->get();

                $topLiked = Recipe::where('user_id', $user->id)
                    ->topLikedBetween($startOfWeek, $endOfWeek, 5)
                    ->get();

                Mail::to($user->email)->queue(
                    new PersonalWeeklyDigestMail($user, $topViewed, $topLiked)
                );
            }
        });

        $this->info('Resumos individuais semanais enviados para a fila com sucesso!');
    }
}
