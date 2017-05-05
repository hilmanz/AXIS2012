<?php /* Smarty version 2.6.13, created on 2012-12-19 17:15:10
         compiled from common/admin/permission.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'common/admin/permission.html', 19, false),)), $this); ?>
<div class="theContent">
    <?php if ($this->_tpl_vars['msg']): ?><div class="notibar msgalert"><p><?php echo $this->_tpl_vars['msg']; ?>
</p></div><?php endif; ?>
    <div class="theTitle">
        <h2>ADMINISTRATIVE ACCOUNTS (Permission settings for &quot;<?php echo $this->_tpl_vars['rs']['username']; ?>
&quot;)</h2>
        <a href="?s=admin&amp;r=users&amp;do=new" class="btn btn_pencil"><span>New User Account</span></a>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <thead>
            <tr>        
                <th class="head0">Section</th>
              <th class="head1">Permission</th>
                <th class="head1">Content Category</th>
            </tr>
        </thead>
        <tbody>
            <form action="" method="post">
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
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['description'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</td>
					<td>
						<input name="<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['requestID']; ?>
" type="radio" value="yes" <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['isAllowed']): ?>checked<?php endif; ?>>
						<label>Yes </label>
						<input name="<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['requestID']; ?>
" type="radio" value="no" <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['isAllowed']):  else: ?>checked<?php endif; ?>>
						<label>No</label> 
					</td>
					<td>
						<div style="width: 500px; overflow: auto;">
							<?php $_from = $this->_tpl_vars['list'][$this->_sections['i']['index']]['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
								<?php if ($this->_tpl_vars['v']): ?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['cat_role'][$this->_tpl_vars['k']]): ?>
									<div><input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
" name="category[]" checked="checked"/><?php echo $this->_tpl_vars['v']; ?>
</div> 
									<?php else: ?>
									<div><input type="checkbox" value="<?php echo $this->_tpl_vars['k']; ?>
" name="category[]" id="uncheck"><?php echo $this->_tpl_vars['v']; ?>
 </div>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						</div>			
					</td>
				</tr>
              <?php endfor; endif; ?>
              <input name="s" type="hidden" id="s" value="admin">
              <input name="r" type="hidden" id="r" value="permission">
              <input name="do" type="hidden" id="do" value="update">
              <input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['rs']['userID']; ?>
">
			  <input name="level" type="hidden" id="level" value="<?php echo $this->_tpl_vars['rs']['level']; ?>
"/>
              <tr>
            	<td colspan="3"><input type="submit" name="SAVE" id="SAVE"  class="stdbtn btn_orange"value="SAVE"></td>
              </tr>
            </form>
        </tbody>
    </table>
</div><!--theContent-->