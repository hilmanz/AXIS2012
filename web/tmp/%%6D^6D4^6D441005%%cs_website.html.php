<?php /* Smarty version 2.6.13, created on 2012-12-17 17:40:09
         compiled from application/admin/message/cs_website.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'application/admin/message/cs_website.html', 52, false),)), $this); ?>
<div class="theContent">
    <div class="theTitle">
        <h2>Message CS Website</h2>
        <a href="index.php?s=message&act=excel_message&search=<?php echo $this->_tpl_vars['search']; ?>
" class="btn btn_document"><span>Download XLS</span></a>
    </div><!--contenttitle-->
    <div class="tableoptions">   
    
			<form>
            	<span>Search</span>
				<input type="text" name="search" value="<?php echo $this->_tpl_vars['search']; ?>
"/>
				 <span>Date Range</span>
				<input type="text" name="startdate" value="<?php echo $this->_tpl_vars['startdate']; ?>
" class="datepicker"/>
				<span>s/d </span>				
				<input type="text" name="enddate" value="<?php echo $this->_tpl_vars['enddate']; ?>
" class="datepicker"/>
				<input type="submit" value="cari" class="stdbtn btn_orange"/>
				<input type="hidden" name="s" value="message" />
				<input type="hidden" name="act" value="csWebsite" />
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
                <th class="head0">Nama</th>
                <th class="head1">email</th>
                <th class="head0">Propinsi</th>
                <th class="head1">Kota</th>
                <th class="head0">Telepon</th>
                <th class="head1">Type</th>
                <th class="head0">Message</th>
                <th class="head1">Post Date</th>
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
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['nama']; ?>
&nbsp;</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['email']; ?>
</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['province']; ?>
</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['city']; ?>
</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['telepon']; ?>
</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['type']; ?>
</td>
            <td><?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['message']; ?>
</td>
            <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['list'][$this->_sections['i']['index']]['date_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
            <td align="center" width="4%"><a class="green" href="index.php?s=message&act=detail_csWebsite&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="text-decoration:none;" >View</a></td>
            <td align="center" width="4%"><a class="red" href="index.php?s=message&act=hapus_csWebsite&id=<?php echo $this->_tpl_vars['list'][$this->_sections['i']['index']]['id']; ?>
" style="text-decoration:none;" onclick="return confirm('Are you sure you want to delete this?')">Delete</a></td>
          </tr>
          <?php endfor; endif; ?>
        </tbody>
    </table>
    <div class="paging">
    	<?php echo $this->_tpl_vars['paging']; ?>

    </div>
</div><!--theContent-->