<?php /* Smarty version 2.6.13, created on 2012-11-14 16:17:22
         compiled from application/axisweb/widgets/slider-whyaxis.html */ ?>
	<?php if ($this->_tpl_vars['banner']): ?>
    <div id="slider">
		<link rel="stylesheet" type="text/css" href="assets/css/slider-whyaxis.css" />
        <div id="da-slider" class="da-slider">
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
            <div class="da-slide">
                <h1><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['title']; ?>
</h1>
                <h2><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['brief']; ?>
</h2>
                <div class="splash1"></div>
                <div class="da-img"><img src="public_assets/banner/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['image']; ?>
"/></div>
            </div><!-- end .da-slide -->
          <?php endfor; endif; ?>  
        </div><!-- end #da-slider -->
    </div><!-- end #slider -->
				   <?php endif; ?>