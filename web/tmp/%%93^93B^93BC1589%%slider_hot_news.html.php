<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb/widgets/slider_hot_news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'application/axisweb/widgets/slider_hot_news.html', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['banner']): ?>
<div id="hotNews">
    <div class="wrapper">
        <ul id="newsCarousel" class="jcarousel-skin-tango">
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
            <li>
                <div class="hotNews cat_music">
                    <div class="hotThumb">
                        <a href="#"><img src="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/thumb_<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['image']; ?>
"/></a>
                    </div>
                    <div class="iconCat">
                        <img src="<?php echo $this->_tpl_vars['basedomain']; ?>
assets/images/cat_icon/big/icon-<?php echo ((is_array($_tmp=$this->_tpl_vars['banner'][$this->_sections['i']['index']]['category'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "", true) : smarty_modifier_truncate($_tmp, 3, "", true)); ?>
.png"/>
                    </div>
                    <div class="entry">
                        <h1><a href="#"><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['title']; ?>
</a></h1>
                        <p><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['brief']; ?>
</p>
                        <a href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
" class="readmore"><?php echo $this->_tpl_vars['locale']['btn']['baca']; ?>
</a>
                    </div>
                </div>
            </li>
			<?php endfor; endif; ?>
        </ul><!-- end #bannerCarousel -->
    </div><!-- end .wrapper -->
</div><!-- end #hotNews -->
<?php endif; ?>