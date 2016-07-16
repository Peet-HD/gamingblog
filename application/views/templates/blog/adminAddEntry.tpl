<form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
    <input name="title" placeholder="Bitte Titel eingeben"></input>
    <textarea name="text"></textarea>
    <label>Kategorie:
    <select name='categoryId'>
        {foreach from=$category item=entry}
            <option value='{$entry.categoryId}'>
                {$entry.categoryName}
            </option>
        {/foreach}
    </select>
    </label> 

  <button class='btn waves-effect waves-teal' type="submit">Speichern</button>
</form>
