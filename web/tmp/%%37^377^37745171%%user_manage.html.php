<?php /* Smarty version 2.6.13, created on 2012-12-19 17:34:47
         compiled from common/admin/user_manage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'common/admin/user_manage.html', 18, false),)), $this); ?>
<div class="theContent">
    <div class="theTitle">
        <h2>ADMINISTRATIVE ACCOUNTS</h2>
        <a href="?s=admin&amp;r=users&amp;do=new" class="btn btn_pencil"><span>New User Account</span></a>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <thead>
            <tr>        
                <th class="head0" width="10">No</th>
                <th class="head1" width="100">Username</th>
                <th class="head0">Action</th>
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
                <td>1</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['username'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
                <td>
                <a class="btn btn_lock" href="?s=admin&r=permission&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['userID']; ?>
"><span>Set Permissions</span></a> 
                <a class="btn btn_pencil" href="?s=admin&amp;r=users&amp;do=edit&amp;id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['userID']; ?>
"><span>Edit</span></a> 
                <a class="btn btn_cut" href="#" onClick="doConfirm('<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['userID']; ?>
');return false;"><span>Delete</span></a>
                </td>
              </tr>
              <?php endfor; endif; ?>
        </tbody>
    </table>
</div><!--theContent-->
<script>
<?php echo '
function doConfirm(id){
	if(confirm("Are you sure to delete this account permanently ?")){
	'; ?>

		var s = "?s=admin&r=users&do=delete&id="+id;
<?php echo '
		document.location=s;
	}else{
		return false;
	}
}
'; ?>

</script>