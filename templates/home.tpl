{extends file="layout.tpl"}
{block name="content"}
    {foreach $categories as $cat}
    <div class="category">
    <h2 class="category__title">{$cat.title}</h2>
    <p class="category__description">{$cat.description}</p>
    <div class="category__articles">
        {foreach $cat.articles as $article}
        <a href="/article/{$article.id}">
            <div class="card">
                <div class="card__image"><img src="{$article.image}"></div>
                <h3>{$article.title}</h3>
                <p>{$article.description}</p>
                <div class="card__meta">
                    <span><i class="icon icon--calendar"></i>{$article.created_at|date_format:"%b %d, %Y"}</span>
                    <span><i class="icon icon--eye"></i>{$article.views}</span>
                </div>
            </div>
        </a>
        {/foreach}
    </div>
    <a href="/category/{$cat.id}">All Articles</a>
    </div>
    {/foreach}
{/block}
