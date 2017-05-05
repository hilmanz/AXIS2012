<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb/widgets/carousel_banner.html */ ?>
<?php if ($this->_tpl_vars['banner']): ?>
<div id="bannerPromo">
    <div class="wrapper">
        <ul id="bannerCarousel" class="jcarousel-skin-tango">
		<?php $this->assign('idx', 0); ?>
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
		<?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['image']): ?>
				<li>
					<div class="bannerThumb">
					  
						<a <?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']): ?>href="<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['url']; ?>
"<?php else: ?>href="<?php echo $this->_tpl_vars['basedomain']; ?>
promo/detail/<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['id']; ?>
"<?php endif; ?>>
						<?php if ($this->_tpl_vars['banner'][$this->_sections['i']['index']]['thumbnail_image']): ?>
                        <img class="carousel_banner cbanner<?php echo $this->_tpl_vars['idx']; ?>
 sequenceload" src=""  url="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/realthumb_<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['thumbnail_image']; ?>
" height="130px"  width="245px" />
						<?php else: ?><img class="carousel_banner cbanner<?php echo $this->_tpl_vars['idx']; ?>
 sequenceload" src=""  url="<?php echo $this->_tpl_vars['basedomain']; ?>
public_assets/article/thumb_<?php echo $this->_tpl_vars['banner'][$this->_sections['i']['index']]['image']; ?>
" height="130px"  width="245px" />
						<?php endif; ?>
						</a>
						
					</div>
					<div class="shadow"></div>
				</li>
			<?php $this->assign('idx', $this->_tpl_vars['idx']+1); ?>
		<?php endif; ?>
		<?php endfor; endif; ?>
	
        </ul><!-- end #bannerCarousel -->
    </div><!-- end .wrapper -->
</div><!-- end #bannerPromo -->
<?php endif; ?>


<?php echo '
<script>
	$(document).ready(function () {
			$(".cbanner0").attr(\'src\',$(".cbanner0").attr("url"));
	  });
	
	$(".sequenceload").each(function(i,e){
		$(this).load(function(){nextload(\'.cbanner\',i)});
	});
	
	/*$(".carousel_banner").each(function(i,e){
			$(".cbanner"+i).attr(\'src\',$(this).attr("url"));
			$("img.cbanner"+i).load(function(){
				return true;
			});
	});*/
</script>
'; ?>