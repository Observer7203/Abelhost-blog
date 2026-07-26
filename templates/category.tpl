{extends file="layout.tpl"}
{block name="content"}
    <h1>{$category.title}</h1>
    <p>{$category.description}</p>

    <div class="sort">
        <a href="?sort=date&page=1">By date</a>
        <a href="?sort=views&page=1">By views</a>
    </div>

    {foreach $articles as $article}
        <a href="/article/{$article.id}">
            <div class="card">
                <img src="{$article.image}">
                <h3>{$article.title}</h3>
                <p>{$article.description}</p>
            </div>
        </a>
    {/foreach}

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
