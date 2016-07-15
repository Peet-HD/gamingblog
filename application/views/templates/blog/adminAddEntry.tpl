<form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
    <input name="title" placeholder="Bitte Titel eingeben"></input>
  <textarea name="text"></textarea>
  <label>Kategorie: 
      <select name='categoryId'>
         {foreach from=$news_entries item=entry}
             <option value={$entry.categoryId}>{$entry.categoryName}</option>
         {/foreach}
      </select></label>
  <button type="submit" style="width:50px; height:20px;">Speichern</button>
</form>
