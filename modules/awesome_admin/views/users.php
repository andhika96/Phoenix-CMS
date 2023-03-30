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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Users' => '']));

	section_content('
	<div class="mb-5">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm" id="ar-listuser">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-users fa-fw me-2"></i> Manage User Account</div>
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div class="ar-fetch" id="ar-listuser-load" data-fetch-user="'.site_url('awesome_admin/getUsers').'" data-url-user="'.site_url('awesome_admin/getUserData?id=').'">
				<div class="row mb-3">
					<div class="col-md-4 mb-2 mb-md-0">
						<div class="form-group">
							<label class="form-label">Search User by Fullname or Username</label>
							<input type="text" name="search_user" class="form-control" v-model="getUser" @keyup="searchUser">
						</div>
					</div>

					<div class="col-md-2 mb-2 mb-md-0">
						<div class="form-group">
							<label class="form-label">Total User</label>
							<div class="mt-2">'.$row_total['num'].'</div>
						</div>
					</div>
				</div>

				<div v-if="loading" class="text-center p-5">
					<div class="spinner-border text-primary mb-2" role="status">
						<span class="sr-only"></span>
					</div>

					<div class="h6">Loading ...</div>
				</div>

				<div v-else-if="statusData == \'failed\'" class="ar-data-status text-center text-danger h5 p-5" style="display: none">
					{{ msgData }}
				</div>

				<div v-else class="ar-data-load" style="display: none">
					<div v-if="loadingnextpage" class="d-flex justify-content-center h5 my-5 py-5 vh-100">Loading ...</div>

					<div v-else>
						<form action="'.site_url('awesome_admin/users').'" method="post" enctype="multipart/form-data" button-block="false" data-reset="true" @submit="submit" ref="formHTML">
							<div class="table-responsive">
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th scope="col" style="width: 5%">
												<div class="d-flex justify-content-center">
													<div class="form-check m-0" style="min-height: 0 !important">
														<input type="checkbox" class="form-check-input" id="clickSelectAll" v-on:click="clickSelectAll">
														<label class="form-check-label" for="clickSelectAll"></label>
													</div>
												</div>
											</th>
											<th scope="col" style="width: 5%">ID</th>
											<th scope="col" style="width: 20%">User</th>
											<th scope="col">Username</th>
											<th scope="col">Email Address</th>
											<th scope="col">Role</th>
											<th scope="col" style="width: 9%">Status</th>
											<th scope="col">Options</th>
										</tr>
									</thead>

									<tbody is="transition-group" name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster">
										<tr class="text-nowrap" v-for="(info, index) in getData" v-bind:key="info.id">
											<td class="align-middle">
												<div class="d-flex justify-content-center">
													<div class="form-check m-0">
														<input type="checkbox" name="getSelected[]" class="form-check-input checkids" v-on:click="clickCheckbox(info.id)" v-bind:id="\'user_\'+info.id" v-bind:value="info.id">
														<label class="form-check-label" v-bind:for="\'user_\'+info.id"></label>
													</div>
												</div>
											</td>
											<td class="align-middle">#{{ info.id }}</td>
											<td class="align-middle">
												<div class="d-flex align-items-center">
													<div class="flex-shrink-0">
														<span v-if="info.avatar == \'\'">
															<i class="fas fa-user-circle fa-fw rounded-circle mr-2 float-left" style="width: 32px;height: 32px;font-size: 32px"></i>
														</span>

														<span v-else>
															<img :src="\'\'+info.avatar+\'\'" class="rounded-circle mr-2 float-left" style="width: 32px;height: 32px">
														</span>
													</div>

													<div class="flex-grow-1 ms-3">
														{{ info.fullname }}
													</div>
												</div>
											</td>
											<td class="align-middle"><span class="d-block text-muted">@{{ info.username }}</span></td>
											<td class="align-middle">{{ info.email }}</td>
											<td class="align-middle">{{ info.role }}</td>
											<td class="align-middle"><span v-html="info.status"></span></td>
											<td class="align-middle">
												<a href="javascript:void(0);" v-on:click="clickUserModal(info.id)" class="btn btn-success btn-user-detail"><i class="fas fa-cog"></i></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="row mt-2">
								<div class="col-md-3 pr-md-0 mb-3 mb-md-0">
									<select name="changestatus" class="form-select font-size-inherit">
										<option value="">Change Status</option>
										<option value="0">Active</option>
										<option value="1">Not Active</option>
									</select>
								</div>

								<div class="col-md-3 pr-md-0 mb-3 mb-md-0">
									<select name="changerole" class="form-select font-size-inherit">
										<option value="">Change Role</option>');

								$blacklist_role = [
									'administrator',
									'web_master',
									'owner',
									'staff',
									'moderator',
									'author',
									'marketing'
								];
									
								while ($row = $db->sql_fetch_single($res_role)) 
								{
									if ( ! in_array($row['code_name'], $blacklist_role))
									{
										section_content('
										<option value="'.$row['id'].'">'.$row['name'].'</option>');	
									}
								}

		section_content('
									</select>
								</div>

								<div class="col">
									<input type="hidden" name="step" value="post">
									<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
									<input type="submit" class="btn btn-malika-submit font-size-inherit" value="Submit">
								</div>
							</div>
						</form>
					</div>

					<paginate :page-count="pageCount" :page-range="pageRange" :container-class="\'pagination mt-4\'" :page-class="\'page-item\'" :prev-class="\'page-item\'" :next-class="\'page-item\'" :page-link-class="\'page-link font-size-inherit\'" :prev-link-class="\'page-link font-size-inherit\'" :next-link-class="\'page-link font-size-inherit\'" :click-handler="clickPaginate" v-model="currPage"></paginate>

					<!-- Modal -->
					<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="userModalLabel">User Detail</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body p-4">
									<div class="media">
										<span class="ar-avatar-box">
											<i class="fas fa-user-circle align-self-center ar-avatar-default mr-2" style="width: 50px;height: 50px;font-size: 50px;display: none"></i>
											<img src="" class="mr-2 rounded-circle align-self-center ar-avatar-user" style="width: 50px;height: 50px;display: block" alt="Avatar User">
										</span>

										<div class="media-body mt-1">
											<h6 class="my-0 ar-fullname"></h6>
											<p class="mb-0 text-muted font-size-normal ar-username"></p>
										</div>
									</div>

									<div class="border-top mt-3 pt-3">
										<div class="mb-3 ar-email"></div>
										<div class="mb-3 ar-status"></div>
										<div class="mb-3 ar-role"></div>
										<div class="mb-3 ar-gender"></div>
										<div class="mb-3 ar-birthdate"></div>
										<div class="mb-3 ar-phone-number"></div>
										<div class="ar-about"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal End -->
				</div>
			</div>
		</div>
	</div>');

?>