<ul id="files">
{foreach from=$files item=file}
	<li title="{$file.name|iconv}">
		<div class="t">{$file.name|iconv}</div>
		<a href="#" onclick="useFile('{$config.path}{$file.path|iconv}'); return false"><img src="thumbnail.php?src={$config.root}{$config.path}{$file.path|iconv}" alt="" class="thumb" /></a>
		<div class="b"><a href="#" title="Zmień nazwę" onclick="renameFile('{$file.path|iconv}'); return false"><img src="img/rn.gif" alt="" /> Zmień nazwę</a> | <a href="#" title="Usuń" onclick="deleteFile('{$file.path|iconv}'); return false"><img src="img/rm.gif" alt="" /> Usuń</a></div>
	</li>
{/foreach}
</ul>
