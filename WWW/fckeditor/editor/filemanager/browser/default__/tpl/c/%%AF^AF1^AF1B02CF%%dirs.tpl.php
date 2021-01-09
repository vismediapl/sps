<?php /* Smarty version 2.6.13, created on 2006-08-31 15:47:35
         compiled from dirs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'iconv', 'dirs.tpl', 3, false),array('modifier', 'default', 'dirs.tpl', 3, false),)), $this); ?>
<ul id="dirs">
<?php $_from = $this->_tpl_vars['dirs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dir']):
?>
	<li><a href="#" onclick="getFilesAndFolders('<?php echo ((is_array($_tmp=$this->_tpl_vars['dir']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['dir']['name'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, "&lt;w górę&gt;") : smarty_modifier_default($_tmp, "&lt;w górę&gt;")); ?>
</a><?php if ($this->_tpl_vars['dir']['name']): ?> <a href="#" onclick="renameFolder('<?php echo ((is_array($_tmp=$this->_tpl_vars['dir']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false" title="Zmień nazwę katalogu"><img src="img/rf.gif" alt="" /></a><a href="#" onclick="deleteFolder('<?php echo ((is_array($_tmp=$this->_tpl_vars['dir']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false" title="Usuń katalog"><img src="img/df.gif" alt="" style="margin-left: 2px" /></a><?php endif; ?></li>
<?php endforeach; endif; unset($_from); ?>
</ul>