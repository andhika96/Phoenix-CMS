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

	defined('MODULEPATH') OR exit('No direct script access allowed');

	echo '
	<div class="container py-3 py-md-5" id="ar-app-listdata-article">
		<div class="pb-3 pb-md-5">
			<div class="h2 fw-bold">Our News</div> <p>find the latest news from us</p>
		</div>

		<!-- List View -->
		<div class="row ph-list-view ar-fetch-listdata" id="ar-data" data-url="'.site_url('news/getListPosts').'">
			<div class="col-lg-8 col-xl-9">
				<div v-if="loading" class="text-center my-5 py-5 vh-100">
					<div class="spinner-border text-info mb-2" role="status">
						<span class="sr-only"></span>
					</div>

					<div class="h5">Loading ...</div>
				</div>

				<div v-else-if="statusData == \'failed\'" class="ar-data-status" style="display: none">
					<div class="d-flex justify-content-center h5 my-5 py-5 vh-100 text-danger">
						{{ msgData }}
					</div>
				</div>

				<div v-else class="ar-data-load" style="display: none">
					<div v-if="loadingnextpage" class="text-center my-5 py-5 vh-100">
						<div class="spinner-border text-info mb-2" role="status">
							<span class="sr-only"></span>
						</div>

						<div class="h5">Loading ...</div>
					</div>	

					<div v-else>
						<transition-group name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster" tag="div">
							<div class="ph-news d-block d-md-inline-flex w-100 mb-4" v-for="(info, index) in getData" v-bind:key="info.id">

								<div class="thumbnail">
									<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="stretched-link">
										<div class="tag">{{ info.category }}</div>
										<div class="image" :style="{ \'background-image\': \'url(\' + info.thumb_s + \')\' }"></div>
									</a>
								</div> 
								
								<div class="details">
									<div class="wrapper">
										<div class="text-muted text-small d-inline-block mb-3 me-2"><i class="fas fa-user fa-fw"></i> {{ info.user }}</div> 
										<div class="text-muted text-small d-inline-block mb-3"><i class="fas fa-clock fa-fw"></i> {{ info.get_date }}</div> 

										<h3 class="title mb-3">
											<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="stretched-link"><span>{{ info.title }}</span></a>
										</h3> 
										
										<p class="mb-3">{{ info.content }}</p>

										<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="more_listing text-mg-red">Read More</a>
									</div>
								</div>
							
							</div>
						</transition-group>
					</div>

					<div class="w-100">
						<paginate :page-count="pageCount" :page-range="pageRange" :margin-pages="0" :container-class="\'ph-pagination pagination flex-wrap justify-content-center mt-5\'" :page-class="\'page-item\'" :prev-class="\'page-item\'" :next-class="\'page-item\'" :page-link-class="\'page-link font-size-inherit\'" :prev-link-class="\'page-link font-size-inherit\'" :next-link-class="\'page-link font-size-inherit\'" :click-handler="clickPaginate" v-model="currentPage"></paginate>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-xl-3">
				<div class="border border-radius-10 p-4 mb-4">
					<h6 class="mb-3">Search</h6>

					<div class="input-group ph-search-container mb-3">
						<input type="text" class="form-control font-size-inherit" placeholder="Search by title" aria-label="Search by title" aria-describedby="search-news" v-model="getSearch" @keyup="searchData">
						<span class="input-group-text" id="search-news"><i class="fas fa-search font-size-inherit"></i></span>
					</div>
				</div>';

		if (get_layout('news', 'is_hide_category') !== 1)
		{
			echo '
				<div class="border border-radius-10 p-4">
					<h6 class="mb-2">News Categories</h6>

					<ul class="list-group list-group-flush ph-list-group-flush">';

					foreach ($category as $key => $value) 
					{
						echo '
						<li class="list-group-item">
							<a href="javascript:void(0)" @click.prnews="clickCategory('.$value['id'].')">
								'.$value['name'].'
							</a>
						</li>';
					}
		}

	echo '
					</ul>
				</div>
			</div>
		</div>
	</div>';

?>