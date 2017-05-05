<?php /* Smarty version 2.6.13, created on 2012-12-19 17:32:40
         compiled from common/message.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'common/message.html', 2, false),)), $this); ?>
<div class="messageBox">
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['msg'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</h1>
<a class="btn btn2 btn_cloud" rel="popup-new-group"  href="<?php echo $this->_tpl_vars['url']; ?>
"><span>Continue</span></a>
</div>