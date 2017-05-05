<?php /* Smarty version 2.6.13, created on 2012-12-17 17:54:56
         compiled from application/admin/news/news_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'application/admin/news/news_list.html', 49, false),array('modifier', 'capitalize', 'application/admin/news/news_list.html', 64, false),)), $this); ?>

<div class="theContent">
    <div class="theTitle">
        <h2>Coorporate News</h2>
        <a href="index.php?s=coorporate_news&act=excelreport&lid=<?php echo $this->_tpl_vars['lid']; ?>
&id_cat=<?php echo $this->_tpl_vars['id_cat']; ?>
&id_type=<?php echo $this->_tpl_vars['id_type']; ?>
" class="btn btn_document"><span>Download XLS</span></a>
        <a href="index.php?s=coorporate_news&act=add" class="btn btn_pencil"><span>Add New</span></a>
    </div><!--contenttitle-->
    <div class="tableoptions">  
			<form>
				<input type="hidden" name="s" value="coorporate_news" />
				<select name="lid" style="width:200px;">
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
				 <span>Date Range</span>
				<input type="text" name="startdate" value="<?php echo $this->_tpl_vars['startdate']; ?>
" class="datepicker"/>
				<span>s/d</span>
				<input type="text" name="enddate" value="<?php echo $this->_tpl_vars['enddate']; ?>
" class="datepicker"/>
				<input type="submit" value="cari"  class="stdbtn btn_orange"/>
			</form>
    </div><!--tableoptions-->	
    <table cellpadding="0" cellspacing="0" border="0" id="table1" class="stdtable">
        <thead>
            <tr>
                <th class="head0">No</th>
                <th class="head1">Language</th>
                <th class="head0">Title</th>
                <th class="head1">Created Date</th>
                <th class="head0">Published Date</th>
                <th class="head1">Unpublished Date</th>
                <th class="head0">Status</th>
                <th class="head1">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
            <?php $this->assign(false, $this->_tpl_vars['no']++); ?>
            <?php $this->assign('lid', $this->_tpl_vars['v']['lid']); ?>
            <tr>
                <td width="3%"><?php echo $this->_tpl_vars['no']; ?>
</td>
                <td><?php echo $this->_tpl_vars['v']['language_data']['langDesc'][$this->_tpl_vars['lid']]; ?>
</td>
                <td><?php echo $this->_tpl_vars['v']['title']; ?>
</td>
                <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['created_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['created_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['posted_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                <td width="10%"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['expired_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
 &nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['expired_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['time']['time']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['time']['time'])); ?>
</nobr></td>
                
                <td align="center">
                    <?php if ($this->_tpl_vars['v']['n_status'] == 0): ?> Inactive 
                    <?php elseif ($this->_tpl_vars['v']['n_status'] == 1): ?> Publish 
                    <?php elseif ($this->_tpl_vars['v']['n_status'] == 2): ?> Unpublish
                    <?php else: ?>
                    <?php endif; ?>
                </td>
                
                <td width="10%">
                    <nobr>
                    <?php $_from = $this->_tpl_vars['v']['language_data']['langDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['klang'] => $this->_tpl_vars['vlang']):
?>
                        <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['vlang'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</strong>
                        <?php if ($this->_tpl_vars['v']['language_data'][$this->_tpl_vars['klang']] == 1): ?>
                            <a href="index.php?s=coorporate_news&act=edit&id=<?php echo $this->_tpl_vars['v']['parentid']; ?>
&lid=<?php echo $this->_tpl_vars['klang']; ?>
" class="green"> update </a>
                            
                           | <a href="javascript:void(0)" class="popuppreview" url="http://axis-preview.kanadigital.com/corporate/index.php?page=berita&act=detail&id=<?php echo $this->_tpl_vars['v']['parentid']; ?>
" class="blue">preview</a> 
                            | <a href="index.php?s=coorporate_news&act=hapus&parentid=<?php echo $this->_tpl_vars['v']['parentid']; ?>
" class="red"onclick="return confirm('Are you sure you want to delete this?')">delete</a>
                            </p>
                        <?php else: ?>
                            <a href="index.php?s=coorporate_news&act=add_language&id=<?php echo $this->_tpl_vars['v']['parentid']; ?>
&id_lang=<?php echo $this->_tpl_vars['klang']; ?>
" class="green"> add </a>
                             </p>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
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