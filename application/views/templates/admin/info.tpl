<div class="col s9 offset-s1">
{if isset($saved) && !empty($saved)}
    <table style="padding: 10px; background-color: green; color: white; width: 100%;">
        <tr id="successSaved">
            <td>Der Inhalt der "{$saved}"-page wurde gespeichert.</td>
        </tr>
    </table>
{else}
    {if isset($err) && !empty($err)}
        <table style="padding: 10px; background-color: red; color: white; width: 100%;">
            {if $err == 'invalidId'}
            <tr id="errorInvalidId">
                <td>Der Inhalt konnte nicht gespeichert werden (Ungültige Id).</td>
            </tr>
            {/if}
            {if $err == 'game'}
            <tr id="errorGameContent">
                <td>Der Inhalt der "game"-page konnte nicht gespeichert werden.</td>
            </tr>
            {/if}
            {if $err == 'company'}
            <tr id="errorCompanyContent">
                <td>Der Inhalt der "company"-page konnte nicht gespeichert werden.</td>
            </tr>
            {/if}
            {if $err == 'about'}
            <tr id="errorAboutContent">
                <td>Der Inhalt der "about"-page konnte nicht gespeichert werden.</td>
            </tr>
            {/if}
            {if $err == 'privacy'}
            <tr id="errorPrivacyContent">
                <td>Der Inhalt der "privacy"-page konnte nicht gespeichert werden.</td>
            </tr>
            {/if}
        </table>
    {/if}
{/if}
</div>