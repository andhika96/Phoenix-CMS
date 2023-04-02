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
		<div class="ar-fetch-listdata" id="ar-data" data-url="'.site_url('news/getListPosts').'">
			<div class="pb-5">
				<div class="row">
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="h2 fw-bold">Our News</div> <p>find the latest news from us '.get_layout('news', 'is_hide_category').'</p>
					</div>';

			if (get_layout('news', 'is_hide_category') == 1)
			{
				echo '
					<div class="col-md-4 offset-md-4">
						<label class="form-label">Search</label>
						<div class="input-group ph-search-container">
							<input type="text" class="form-control font-size-inherit" placeholder="Search by title" aria-label="Search by title" aria-describedby="search-news" v-model="getSearch" @keyup="searchData">
							<span class="input-group-text" id="search-news"><i class="fas fa-search font-size-inherit"></i></span>
						</div>
					</div>';
			}
			else
			{
				echo '
					<div class="col-md-4 mb-3 mb-md-0">
						<label class="form-label">Search</label>
						<div class="input-group ph-search-container">
							<input type="text" class="form-control font-size-inherit" placeholder="Search by title" aria-label="Search by title" aria-describedby="search-news" v-model="getSearch" @keyup="searchData">
							<span class="input-group-text" id="search-news"><i class="fas fa-search font-size-inherit"></i></span>
						</div>
					</div>

					<div class="col-md-4">
						<label class="form-label">Select by Category</label>
						<select name="category" class="form-select font-size-inherit rounded" aria-label="Select Category" v-model="pageCategory" v-on:change="selectCategory()">
							<option value="">All</option>';

					foreach ($category as $key => $value) 
					{
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}

					echo '
						</select>
					</div>';
			}

	echo '

				</div>
			</div>

			<!-- Grid View -->
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

					<transition-group name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster" tag="div" class="row ph-grid-view">
						<div class="col-md-6 col-xl-4" v-for="(info, index) in getData" v-bind:key="info.id">

							<div class="ph-event">
								<div>
									<div class="thumbnail">
										<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="stretched-link">
											<div class="tag">{{ info.category }}</div>
											<div class="image" :style="{ \'background-image\': \'url(\' + info.thumb_s + \')\' }"></div>
										</a>
									</div> 
								
									<div class="details">
										<div class="wrapper">
											<h4 class="title text-truncate mb-3">
												<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="stretched-link"><span>{{ info.title }}</span></a>
											</h4> 
											
											<div class="my-3">{{ info.get_date }}</div> 
											<a :href="\''.site_url('news/\'+info.uri+\'').'\'" class="more_listing text-mg-red">Read More</a>
										</div>
									</div>
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
	</div>';

?>