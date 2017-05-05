<?php /* Smarty version 2.6.13, created on 2012-11-13 11:23:57
         compiled from application/axisweb/widgets/isi_pulsa.html */ ?>

<div id="pilihWilayah" class="formBox isiUlang">
    <div class="headBox">
        <h1 class="icon_reloaded"><?php echo $this->_tpl_vars['locale']['widget']['belipulsa']; ?>
</h1>
    </div><!-- end .headBox -->
    <div class="entryBox">
        <form class="pilihWilayah">
            <input type="text" value="Masukkan Nomor Axis" onBlur="if(this.value=='')this.value='Masukkan Nomor Axis';" onFocus="if(this.value=='Masukkan Nomor Axis')this.value='';" />
            <div class="rowBtns">
            <select class="styled"/>
                <option><?php echo $this->_tpl_vars['locale']['widget']['nominalpulsa']; ?>
</option>
                <option>Rp.100.000</option>
                <option>Rp.50.000</option>
                <option>Rp.25.000</option>
                <option>Rp.10.000</option>
                <option>Rp.5.000</option>
            </select>
            </div>
            <div class="rowBtns">
            <select class="styled"/>
                <option><?php echo $this->_tpl_vars['locale']['widget']['carabayar']; ?>
</option>
                <option>Bank Transfer</option>
                <option>Paypal</option>
            </select>
            </div>
            <input type="submit" value="<?php echo $this->_tpl_vars['locale']['btn']['segerahadir']; ?>
" />
        </form>
    </div><!-- end .entryBox -->
    <div class="shadow"></div>
</div><!-- end #pilihWilayah -->