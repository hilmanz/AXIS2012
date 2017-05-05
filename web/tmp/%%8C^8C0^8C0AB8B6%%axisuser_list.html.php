<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/admin/Axisuser/axisuser_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'application/admin/Axisuser/axisuser_list.html', 50, false),)), $this); ?>

<div class="theContent">
    <div class="theTitle">
        <h2>List User Profile</h2>
    </div><!--contenttitle-->
    <div class="tableoptions">
			<form>
            	<span>Search</span>
				<input type="text" name="search" value="<?php echo $this->_tpl_vars['search']; ?>
"/>&nbsp;
				<span>Date Range</span>
				<input type="text" name="startdate" value="<?php echo $this->_tpl_vars['startdate']; ?>
" class="datepicker"/>&nbsp;
				<span>s/d</span>		
				<input type="text" name="enddate" value="<?php echo $this->_tpl_vars['enddate']; ?>
"   class="datepicker"/>&nbsp;
				<input type="submit" value="cari" class="stdbtn btn_orange" />
				<input type="hidden" name="s" value="axisuser" />
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
                <th class="head1">User ID</th>
                <th class="head0">Name</th>
                <th class="head1">Email</th>
                <th class="head0">Phone Number</th>
                <th class="head1">Register Date</th>
                <th class="head0">Last Login</th>
                <th class="head1">Status</th>
                <th class="head0">Total Login</th>
                <th class="head1">Image</th>
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
                <td width="3%"><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['no']; ?>
&nbsp;</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
&nbsp;</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['email']; ?>
</td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['phone_number']; ?>
</td>
                <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['register_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['register_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td align="center"><?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'] == 0): ?> Banned <?php elseif ($this->_tpl_vars['list'][$this->_sections['i']['index']]['n_status'] == 1): ?> Approve <?php else: ?> &nbsp; <?php endif; ?></td>
                <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['login_count']; ?>
</td>
                <td align="center"><?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['img'] != ''): ?>
                    <img src="<?php echo $this->_tpl_vars['baseurl']; ?>
public_assets/user/photo/<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['img']; ?>
" height="60"/>
                    <?php else: ?>
                    <img src="<?php echo $this->_tpl_vars['baseurl']; ?>
public_assets/user/photo/no_photo_small.gif" height="60"/>
                    <?php endif; ?>
                </td>
                <td align="center" width="4%">
                    <nobr>
                    <a href="index.php?s=article_user&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="text-decoration:none;" class="green">My Article</a> |
                    <?php if ($this->_tpl_vars['list'][$this->_sections['i']['index']]['img'] != ''): ?><a href="index.php?s=axisuser&act=hapus&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="text-decoration:none;" class="red" onclick="return confirm('Are you sure you want to delete this?')">Delete Photo</a>
                    <?php else: ?> <a href="#" style="text-decoration:none;" class="red">Delete Photo</a> <?php endif; ?>
                    </nobr>
                </td>
            </tr>
            <?php endfor; endif; ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->