<?php /* Smarty version 2.6.13, created on 2012-12-17 15:19:01
         compiled from application/admin/Article/userpost_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'application/admin/Article/userpost_list.html', 58, false),array('modifier', 'date_format', 'application/admin/Article/userpost_list.html', 62, false),array('modifier', 'intval', 'application/admin/Article/userpost_list.html', 66, false),)), $this); ?>
<?php if ($this->_tpl_vars['content']): ?> <?php echo $this->_tpl_vars['content']; ?>
 <?php else: ?>
<div class="theContent">
    <div class="theTitle">
        <h2>User Content List</h2>
        <a href="index.php?s=article&act=excel_user_post&search=<?php echo $this->_tpl_vars['search']; ?>
&status=<?php echo $this->_tpl_vars['status']; ?>
&startdate=<?php echo $this->_tpl_vars['startdate']; ?>
&enddate=<?php echo $this->_tpl_vars['enddate']; ?>
" class="btn btn_document"><span>Download XLS</span></a>
    </div><!--contenttitle-->
    <div class="tableoptions">      
			<form>Search &nbsp;
				<input type="text" name="search" value="<?php echo $this->_tpl_vars['search']; ?>
" style="width:200px;"/>&nbsp;&nbsp;
				Status &nbsp;
				<select name="n_status" style="width:150px;">
					<option value="">ALL</option>
					<option value="0" <?php if ($this->_tpl_vars['status'] == '0'): ?> selected="selected"<?php endif; ?>>Non Publishing</option>
					<option value="1" <?php if ($this->_tpl_vars['status'] == 1): ?> selected="selected"<?php endif; ?>>Publishing</option>
				</select>&nbsp;&nbsp;
				Date Range &nbsp;
				<input type="text" name="startdate" value="<?php echo $this->_tpl_vars['startdate']; ?>
" style="width:150px;" class="datepicker" />&nbsp;&nbsp;
				s/d &nbsp; 
				<input type="text" name="enddate" value="<?php echo $this->_tpl_vars['enddate']; ?>
" style="width:150px;" class="datepicker" />&nbsp;&nbsp;
				<input type="submit" value="cari" style="width:50px;"/>
				<input type="hidden" name="s" value="article" />
				<input type="hidden" name="act" value="userpost" />
				<input type="hidden" name="filter" value="cari" />
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
                <th class="head1">User Name</th>
                <th class="head0">Title</th>
                <th class="head0">Brief</th>
                <th class="head1">Content</th>
                <th class="head0">Category</th>
                <th class="head1">Type</th>
                <th class="head0">Created Date</th>
                <th class="head1">Posted Date</th>
                <th class="head0">Status</th>
                <th class="head1">Image</th>
                <th class="head0">Preview</th>
                <th class="head1">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <tr>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['no']; ?>
&nbsp;</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['name']; ?>
&nbsp;</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['title']; ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['brief'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['category']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['type_name']; ?>
</td>
                <td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['created_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['created_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td align="center">
                    <select name='status' onchange='javascript:changeStatus(<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
,this.value);' id="sel-<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="width:150px;">
                        <option value="0" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 0): ?> selected="selected"<?php endif; ?>>Non Publishing</option>
                        <option value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 1): ?> selected="selected" <?php endif; ?>>Publishing</option>
                    </select>
                </td>
                <td><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
public_assets/user/photo/tiny_<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['image']; ?>
" width="100"/></td>
                <td align="center"><a href="<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['url']; ?>
" style="text-decoration:none;" target="_blank">preview</a></td>
                <td align="center" width="4%"><a href="index.php?s=article&act=hapus_content_user&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="text-decoration:none;" onclick="return confirm('Are you sure you want to delete this?')">Delete</a></td>
            </tr>
            <?php endfor; endif; ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->
<?php echo '
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){

});
	function changeStatus(id,status){
		$.get(
			\'index.php?s=article&act=change_status_user_content&id=\'+id+\'&status=\'+status,
			{},
			function(data){
				if(data.success > 0){
					$("#sel-"+id).fadeOut(\'fast\',function(){
						$("#sel-"+id).fadeIn(\'slow\');
					});
				}else{
					alert(\'Gagal mengganti status, silakan coba lagi!\');
				}
			},
			"json"
		);
		return false;
	}
</script>
'; ?>

<?php endif; ?>