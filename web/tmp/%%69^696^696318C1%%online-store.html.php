<?php /* Smarty version 2.6.13, created on 2012-11-13 11:23:57
         compiled from application/axisweb//axisProduct/online-store.html */ ?>
<div id="breadcumb" class="wrapper">
	<h1><a href="index.php"><?php echo $this->_tpl_vars['locale']['home']['title']; ?>
</a> &raquo; <a href="index.php?page=online_store"><?php echo $this->_tpl_vars['locale']['onlinestore']['title']; ?>
</a></h1>
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_store']; ?>

<div id="container">
    <div class="wrapper" id="lagiIn">
    	<div id="sidebar">
								<?php echo $this->_tpl_vars['medium_banner']; ?>

        </div><!-- end #sidebar -->
        <div id="contents">
        	<div class="shorter tabStore">
            	<ul>
                	<li class="active"><a class="iconGame" href="#tabGames"><?php echo $this->_tpl_vars['locale']['onlinestore']['games']; ?>
</a></li>
                	<li><a class="iconWallpaper" href="#tabWallpaper"><?php echo $this->_tpl_vars['locale']['onlinestore']['walpaper']; ?>
</a></li>
                	<li><a class="iconRbt" href="#tabRbt"><?php echo $this->_tpl_vars['locale']['onlinestore']['rbt']; ?>
</a></li>
                	<li><a class="iconRingtone" href="#tabRingtone"><?php echo $this->_tpl_vars['locale']['onlinestore']['ringtone']; ?>
</a></li>
                	<li><a class="iconGratis" href="#tabGratis"><?php echo $this->_tpl_vars['locale']['onlinestore']['gratis']; ?>
</a></li>
                </ul>
                <form class="rightShort">
           			<select class="styled"/>
                	<option>Populer</option>
					<option>terbaru</option>
                    </select>
                </form>
            </div><!-- end .shorter -->
            <div class="shadowCtop">
                <div id="listStore" class="shadowCbottom">
					<div id="tabGames" class="tab_content">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['mcp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['categoryid'] == 9): ?>
						 <div class="boxPromo">
							<div class="bannerThumb">
								<a href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><img src="public_assets/mcp/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['image']; ?>
"/></a>
							</div><!-- end .bannerThumb -->
							
							<div class="pitaGame"></div>
							<a class="beli" href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['beli']; ?>
</a>
							<h3 class="title"><?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['title']; ?>
</h3>
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] != 0): ?><span class="price">Rp. <?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize']; ?>
</span><?php endif; ?>
							<div class="shadow"></div>
						</div><!-- end .boxPromo -->
						<?php endif; ?>
					<?php endfor; endif; ?>
					</div>
					
					<div id="tabWallpaper" class="tab_content">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['mcp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['categoryid'] == 10): ?>
						 <div class="boxPromo">
							<div class="bannerThumb">
								<a href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><img src="public_assets/mcp/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['image']; ?>
"/></a>
							</div><!-- end .bannerThumb -->
							
							<div class="pitaGame"></div>
							<a class="beli" href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['beli']; ?>
</a>
							<h3 class="title"><?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['title']; ?>
</h3>
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] != 0): ?><span class="price">Rp. <?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize']; ?>
</span><?php endif; ?>
							<div class="shadow"></div>
						</div><!-- end .boxPromo -->
						<?php endif; ?>
					<?php endfor; endif; ?>
					</div>
					
					<div id="tabRbt" class="tab_content">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['mcp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['categoryid'] == 8): ?>
						 <div class="boxPromo">
								<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']): ?>
								 <div class="mp3Player">
										<audio id="player2" style="width:245px;" src="public_assets/media/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']; ?>
" type="audio/mp3" controls="controls"></audio>	
									</div><!-- end .mp3Player -->
								<?php else: ?>
									<div class="bannerThumb">
									<a href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><img src=	"public_assets/mcp/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['image']; ?>
"/></a>
									</div><!-- end .bannerThumb -->
								<?php endif; ?>
							<div class="pitaGame"></div>
							<a class="beli" href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['beli']; ?>
</a>
							<h3 class="title"><?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['title']; ?>
</h3>
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] != 0): ?><span class="price">Rp. <?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize']; ?>
</span><?php endif; ?>
							<div class="shadow"></div>
						</div><!-- end .boxPromo -->
						<?php endif; ?>
					<?php endfor; endif; ?>
					</div>
					
					<div id="tabRingtone" class="tab_content">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['mcp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['categoryid'] == 11): ?>
						 <div class="boxPromo">
								<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']): ?>
								 <div class="mp3Player">
										<audio id="player2" style="width:245px;" src="public_assets/media/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']; ?>
" type="audio/mp3" controls="controls"></audio>	
									</div><!-- end .mp3Player -->
								<?php else: ?>
									<div class="bannerThumb">
									<a href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><img src=	"public_assets/mcp/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['image']; ?>
"/></a>
									</div><!-- end .bannerThumb -->
								<?php endif; ?>
							<div class="pitaGame"></div>
							<a class="beli" href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['beli']; ?>
</a>
							<h3 class="title"><?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['title']; ?>
</h3>
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] != 0): ?><span class="price">Rp. <?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize']; ?>
</span><?php endif; ?>
							<div class="shadow"></div>
						</div><!-- end .boxPromo -->
						<?php endif; ?>
					<?php endfor; endif; ?>
					</div>
					
					<div id="tabGratis" class="tab_content">
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['mcp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] == 0): ?>
						 <div class="boxPromo">
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']): ?>
								 <div class="mp3Player">
										<audio id="player2" style="width:245px;" src="public_assets/media/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['file']; ?>
" type="audio/mp3" controls="controls"></audio>	
									</div><!-- end .mp3Player -->
								<?php else: ?>
									<div class="bannerThumb">
									<a href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><img src=	"public_assets/mcp/<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['image']; ?>
"/></a>
									</div><!-- end .bannerThumb -->
							<?php endif; ?>
							
							<div class="pitaGame"></div>
							<a class="beli" href="index.php?page=online_store&act=detail&id=<?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['locale']['btn']['beli']; ?>
</a>
							<h3 class="title"><?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['title']; ?>
</h3>
							<?php if ($this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize'] != 0): ?><span class="price">Rp. <?php echo $this->_tpl_vars['mcp'][$this->_sections['i']['index']]['prize']; ?>
</span><?php endif; ?>
							<div class="shadow"></div>
						</div><!-- end .boxPromo -->
						<?php endif; ?>
					<?php endfor; endif; ?>
					</div>
                   
               
                </div><!-- end #listStore -->
            </div><!-- end .shadowCtop -->
            <div class="paging">
                <a class="prev" href="#">&laquo;</a>
                <a href="#" class="current">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a class="next" href="#">&raquo;</a>
            </div><!-- end .paging -->
        </div><!-- end #contents -->
    </div><!-- end #lagiIn -->
</div><!-- end #container -->

<?php echo '
	<script>
		$("li").click(function(){
			$("li").removeClass("active");
			$(this).addClass("active");
		
		});
	</script>
'; ?>