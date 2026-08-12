<?php

use Illuminate\Support\Facades\Schedule;

// Relatório 01: Toda segunda-feira às 08:00
Schedule::command('reports:send-global-top-recipes')
    ->weeklyOn(1, '08:00')
    ->name('send-global-top-recipes');

// Relatório 02: Toda segunda-feira às 09:00
Schedule::command('reports:send-personal-digest')
    ->weeklyOn(1, '09:00')
    ->name('send-personal-digest');
