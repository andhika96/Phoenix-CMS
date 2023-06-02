<?php

	/*
	 *	Aruna Development Project
	 *	IS NOT FREE SOFTWARE
	 *	Codename: Aruna Personal Site
	 *	Source: Based on Sosiaku Social Networking Software
	 *	Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *	Created and developed by Andhika Adhitia N
	 */

	defined('THEMEPATH') OR exit('No direct script access allowed');

	section_footer('
			<!-- Optional JavaScript -->
			<!-- VueJS first, the second jQuery, then Bootstrap JS, and other -->			
			<script>let baseurl = "'.base_url().'"; let siteurl = "'.site_url().'";</script>

			<script src="'.base_url('assets/plugins/axios/0.27.2/axios.min.js').'"></script>
			
			<script src="'.base_url('assets/js/vuejs-2.6.14.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-select-3.18.3.min.js').'"></script>
			<script src="'.base_url('assets/js/lodash-4.17.21.min.js').'"></script>
			<script src="'.base_url('assets/js/vuejs-paginate-2.1.0.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-lazyload-1.3.3.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-cookies-1.8.3.js').'"></script>
			<script src="'.base_url('assets/js/aruna-vue2022.js?v=0.0.13').'"></script>

			<script src="'.base_url('assets/js/jquery-3.6.0.min.js').'"></script>
			<script src="'.base_url('assets/plugins/bootstrap/5.3.0/js/bootstrap.bundle.min.js').'"></script>
			
			'.load_js().'

			<script src="'.base_url('assets/js/aruna-admin-v5.js').'"></script>
		</body>
	</html>');

?>