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

	section_content('
	<div class="container-fluid">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-app-listdata">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center"><div><i class="fas fa-newspaper fa-fw mr-2"></i> List of Posts</div> <div><span class="float-md-right font-size-normal"><a href="'.site_url('manage/addpost').'">Add New Post</a></div></div>
			
			<div class="row mb-2 ar-fetch-listdata" id="ar-data" data-url="'.site_url('manage/getListPosts').'">
				<div class="col-md-4 mb-3 mb-md-0">
					<div class="form-group">
						<label class="form-label">Search Article by Title</label>
						<input type="text" name="search_article" class="form-control" v-model="getSearch" @keyup="searchData">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label">Filter by Category</label>
						<select name="category" v-model="pageCategory" @change="clickCategory(this.value)" class="form-select">
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
					<transition-group name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster" class="list-group list-group-flush ar-list-group-flush" tag="ul">
						<li class="list-group-item list-group-item-action px-0" v-for="(info, index) in getData" v-bind:key="info.id">
							<div class="row no-gutters">
								<div class="col-md-9">
									<div class="row no-gutters">
										<div class="col-12 col-sm-4 pr-sm-3 mb-2 mb-sm-0">
											<div v-if="info.thumb_s == \'\'">
												<div class="d-flex justify-content-center align-items-center text-center rounded ar-thumb-undefined" style="min-width: 235px;min-height: 145px;background: #ccc">
													<div><i class="fa-inverse fab fa-elementor fa-3x"></i></div>
												</div>
											</div>

											<div v-else-if="info.thumb_s == \'undefined\'">
												<div class="d-flex justify-content-center align-items-center text-center rounded ar-thumb-undefined" style="min-width: 235px;min-height: 145px;background: #ccc">
													<div><i class="fa-inverse fas fa-image fa-3x"></i></div>
												</div>
											</div>

											<div v-else>
												<div class="d-flex justify-content-center align-items-center text-center rounded shadow-sm ar-img" :style="{ \'background-image\': \'url(\' + info.thumb_s + \')\', \'background-position\': \'center center\', \'background-size\': \'cover\', \'background-repeat\': \'no-repeat\' }"></div>
											</div>
										</div>

										<div class="col-12 col-sm-8 text-left">
											<h5 class="line-height-6 text-truncate">{{ info.title }}</h5>
											<p class="font-size-inherit mb-2">{{ info.content }}</p>
											<div class="text-muted">{{ info.created_post }} <span v-html="info.scheduled"></span></div>
										</div>
									</div>
								</div>

								<div class="col-md-3 d-flex align-items-center justify-content-end">
									<a :href="\''.site_url('manage/editpost/\'+info.id+\'').'\'" class="mr-1">Edit</a> - <a href="javascript:void(0)" v-on:click="deleteData(getData, index, info.id); show = !show" class="ar-alert-bootbox ml-1" v-bind:data-url="\''.site_url('manage/deletepost/').'\'">Delete</a>
								</div>
							</div>
						</li>
					</transition-group>
				</div>

				<paginate :page-count="pageCount" :page-range="pageRange" :container-class="\'pagination flex-wrap justify-content-center mt-5\'" :page-class="\'page-item\'" :prev-class="\'page-item\'" :next-class="\'page-item\'" :page-link-class="\'page-link\'" :prev-link-class="\'page-link\'" :next-link-class="\'page-link\'" :click-handler="clickPaginate" v-model="currentPage"></paginate>
			</div>
		</div>
	</div>');

?>