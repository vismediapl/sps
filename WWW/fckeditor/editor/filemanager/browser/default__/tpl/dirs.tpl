<ul id="dirs">
{foreach from=$dirs item=dir}
	<li><a href="#" onclick="getFilesAndFolders('{$dir.path|iconv}'); return false">{$dir.name|iconv|default:"&lt;w górę&gt;"}</a>{if $dir.name} <a href="#" onclick="renameFolder('{$dir.path|iconv}'); return false" title="Zmień nazwę katalogu"><img src="img/rf.gif" alt="" /></a><a href="#" onclick="deleteFolder('{$dir.path|iconv}'); return false" title="Usuń katalog"><img src="img/df.gif" alt="" style="margin-left: 2px" /></a>{/if}</li>
{/foreach}
</ul>
