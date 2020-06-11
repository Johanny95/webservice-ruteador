	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 2.4.0
		</div>
		<strong>Copyright &copy; 2017-2018 <a href="https://adminlte.io">Producto Fernández S.A</a>.</strong> Todos los derechos reservados.
	</footer>
	<?php if ($this->session->login == TRUE || $this->session->login != NULL): ?>
		<script type="text/javascript">

			function dinamicMenu() {
				var url = window.location;
				var aux = url.href.split('/');
				var path = url.href;
				if($.isNumeric(aux[aux.length-1]))
				{
					var aux_url = path.substring(0, path.length-1);
					path = aux_url+"1";
				}
				$('.sidebar-menu li a[href="' + path + '"]').parent().addClass('active');
				$('.treeview-menu li a[href="' + path + '"]').parent().addClass('active');
				$('.treeview-menu li a').filter(function() {
					return this.href == path;
				}).parent().parent().parent().addClass('active');
			}

			$(function() {
				dinamicMenu();
			});
			
			
			var intervalo = <?php echo $this->config->item('ajax_timeout') ?>;
			setInterval(checkSession, intervalo*60*1000);
			function checkSession() {
				$.ajax({
					url: "<?php echo site_url('session') ?>",
					dataType: 'json',
					error: function(){
						window.location = '<?php echo site_url('cerrar_sesion') ?>';
					}
				});
			}
		</script>
	<?php endif ?>
	
	<?php echo put_footer()?>
	<?php echo put_footer_dy()?>
	
	<?php echo $this->config->item('js_bloc')?>
</body>
</html>