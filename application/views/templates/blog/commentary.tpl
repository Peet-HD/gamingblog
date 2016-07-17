<form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writecomment'])}" method="Post">
    <input name='comment' type='text' placeholder="Bitte Kommentar schreiben"></input>
    <input name='blogId' type='text' hidden="true" value='{$blogId}'></input>
    <button class="btn waves-effect waves-light submitBtn btnSmall" type="submit" name="action">
        <i class="material-icons tiny right">send</i> Absenden
    </button>
</form>