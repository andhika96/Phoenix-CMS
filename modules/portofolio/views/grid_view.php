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
		<div class="ar-fetch-listdata ar-fetch-data-modal" id="ar-data" data-url="'.site_url('portofolio/getListPosts').'" data-modal-url="'.site_url('portofolio/getDetail').'">
			<div class="pb-5">
				<div class="row">
					<div class="col-md-4 mb-3 mb-md-0">
						<div class="h2 fw-bold">Our Portofolio</div> <p>find the latest portofolio from us '.get_layout('portofolio', 'is_hide_category').'</p>
					</div>';

			if (get_layout('portofolio', 'is_hide_category') == 1)
			{
				echo '
					<div class="col-md-4 offset-md-4">
						<label class="form-label">Search</label>
						<div class="input-group ph-search-container">
							<input type="text" class="form-control font-size-inherit" placeholder="Search by title" aria-label="Search by title" aria-describedby="search-portofolio" v-model="getSearch" @keyup="searchData">
							<span class="input-group-text" id="search-portofolio"><i class="fas fa-search font-size-inherit"></i></span>
						</div>
					</div>';
			}
			else
			{
				echo '
					<div class="col-md-4 mb-3 mb-md-0">
						<label class="form-label">Search</label>
						<div class="input-group ph-search-container">
							<input type="text" class="form-control font-size-inherit" placeholder="Search by title" aria-label="Search by title" aria-describedby="search-portofolio" v-model="getSearch" @keyup="searchData">
							<span class="input-group-text" id="search-portofolio"><i class="fas fa-search font-size-inherit"></i></span>
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

							<div class="ph-portofolio">
								<div>
									<div class="thumbnail">
										<a href="javascript:void(0)" v-on:click="openDataModal(info.uri)" class="stretched-link">
											<div class="tag">{{ info.category }}</div>
											<div class="image" :style="{ \'background-image\': \'url(\' + info.thumb_s + \')\' }"></div>
										</a>
									</div> 
								
									<div class="details">
										<div class="wrapper">
											<h4 class="title text-truncate mb-3">
												<a href="javascript:void(0)" v-on:click="openDataModal(info.uri)" class="stretched-link"><span>{{ info.title }}</span></a>
											</h4> 
											
											<div class="my-3">{{ info.get_date }}</div> 
											<a href="javascript:void(0)" v-on:click="openDataModal(info.uri)" class="more_listing text-mg-red">Read More</a>
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

				<!-- Modal -->
				<div class="modal fade" id="detailModalPortofolio" tabindex="-1" aria-labelledby="detailModalPortofolioLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-body p-md-4">
								<div class="ar-modal-data-load text-center p-5" style="display: block">
									<div class="spinner-border text-info mb-2" role="status">
										<span class="sr-only"></span>
									</div>

									<div class="h5 m-0">Loading ...</div>
								</div>

								<div v-for="(info, index) in getDataModal" v-bind:key="info.id" class="ar-modal-data-list" style="display: none">
									<div class="mb-4 shadow-sm" v-html="info.thumb_l"></div>
									<div class="mb-4 h4">{{ info.title }}</div>
									<div class="ph-text-article" v-html="info.converted_content"></div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>';

?>