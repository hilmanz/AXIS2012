<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:34
         compiled from application/admin/Banner/banner_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'application/admin/Banner/banner_list.html', 83, false),)), $this); ?>

<div class="theContent">
    <div class="theTitle">
        <h2>Banner List</h2>
        <a href="index.php?s=banner&act=excelreport&lid=<?php echo $this->_tpl_vars['lid']; ?>
&id_cat=<?php echo $this->_tpl_vars['id_cat']; ?>
&id_type=<?php echo $this->_tpl_vars['id_type']; ?>
" class="btn btn_document"><span>Download XLS</span></a>
        <a href="index.php?s=banner&act=add" class="btn btn_pencil"><span>Add New Banner</span></a>
    </div><!--contenttitle-->
    <div class="tableoptions">      
			<form>
				<input type="text" name="search" value="<?php echo $this->_tpl_vars['search']; ?>
"/>
				<select name="lid" style="width:150px;">
					<option value=""> - Language - </option>
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['language']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<?php if ($this->_tpl_vars['language'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['lid']): ?>
						<option value="<?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['language']; ?>
</option>
					<?php else: ?>
						<option value="<?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['language']; ?>
</option>
					<?php endif; ?>
					<?php endfor; endif; ?>
				</select>
				<select name="id_type">
					<option value=""> - Type - </option>
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['type']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<?php if ($this->_tpl_vars['type'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['id_type']): ?>
						<option value="<?php echo $this->_tpl_vars['type'][$this->_sections['i']['index']]['id']; ?>
" selected="selected" ><?php echo $this->_tpl_vars['type'][$this->_sections['i']['index']]['type']; ?>
</option>
					<?php else: ?>
						<option value="<?php echo $this->_tpl_vars['type'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['type'][$this->_sections['i']['index']]['type']; ?>
</option>
					<?php endif; ?>
					<?php endfor; endif; ?>
				</select>
				<select name="id_page"  >
					<option value=""> - Menu - </option>
					<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['page']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
					<?php if ($this->_tpl_vars['page'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['id_page']): ?>
						<option value="<?php echo $this->_tpl_vars['page'][$this->_sections['i']['index']]['id']; ?>
" selected="selected" ><?php echo $this->_tpl_vars['page'][$this->_sections['i']['index']]['pagename']; ?>
</option>
					<?php else: ?>
						<option value="<?php echo $this->_tpl_vars['page'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['page'][$this->_sections['i']['index']]['pagename']; ?>
</option>
					<?php endif; ?>
					<?php endfor; endif; ?>
				</select>
                <span>Date Range</span>
				<input type="text" name="startdate" value="<?php echo $this->_tpl_vars['startdate']; ?>
" class="datepicker" />
				<span>s/d</span>
				<input type="text" name="enddate" value="<?php echo $this->_tpl_vars['enddate']; ?>
"class="datepicker" />
				<input type="submit" value="cari" />
				<input type="hidden" name="s" value="banner" class="stdbtn btn_orange" />
			</form>
    </div><!--tableoptions-->	
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <colgroup>
            <col class="con0" style="width: 4%" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
        </colgroup>
        <thead>
            <tr>
                <th class="head0">No</th>
                <th class="head1">Language</th>
                <th class="head0">Title</th>
                <th class="head1">Menu</th>
                                                <th class="head0">Publish Date</th>
                <th class="head1">Unpublish Date</th>
                <th class="head1">Status</th>
                                <th class="head1">Image</th>
                <th class="head0">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
        <tr>
            <td><?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['no']; ?>
&nbsp;</td>
            <td><?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['language']; ?>
</td>
            <td><?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['title']; ?>
</td>
            <td><?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['page']; ?>
</td>
                                    <td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['v'][$this->_tpl_vars['k']]['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['v'][$this->_tpl_vars['k']]['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
            <td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['v'][$this->_tpl_vars['k']]['expired_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['v'][$this->_tpl_vars['k']]['expired_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
            <td align="center">
                <?php if ($this->_tpl_vars['v'][$this->_tpl_vars['k']]['n_status'] == 0): ?> Inactive 
                <?php elseif ($this->_tpl_vars['v'][$this->_tpl_vars['k']]['n_status'] == 1): ?> Publish 
                <?php elseif ($this->_tpl_vars['v'][$this->_tpl_vars['k']]['n_status'] == 2): ?> Unpublish
                <?php else: ?>
                <?php endif; ?>
            </td>
                        <td><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
public_assets/banner/tiny_<?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['slider_image']; ?>
" width="100"/></td>
            <td width="4%">
                <nobr>
                <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['language']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <strong><?php echo $this->_tpl_vars['language'][$this->_sections['i']['index']]['language']; ?>
</strong>
                        <?php $this->assign('langID', $this->_tpl_vars['language'][$this->_sections['i']['index']]['id']); ?>
                    <?php if ($this->_tpl_vars['language'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['v']['hasLang'][$this->_tpl_vars['langID']]): ?>
                        <a href="index.php?s=banner&act=edit&id=<?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['parentid']; ?>
&id_lang=<?php echo $this->_tpl_vars['langID'];  echo $this->_tpl_vars['param_search']; ?>
" class="green"> update </a>
                        |
                        <a href="index.php?s=banner&act=comment&id=<?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['parentid']; ?>
&id_lang=<?php echo $this->_tpl_vars['langID'];  echo $this->_tpl_vars['param_search']; ?>
" class="orange"> comment </a>
                        | <a href="javascript:void(0)" class="popuppreview" url="http://axis-preview.kanadigital.com/index.php?page=banner" class="blue">preview</a>
                        | <a href="index.php?s=banner&act=hapus&parentid=<?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['parentid'];  echo $this->_tpl_vars['param_search']; ?>
" class="red" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                        <br />
                    <?php else: ?>
                        <a href="index.php?s=banner&act=add_language&id=<?php echo $this->_tpl_vars['v'][$this->_tpl_vars['k']]['parentid']; ?>
&id_lang=<?php echo $this->_tpl_vars['langID'];  echo $this->_tpl_vars['param_search']; ?>
" class="green"> add </a>
                        
                    <?php endif; ?>
                <?php endfor; endif; ?>
                </nobr>
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->
<?php echo '

<script type="text/javascript">
$(document).ready(function(){

});
	function changeStatus(parentid,status){
		$.get(
			\'index.php?s=banner&act=change_status&parentid=\'+parentid+\'&status=\'+status,
			{},
			function(data){
				if(data.success > 0){
					$("#sel-"+parentid).fadeOut(\'fast\',function(){
						$("#sel-"+parentid).fadeIn(\'slow\');
					});
				}else{
					alert(\'Gagal mengganti status, silakan coba lagi!\');
				}
			},
			"json"
		);
		return false;
	}
	
	function changeOnline(parentid,online){
		$.get(
			\'index.php?s=banner&act=change_online&parentid=\'+parentid+\'&online=\'+online,
			{},
			function(data){
				if(data.success > 0){
					$("#sel-"+parentid).fadeOut(\'fast\',function(){
						$("#sel-"+parentid).fadeIn(\'slow\');
					});
				}else{
					alert(\'Gagal mengganti online, silakan coba lagi!\');
				}
			},
			"json"
		);
		return false;
	}
	
	function changePrize(parentid,prize){
		$.get(
			\'index.php?s=banner&act=change_prize&parentid=\'+parentid+\'&prize=\'+prize,
			{},
			function(data){
				if(data.success > 0){
					$("#sel-"+parentid).fadeOut(\'fast\',function(){
						$("#sel-"+parentid).fadeIn(\'slow\');
					});
				}else{
					alert(\'Gagal mengganti prize, silakan coba lagi!\');
				}
			},
			"json"
		);
		return false;
	}	
</script>
'; ?>