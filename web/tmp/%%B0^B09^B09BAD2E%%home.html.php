<?php /* Smarty version 2.6.13, created on 2012-12-03 10:15:55
         compiled from application/mobile/home.html */ ?>
<div class="breadcrumb">
		<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a>	
	</div>
<div class="page-body" data-role="content">	
	<div class="promo">
		 <div class="flexslider">
			<ul class="slides">
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
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=promo&act=hot&id=<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
">
						<img width="720" src="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/thumb_<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['slider_image']; ?>
" />
					</a>
				</li>
				<?php endfor; endif; ?>
			</ul>
		</div>
	</div>
	
	<script type="text/javascript">
	<?php echo '
		$(\'#page-home\').live( \'pageshow\', function(e){
			$(\'.flexslider\').flexslider({
				controlNav: false,
				slideshowSpeed: 10000,
				animation: "slide"
			});
		});
	'; ?>

	</script>
	
	<div class="list-nav">
		<ul data-role="listview" data-inset="true">
			<li>
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=kenapaAxis" data-transition="slide">
						<span class="icon icon-question"></span>
						<?php echo $this->_tpl_vars['locale']['nav']['kenapaaxis']; ?>

					</a>
				</li>
				<li>
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=product" data-transition="slide">
						<span class="icon icon-box"></span>
						<?php echo $this->_tpl_vars['locale']['nav']['produk']; ?>

					</a>
				</li>
				<li>
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=promo" data-transition="slide">
						<span class="icon icon-love"></span>
						<?php echo $this->_tpl_vars['locale']['nav']['promo']; ?>

					</a>
				</li>
				<li>
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=axisku" data-transition="slide">
						<span class="icon icon-bubble"></span>
						<?php echo $this->_tpl_vars['locale']['nav']['axislife']; ?>

					</a>
				</li>
				<li>
					<a href="<?php echo $this->_tpl_vars['mobiledomain']; ?>
index.php?page=kontak" data-transition="slide">
						<span class="icon icon-tools"></span>
						<?php echo $this->_tpl_vars['locale']['nav']['customercare']; ?>

					</a>
				</li>
		</ul>
	</div>
</div><!-- /content -->