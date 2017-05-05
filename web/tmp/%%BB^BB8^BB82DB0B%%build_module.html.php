<?php /* Smarty version 2.6.13, created on 2012-12-19 17:39:49
         compiled from common/admin/pluginBuilder/build_module.html */ ?>
<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>ADD MODULE</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
            <form name="form1" method="post" action="">
                <tr>
                <tr>
                  <td>Class Name</td>
                  <td><input name="className" type="text" id="invoker" size="50" maxlength="255" value="<?php echo $this->_tpl_vars['editList']['className']; ?>
"> </td>
                </tr>
                  <td>Module Path</td>
                  <td><input name="pluginPath" type="text" id="class" size="50" maxlength="255" value="<?php echo $this->_tpl_vars['editList']['plugin_path']; ?>
"> 
                    example : applicationFolder/adminFolder/moduleFolder/</td>
                </tr>
                <tr>
                  <td>Request ID</td>
                  <td><input name="requestID" type="text" id="invoker" size="50" maxlength="255" value="<?php echo $this->_tpl_vars['editList']['requestID']; ?>
"> </td>
                </tr>
                 
                <tr>
                  <td>Status</td>
                  <td><select name="status" id="status">
                    <option value="1" <?php if ($this->_tpl_vars['editList']['is_enabled'] == '1'): ?> selected <?php endif; ?>>Active</option>
                    <option value="0" <?php if ($this->_tpl_vars['editList']['is_enabled'] == '0'): ?> selected <?php endif; ?>>Disabled</option>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                  <input type="submit" name="button" id="button" class="stdbtn btn_orange" value="<?php if ($this->_tpl_vars['editList']): ?>Update<?php else: ?>Save<?php endif; ?>">
                  <?php if ($this->_tpl_vars['editList']): ?>
                    <input type="button" name="button" id="button" class="stdbtn btn_orange" value="New Module" onCLick="window.location='index.php?s=pluginBuilder'" ></a>
                    <input name="id" type="hidden" id="idxID" value="<?php echo $this->_tpl_vars['editList']['id']; ?>
">
                  <?php endif; ?>
                  <input name="s" type="hidden" id="s" value="pluginBuilder">
                  <input name="do" type="hidden" id="do" value="<?php if ($this->_tpl_vars['editList']): ?>updateModule<?php else: ?>saveModule<?php endif; ?>"></td>
                </tr>
		</form>
        </tbody>
    </table><br /><br />
    <div class="theTitle">
        <h2>DASHBOARD CONFIGURATION</h2>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <thead>
            <tr>        
                <th class="head0">Class Name</th>
              <th class="head1">module Path</th>
                <th class="head1">Request ID</th>
                <th class="head0">Status</th>
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
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['className']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['plugin_path']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['requestID']; ?>
</td>
                <td><?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['is_enabled'] == '1'): ?> ACTIVE <?php else: ?> DISABLED<?php endif; ?></td>
                <td colspan="2">
                <a class="btn btn_pencil" href="?s=pluginBuilder&do=editModule&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
"><span>Edit</span></a> 
                <a class="btn btn_cut" href="javascript:void(0)" ondblclick="window.location='?s=pluginBuilder&do=deleteModule&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
' " ><span>Delete</span></a>
              </tr>
              <?php endfor; endif; ?>
        </tbody>
    </table><br /><br />
</div><!--theContent-->