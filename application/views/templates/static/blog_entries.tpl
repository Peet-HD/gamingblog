{foreach from=$news_entries item=entry}
    <div class="blogeintraege">
        {if $user->authenticate() && $user->isAdmin()}
            <form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
            <input type='text' name='title' value="{$entry.title}"></input>
            <input hidden='true' name='blogId' value='{$entry.blogId}'></input>
                <textarea class='' name='text'>
                    {$entry.text}
                </textarea>
                <label>Kategorie:
                    <select name='categoryId'>
                        {foreach from=$category item=entry}
                            <option value={$entry.categoryId}>
                                {$entry.categoryName}
                            </option>
                        {/foreach}
                 </select>
                </label>
                 <button class='btn waves-effect waves-teal' type="submit">Ändern</button>
                 <form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
                     <input hidden='true' name='blogId' value='{$entry.blogId}'></input>
                     <button style='background-color:#e53935;' name="delete" value="1" class='btn waves-effect waves-teal' type='submit'>Löschen</button>
                 </form>
            </form>

        {else}
            <header class="ueberschrift">{$entry.title}</header>
            <section class="content">{$entry.text|truncate:3000:false}</section>

	<footer class="lastline">
            <p>Kategorie: {$entry.categoryName}</p>
            <ul>  
                <li>{$entry.blogId}</li>
                <li><a href='{$urlHelper->url(["controller" => "blog", "action" => "entrydetail"])}?blogid={$entry.blogId}'>mehr</a></li>
		<li><a href="">Likes</a></li>
                <li><a href="">Kommentare</a></li>
            </ul>
	</footer>
    </div>
    {/if}
{/foreach}