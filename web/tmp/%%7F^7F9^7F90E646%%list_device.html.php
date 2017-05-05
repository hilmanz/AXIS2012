<?php /* Smarty version 2.6.13, created on 2012-12-19 18:09:15
         compiled from application/admin/Master/list_device.html */ ?>
<div class="theContent">
    <div class="theTitle">
        <h2>Master Category News Content</h2>
        <a href="index.php?s=master&act=add_device" class="btn btn_pencil"><span>Add New</span></a>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <thead>
            <tr>        
                <th class="head0">No</th>
                <th class="head1">ID</th>
                <th class="head1">Type</th>
                <th class="head1" colspan="2">Action</th>
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
            <td width="4%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['no']; ?>
&nbsp;</td>
            <td width="10%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
&nbsp;</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['type']; ?>
</td>
            <td align="center" width="4%"><a href="index.php?s=master&act=edit_device&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" class="btn btn_pencil"><span>Edit</span></a></td>
            <td align="center" width="4%"><a href="index.php?s=master&act=delete_device&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" class="btn btn_cut" onclick="return confirm('Are you sure you want to delete this?')"><span>Delete</span></a></td>
          </tr>
          <?php endfor; endif; ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->