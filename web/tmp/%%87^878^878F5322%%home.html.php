<?php /* Smarty version 2.6.13, created on 2012-12-20 15:06:46
         compiled from application/axisweb//home.html */ ?>
<div id="breadcumb" class="wrapper">
</div><!-- end #breadcumb -->
<?php echo $this->_tpl_vars['slider_default']; ?>

<?php echo $this->_tpl_vars['carousel_banner']; ?>


<script>
postGCS = '<?php echo $this->_tpl_vars['postGCS']; ?>
'; 
<?php echo '
	if(postGCS != \'\'){
		$(\'#querySearch\').val(postGCS);
		searchGCS();
	}
'; ?>

</script>