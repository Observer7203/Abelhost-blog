{extends file="layout.tpl"}
{block name="content"}

{if $article}
    <div>{$article.title}</div>
    {foreach $categories as $c}
        <a href="/category/{$c.id}">{$c.title}</a>
    {/foreach}
    <img src="{$article.image}" />
    <div>{$article.description}</div>
    <div>{$article.content}</div>
    <div>{$article.views}</div>
    <div>{$article.created_at}</div>
    <div>
    {foreach $similarArticles as $s}
        <a href="/article/{$s.id}"><img src="{$s.image}"/>{$s.title}</a>
    {/foreach}
    </div>
{/if}
{/block}