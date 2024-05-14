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

	if (get_module_actived('news') == 0)
	{
		section_content('
		<div class="bg-warning p-3 rounded mb-3 text-dark bg-opacity-25">
			<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> '.t('The {1} page has been disabled, but you can still manage content from this page', ucfirst(get_module('news', 'name'))).'
		</div>');
	}

	section_content('
	<style>
	.preview img
	{
		max-width: 100%;
		max-height: 111px;
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		overflow: hidden;
	}

	.preview2 img
	{
		max-inline-size: 100%;
		block-size: auto;
		aspect-ratio: 2/1;
		object-fit: cover;
	}
	</style>

	<div class="container-fluid px-0">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-app-listdata-article-cms">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center"><div><i class="fad fa-newspaper fa-fw me-2"></i> '.t('Manage News').'</div> <div><span class="float-md-right font-size-normal"><a href="'.site_url('manage_news/addpost').'">Add New Post</a></div></div>
			
			<div class="row mb-2 ar-fetch-listdata" id="ar-data" data-url="'.site_url('manage_news/getListPosts').'">
				<div class="col-md-4 mb-3 mb-md-0">
					<div class="form-group">
						<label class="form-label">Search News by Title</label>
						<input type="text" name="search_article" class="form-control font-size-inherit" v-model="getSearch" @keyup="searchData">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label">Filter by Category</label>
						<select name="category" v-model="pageCategory" @change="clickCategory(this.value)" class="form-select font-size-inherit">
							<option value="">All</option>');

					$res = $db->sql_select("select id, name from ml_blog_category order by id desc");
					while ($row = $db->sql_fetch_single($res))
					{
						section_content('
							<option value="'.$row['id'].'">'.$row['name'].'</option>');
					}

		section_content('
						</select>
					</div>
				</div>
			</div>

			<div v-if="loading" class="text-center my-5 py-5">
				<div class="spinner-border text-info mb-2" role="status">
					<span class="sr-only"></span>
				</div>

				<div class="h5">Loading ...</div>
			</div>

			<div v-else-if="statusData == \'failed\'">
				<div class="d-flex justify-content-center h5 my-5 py-5 text-danger">
					{{ msgData }}
				</div>
			</div>

			<div v-else>
				<div v-if="loadingnextpage" class="text-center my-5 py-5">
					<div class="spinner-border text-info mb-2" role="status">
						<span class="sr-only"></span>
					</div>

					<div class="h5">Loading ...</div>
				</div>

				<div v-else>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th scope="col" style="width: 35%">Title</th>
									<th scope="col" style="width: 8%">Thumbnail</th>
									<th scope="col" style="width: 10%">Scheduled</th>
									<th scope="col" style="width: 10%">Status</th>
									<th scope="col" style="width: 10%">Created</th>
									<th scope="col" style="width: 10%">Option</th>
								</tr>
							</thead>

							<tbody is="transition-group" name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster">
								<tr v-for="(info, index) in getData" v-bind:key="info.id">
									<td class="align-middle text-nowrap text-truncate fw-bold d-table-cell d-md-none" style="max-width: 250px">{{ info.title }}</td>
									<td class="align-middle text-nowrap text-truncate fw-bold d-none d-md-table-cell" style="max-width: 250px">{{ info.title }}</td>
									
									<td class="align-middle text-nowrap">
										<img :src="\'\'+info.thumb_s2+\'\'" style="max-width: 50px;max-height: 50px">
									</td>
									
									<td class="align-middle text-nowrap">
										<span v-html="info.scheduled"></span>
									</td>

									<td class="align-middle text-nowrap">
										<span v-html="info.get_status"></span>
									</td>

									<td class="align-middle text-nowrap">
										<div class="text-muted">{{ info.get_created }}</div>
									</td>

									<td class="align-middle text-nowrap" :id="\'ar-table-td-options-\'+index+\'-\'+info.id+\'\'">
										<a :href="\''.site_url('manage_news/editpost/\'+info.id+\'').'\'" class="btn btn-light font-size-inherit"><i class="fas fa-edit"></i></a>
										<a href="javascript:void(0)" v-on:click="deleteDataConfirmation(getData, index, info.id)" class="ar-delete-data btn btn-light text-danger font-size-inherit ms-1" v-bind:data-url="\''.site_url('manage_news/deletepost/').'\'"><i class="fas fa-trash"></i></a>
	
										<!--- Modal Notice Delete Item --->
										<div class="modal fade" :id="\'ModalPopupNoticeDeleteData_\'+index+\'\'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :aria-labelledby="\'ModalPopupNoticeDeleteData_\'+index+\'Label\'" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content" :id="\'ar-form-submit-cf-\'+index">
													<form :action="\''.site_url('manage_news/deletepost/\'+info.id+\'').'\'" method="get" @submit="submitConfirmation($event, getData, index)" :ref="\'formHTML\'+index" button-block="false" button-rounded-pill="false" font-size-large="false">
														<div class="modal-header">
															<h1 class="modal-title fs-5" :id="\'ModalPopupNoticeDeleteData_\'+index+\'Label\'">
															<i class="fas fa-exclamation-triangle fa-fw text-warning me-1"></i>Notice</h1>
														</div>

														<div class="modal-body text-wrap">
															Are you sure to delete this item?
														</div>

														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
															
															<input type="hidden" name="article_id" :value="\'\'+info.id+\'\'">
															<input type="hidden" :class="\'btn-token-submit-cf-\'+index+\'\'" name="'.$csrf_name.'" value="'.$csrf_hash.'">
															<input type="submit" :class="\'btn btn-malika-submit btn-malika-submit-cf-\'+index+\'\'" value="Yes">
														</div>
													</form>
												</div>
											</div>
										</div>
										<!--- Modal Notice Delete Item --->

									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<paginate :page-count="pageCount" :page-range="pageRange" :container-class="\'pagination flex-wrap justify-content-center mt-5\'" :page-class="\'page-item font-size-inherit\'" :prev-class="\'page-item font-size-inherit\'" :next-class="\'page-item font-size-inherit\'" :page-link-class="\'page-link font-size-inherit\'" :prev-link-class="\'page-link font-size-inherit\'" :next-link-class="\'page-link font-size-inherit\'" :click-handler="clickPaginate" v-model="currentPage"></paginate>
			</div>
		</div>
	</div>');

?>