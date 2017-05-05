<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb/widgets/featured.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'application/axisweb/widgets/featured.html', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['banner']): ?>
<div id="featured">
    <div class="featured wrapper">
	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['banner']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
        <div class="circle">
            <a class="icon" href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['basedomain']; ?>
assets/images/cat_icon/small/icon-<?php echo ((is_array($_tmp=$this->_tpl_vars['banner'][$this->_sections['i']['index']]['category'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "", true) : smarty_modifier_truncate($_tmp, 3, "", true)); ?>
.png" /></a>
            <div class="entry">
                <p><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['title']; ?>
</p>
            </div><!-- end .entry -->
            <a class="detail" href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>
        </div><!-- end .circle -->
      <?php endfor; endif; ?>
    </div><!-- end .featured -->
</div><!-- end #featured -->
<?php endif; ?>