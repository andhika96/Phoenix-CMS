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

			<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
			<script src="https://unpkg.com/vue-select@latest"></script>
			<script src="https://unpkg.com/lodash@latest/lodash.min.js"></script>
			<script src="https://unpkg.com/vuejs-paginate@latest"></script>
			<script src="https://unpkg.com/vue-lazyload/vue-lazyload.js"></script>
			<script src="'.base_url('assets/js/aruna-vue2022.js?v=0.0.3').'"></script>

			<script src="'.base_url('assets/js/jquery-3.6.0.min.js').'"></script>
			<script src="'.base_url('assets/js/js.cookie-2.2.1.min.js').'"></script>
			<script src="'.base_url('assets/plugins/bootstrap/5.2.3/js/bootstrap.bundle.min.js').'"></script>
			
			'.load_js().'

			<script src="'.base_url('assets/js/aruna-admin-v5.js').'"></script>
		</body>
	</html>');

?>