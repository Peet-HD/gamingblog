<div class="col s2 center" style="padding-top:12px;">
    <h6 style="font-size: 1.3rem;">Neuer Blogeintrag:</h6>
</div>
<form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writenewentry'])}" method="Post">
    <div class="col s7">
        <input name="title" placeholder="Bitte Titel eingeben"></input>
    </div>
    <div class="col s3">
        <label>
            <select name='categoryId'>
                {foreach from=$category item=entry}
                    <option value='{$entry.categoryId}'>
                        {$entry.categoryName}
                    </option>
                {/foreach}
            </select>
        </label>
    </div>
    <div class="col s12">
        <textarea name="text"></textarea>
    </div>
    <div class="col s12" style="padding: 12px">
        <button class='btn waves-effect waves-teal right' type="submit">Speichern</button>
    </div>
    <hr/>
</form>
