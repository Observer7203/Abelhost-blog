{extends file="layout.tpl"}
{block name="content"}
    <body>
    {foreach $categories as $cat}
    <h2>{$cat.title}</h2>
    <p>{$cat.description}</p>

    {foreach $cat.articles as $article}
        <div class="card">
            <img src="{$article.image}">
            <h3>{$article.title}</h3>
            <p>{$article.description}</p>
        </div>
    {/foreach}

    <a href="/category/{$cat.id}">All Articles</a>
    {/foreach}
    </body>
{/block}
