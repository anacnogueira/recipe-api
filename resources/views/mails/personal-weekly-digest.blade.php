<h2>Olá, {{ $user->name }}! 👋</h2>
<p>Aqui está o desempenho das suas receitas na última semana:</p>

<h3>👁️ Suas 5 receitas mais vistas:</h3>
<ul>
    @forelse($topViewedRecipes as $recipe)
        <li><strong>{{ $recipe->title }}</strong> ({{ $recipe->views_count }} visualizações)</li>
    @empty
        <li>Sua receitas não tiveram visualizações esta semana.</li>
    @endforelse
</ul>

<h3>❤️ Suas 5 receitas mais curtidas:</h3>
<ul>
    @forelse($topLikedRecipes as $recipe)
        <li><strong>{{ $recipe->title }}</strong> ({{ $recipe->reactions_count }} curtidas)</li>
    @empty
        <li>Nenhuma receita sua recebeu curtidas esta semana.</li>
    @endforelse
</ul>
