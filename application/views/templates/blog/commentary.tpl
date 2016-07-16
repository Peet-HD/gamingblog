<form action="{$urlHelper->url(['controller' => 'blog', 'action' => 'writecomment'])}" method="Post">
    <input name='comment' type='text' placeholder="Bitte Kommentar schreiben"></input>
    <input name='blogId' type='text' hidden="true" value='{$entry.blogId}'></input>
    <button type="submit">Absenden</button>
</form>