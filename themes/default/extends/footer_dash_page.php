<?php

	defined('THEMEPATH') OR exit('No direct script access allowed');

	section_footer('
			</div>
			<!--- End of Ardev v6 Container Theme --->

			<!-- Optional JavaScript -->
			<!-- VueJS first, the second jQuery, then Bootstrap JS, and other -->			
			<script>let baseurl = "'.base_url().'"; let siteurl = "'.site_url().'";</script>

			<script src="'.base_url('assets/js/croppie-2.6.5.min.js').'"></script>
			<script src="'.base_url('assets/plugins/axios/0.27.2/axios.min.js').'"></script>

			<script src="'.base_url('assets/js/vuejs-2.6.14.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-select-3.18.3.min.js').'"></script>
			<script src="'.base_url('assets/js/lodash-4.17.21.min.js').'"></script>
			<script src="'.base_url('assets/js/vuejs-paginate-2.1.0.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-lazyload-1.3.3.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-cookies-1.8.3.js').'"></script>

			<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>

			<script src="'.base_url('assets/js/jquery-3.7.0.min.js').'"></script>
			<script src="'.base_url('assets/plugins/spectrum/dist/spectrum.min.js').'"></script>
			<script src="'.base_url('assets/plugins/iconpicker/dist/iconpicker-1.5.0.js').'"></script>
			<script src="'.base_url('assets/plugins/bootstrap/5.3.2/js/bootstrap.bundle.min.js').'"></script>
			<script src="'.base_url('assets/plugins/bootbox/6.0.0/bootbox.all.min.js?v='.time()).'"></script>

			<!-- <script src="'.base_url('assets/plugins/fontawesome/5.15.3/js/all.min.js').'"></script> -->

			<script src="'.base_url('assets/js/simplebar-5.3.6.min.js').'"></script>

			<script src="'.base_url('assets/js/aruna-vue2022.js?v='.time()).'"></script>
			<script src="'.base_url('assets/js/aruna-admin-v5.js?v=1.0.2').'"></script>

			<script>
			const tooltipTriggerList = document.querySelectorAll("[data-bs-toggle=\'tooltip\']");

			tooltipTriggerList.forEach((el) => 
			{
				new bootstrap.Tooltip(el);
			});

			if (document.querySelector(".color-picker-for-jquery") !== undefined)
			{
				$(document).ready(function() 
				{
					$(".color-picker-for-jquery").spectrum({
						type: "component",
						showInput: true,
						showInitial: true
					});
				});
			}
			</script>

			'.load_js().'			
		</body>
	</html>');

?>