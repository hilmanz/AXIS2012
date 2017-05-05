<?php /* Smarty version 2.6.13, created on 2012-12-19 17:13:35
         compiled from common/admin/user_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'common/admin/user_edit.html', 13, false),)), $this); ?>
<div class="theContent">
    <div class="theTitle">
        <h2>EDIT ACCOUNTS</h2>
        <a href="?s=admin&amp;r=users&amp;do=new" class="btn btn_pencil"><span>New User Account</span></a>
        <a href="?s=admin&amp;r=users" class="btn btn_link"><span>Back</span></a>
    </div><!--contenttitle-->
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable inputable">
        <tbody>
        	
        <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
                <tr>
                    <td colspan="2"><strong>Username :</strong><span class="pink"> <?php echo $this->_tpl_vars['rs']['username']; ?>
</span>
                    <input name="username" type="hidden" id="username" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['rs']['username'])) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" />
                    </td>
                </tr>
                <tr>
                    <td width="150"><strong>Change Password</strong></td>
                    <td><input type="password" name="password" id="password" /> 
                    Max : 10 alphanumeric character(s) <br />
                    </td>
                </tr>
                <tr>
                    <td><strong>Confirm Password</strong></td>
                    <td><input type="password" name="confirm" id="confirm" /> 
                    Max : 10 alphanumeric character(s) <br />
                    <span style="color:#FF0000;"><?php echo $this->_tpl_vars['rs']['e2']; ?>
</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Level</strong></td>
                    <td>
                        <select name="level" id="level">
                            <option value="4">Pick admin level</option>
                            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['level']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                            <?php if ($this->_tpl_vars['level'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['rs']['level']): ?>
                            <option value="<?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['level']; ?>
</option>
                            <?php else: ?>
                            <option value="<?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['level']; ?>
</option>
                            <?php endif; ?>
                            <?php endfor; endif; ?>
                        </select>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td><strong>Content Category</strong></td>
                    <td>
                        <select name="categoryid" style="width:200px;">
                            <option value=""> - All Category - </option>
                            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['category']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                            <?php if ($this->_tpl_vars['level'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['rs']['level']): ?>	<option value="<?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['level'][$this->_sections['i']['index']]['level']; ?>
</option>
                            <?php else: ?><option value="<?php echo $this->_tpl_vars['category'][$this->_sections['i']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['category'][$this->_sections['i']['index']]['category']; ?>
</option>
                            <?php endif; ?>
                            <?php endfor; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Position</strong></td>
                    <td><input name="position" type="text" id="position" value="<?php echo $this->_tpl_vars['rs']['position']; ?>
" />
                    Max : 20 alphanumeric character(s) <br />
                    </td>
                </tr>
                <tr>
                    <td><strong>Full Name</strong></td>
                    <td><input name="name" type="text" id="name" value="<?php echo $this->_tpl_vars['rs']['name']; ?>
" />
                    Max : 50 alphanumeric character(s) <br />
                    </td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td><input name="email" type="text" id="email" value="<?php echo $this->_tpl_vars['rs']['email']; ?>
" />
                    mail format (example) : admin@kana.co.id <br />
                    </td>
                </tr>
                <tr>
                    <td valign="top"><strong>Emblem</strong></td>
                    <td>
                    <p><img src="<?php echo $this->_tpl_vars['baseurl']; ?>
public_assets/emblem/<?php echo $this->_tpl_vars['rs']['emblem']; ?>
" id="previews"/></p><br />
                    <p><input name="emblem" type="file" id="emblem"/></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input class="update" type="submit" name="button" id="button" class="stdbtn btn_orange" value="UPDATE" />
                    <input name="s" type="hidden" id="s" value="admin" />
                    <input name="r" type="hidden" id="r" value="users" />
                    <input name="do" type="hidden" id="do" value="simpan" />
                    <input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['rs']['userID']; ?>
" /></td>
                </tr>
        </form>
        </tbody>
            </table>
</div><!--theContent-->