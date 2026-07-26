{extends file="layout.tpl"}
{block name="content"}

{if $article}
<article class="article">
    <a href="/" class="back-link">← Back</a>
    <h1 class="article__title">{$article.title}</h1>

    <div class="article__categories">
        {foreach $categories as $c}
            <a href="/category/{$c.id}" class="article__category">{$c.title}</a>
        {/foreach}
    </div>

    <div class="article__meta">{$article.views} views · {$article.created_at}</div>

    <img class="article__image" src="{$article.image}" />

    <p class="article__description">{$article.description}</p>
    <div class="article__content">{$article.content}</div>
</article>

<section class="similar">
    <h2 class="similar__title">Similar articles</h2>
    <div class="category__articles">
        {foreach $similarArticles as $s}
        <a href="/article/{$s.id}">
            <div class="card">
                <div class="card__image"><img src="{$s.image}"></div>
                <h3>{$s.title}</h3>
            </div>
        </a>
        {/foreach}
    </div>
</section>
{/if}

{/block}
