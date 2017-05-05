<?php /* Smarty version 2.6.13, created on 2012-12-17 16:12:17
         compiled from application/admin/Product/product_comment.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'application/admin/Product/product_comment.html', 34, false),array('modifier', 'intval', 'application/admin/Product/product_comment.html', 37, false),)), $this); ?>
<div class="theContent">
    <div class="theTitle">
        <h2>Product Comment</h2>
        <a href="index.php?s=product&act=excel_comment&contentid=<?php echo $this->_tpl_vars['contentid']; ?>
" class="btn btn_document"><span>Download XLS</span></a>
        <a href="index.php?s=product" class="btn btn_archive"><span>Back to Product</span></a>
    </div><!--contenttitle-->
    <div class="tableoptions">
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
                <th class="head1">ID</th>
                <th class="head0">User Name</th>
                <th class="head1">Comment</th>
                <th class="head0">Date</th>
                <th class="head1">Status</th>
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
                <td width="10"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['no']; ?>
&nbsp;</td>
                <td width="5%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
&nbsp;</td>
                <td width="20%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['comment']; ?>
</td>
                <td width="15%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%e %B %Y") : smarty_modifier_date_format($_tmp, "%e %B %Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td width="20%">
                    <select name='status' onchange='javascript:changeStatus(<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
,this.value);' id="sel-<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="width:150px;">
                        <option value="0" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 0): ?> selected="selected"<?php endif; ?>>Pending</option>
                        <option value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 1): ?> selected="selected" <?php endif; ?>>Approve</option>
                        <option value="2" <?php if (((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'])) ? $this->_run_mod_handler('intval', true, $_tmp) : intval($_tmp)) == 2): ?> selected="selected" <?php endif; ?>>Deleted</option>
                    </select>
                </td>
            </tr>
            <?php endfor; endif; ?>
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
	function changeStatus(id,status){
		$.get(
			\'index.php?s=product&act=change_status_comment&id=\'+id+\'&status=\'+status,
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