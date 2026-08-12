<h2>🔥 As 10 Receitas mais bombadas da semana</h2>
<p>Confira o que a comunidade esteve cozinhando nos últimos 7 dias:</p>

<ol>
    @foreach ($recipes as $recipe)
        <li>
            <strong>{{ $recipe->title }}</strong> - {{ $recipe->views_count }} visualizações
        </li>
    @endforeach
</ol>
