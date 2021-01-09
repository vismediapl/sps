<?php /* Smarty version 2.6.13, created on 2006-08-31 15:47:35
         compiled from files.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'iconv', 'files.tpl', 3, false),)), $this); ?>
<ul id="files">
<?php $_from = $this->_tpl_vars['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['file']):
?>
	<li title="<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['name'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
">
		<div class="t"><?php echo ((is_array($_tmp=$this->_tpl_vars['file']['name'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
</div>
		<a href="#" onclick="useFile('<?php echo $this->_tpl_vars['config']['path'];  echo ((is_array($_tmp=$this->_tpl_vars['file']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false"><img src="thumbnail.php?src=<?php echo $this->_tpl_vars['config']['root'];  echo $this->_tpl_vars['config']['path'];  echo ((is_array($_tmp=$this->_tpl_vars['file']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
" alt="" class="thumb" /></a>
		<div class="b"><a href="#" title="Zmień nazwę" onclick="renameFile('<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false"><img src="img/rn.gif" alt="" /> Zmień nazwę</a> | <a href="#" title="Usuń" onclick="deleteFile('<?php echo ((is_array($_tmp=$this->_tpl_vars['file']['path'])) ? $this->_run_mod_handler('iconv', true, $_tmp) : smarty_modifier_iconv($_tmp)); ?>
'); return false"><img src="img/rm.gif" alt="" /> Usuń</a></div>
	</li>
<?php endforeach; endif; unset($_from); ?>
</ul>