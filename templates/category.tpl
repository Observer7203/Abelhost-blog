{extends file="layout.tpl"}
{block name="content"}
    <a href="/" class="back-link">← Back</a>
    <h1>{$category.title}</h1>
    <p>{$category.description}</p>

    <div class="sort">
        <a href="?sort=date&page=1">By date</a>
        <a href="?sort=views&page=1">By views</a>
    </div>

    <div class="category__articles">
        {foreach $articles as $article}
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

    {if $totalPages > 1}
        <div class="pagination">
            {for $p=1 to $totalPages}
                {if $p == $currentPage}
                    <span>{$p}</span>
                {else}
                    <a href="?sort={$sort}&page={$p}">{$p}</a>
                {/if}
            {/for}
        </div>
    {/if}
{/block}
