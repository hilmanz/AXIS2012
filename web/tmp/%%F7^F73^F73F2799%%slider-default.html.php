<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb/widgets/slider-default.html */ ?>
<?php if ($this->_tpl_vars['banner']): ?>
    <div id="slider">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['basedomain']; ?>
assets/css/slider-default.css" />
        <div id="da-slider" class="da-slider">
		<?php $this->assign('idxslider', 0); ?>
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
				<?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['slider_image'] != ''): ?>
					<div class="da-slide" id="<?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['banner']['textalign'] == 'left'): ?>slide1<?php else: ?>slide3<?php endif; ?>">
						<div class="entrySlide">
							<h1><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['title']; ?>
</h1>
							<h2><?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['brief']; ?>
</h2>
							<?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['articleType'] == 1): ?> <a class="detail " <?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']): ?>href="<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']; ?>
"<?php else: ?>href="<?php echo $this->_tpl_vars['basedomain']; ?>
online_store/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a>       
							<?php else: ?><a class="detail " <?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']): ?>href="<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']; ?>
"<?php else: ?>href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['locale']['btn']['detail']; ?>
</a><?php endif; ?> 
						</div>
						
						<div class="da-img"><img src="" url="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/banner/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['slider_image']; ?>
" class="img_slider sliderd<?php echo $this->_tpl_vars['idxslider']; ?>
 sequenceload" /></div>
					</div><!-- end .da-slide -->
					<?php $this->assign('idxslider', $this->_tpl_vars['idxslider']+1); ?>
				<?php endif; ?>
			    <?php endfor; endif; ?>

            </div><!-- end .da-slide -->
    </div><!-- end #slider -->
<?php endif; ?>


<?php echo '
<script>
	$(document).ready(function () {
			$(".sliderd0").attr(\'src\',$(".sliderd0").attr("url"));
	  });
	
	$(".sequenceload").each(function(i,e){
		$(this).load(function(){nextload(\'.sliderd\',i)});
	});
	
	/*$(".img_slider").each(function(i,e){
			$(".sliderd"+i).attr(\'src\',$(this).attr("url"));
			$("img.sliderd"+i).load(function(){
				return true;
			});
	});*/
</script>
'; ?>