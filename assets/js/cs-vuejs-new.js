// VueJS 2

Vue.component('paginate', VuejsPaginate);

Vue.component('v-select', VueSelect.VueSelect);

Vue.use(VueLazyload, 
{
	observer: true,
	error: 'assets/plugins/fontawesome/5.15.3/svgs/brands/elementor.svg',
	loading: 'assets/plugins/fontawesome/5.15.3/svgs/solid/redo-alt.svg'
});

const Vue2Form = new Vue(
{
	el: "#ar-app-form",
	data: 
	{
		form: {},
		responseMessage: '',
		initResponse: [],
		initForm: 
		{
			'email': null,
			'username': null,
			'fullname': null,
			'password': null,
			'agreecheck': null,
		}
	},
	methods: 
	{
		submitWithAuth: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("method");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading "+getButtonBlock+" font-size-inherit rounded-pill px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body\">"+this.responseMessage+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonBlock+" font-size-inherit rounded-pill\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						let toast = new bootstrap.Toast(toastBox);
						toast.hide();

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" font-size-inherit rounded-pill px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", Cookies.get("malika_cms2022"));
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body\">"+this.responseMessage+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonBlock+" font-size-inherit rounded-pill px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", Cookies.get("malika_cms2022"));
				}

				console.log("asd");
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		submitWithValidate: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("method");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading font-size-inherit rounded-pill\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						alert('Key URL for redirect after response callback not found!');
						console.log('Key URL for redirect after response callback not found!');

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-primary btn-malika font-size-inherit rounded-pill\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged font-size-inherit rounded-pill\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					// Set to false if all form have no errors
					this.initForm['email'] = false;
					this.initForm['username'] = false;
					this.initForm['fullname'] = false;
					this.initForm['password'] = false;
					this.initForm['agreecheck'] = false;
				}
				else if (response.data.status == 'failed')
				{
					// Get data from response data
					this.responseMessage = response.data.msg;

					// Check variable if form have notice error and set to true
					this.initForm['email'] = (this.responseMessage['email'] != undefined) ? true : false;
					this.initForm['username'] = (this.responseMessage['username'] != undefined) ? true : false;
					this.initForm['fullname'] = (this.responseMessage['fullname'] != undefined) ? true : false;
					this.initForm['password'] = (this.responseMessage['password'] != undefined) ? true : false;
					this.initForm['agreecheck'] = (this.responseMessage['agreecheck'] != undefined) ? true : false;

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded-pill\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		submitData: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("reset");
			let formFileReset = document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("file-reset");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading font-size-inherit rounded\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						let toast = document.getElementsByClassName("sk-notice-toast")[0];
						toast.innerHTML = "<div class=\"ar-alert position-fixed m-3\"><div class=\"toast sk-toast-failed bg-success text-white\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-check mr-2\"></i> Status <button type=\"button\" class=\"ml-2 mb-1 mt-n1 close text-white\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></h5> "+this.responseMessage+"</div></div></div>"; 

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("show");

						if (document.querySelector("#ar-content") !== null)
						{
							document.querySelector("#ar-content").scrollIntoView(true);
						}

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("hide");

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged font-size-inherit rounded\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-app-form").getElementsByTagName("form")[0].reset();
					}

					if (document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
								document.getElementsByClassName("custom-file-label")[i].innerHTML = 'Choose file';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;

					let toast = document.getElementsByClassName("sk-notice-toast")[0];
					toast.innerHTML = "<div class=\"ar-alert position-fixed m-3\"><div class=\"toast sk-toast-failed bg-danger text-white\" data-autohide=\"false\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-exclamation-triangle mr-2\"></i> Notice <button type=\"button\" class=\"ml-2 mb-1 mt-n1 close text-white\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></h5> "+this.responseMessage+"</div></div></div>"; 

					// We still use JQuery because the Toast need JQuery to run
					$(".toast").toast("show");

					if (formReset == "true")
					{
						document.getElementById("ar-app-form").getElementsByTagName("form")[0].reset();
					}

					if (document.getElementById("ar-app-form").getElementsByTagName("form")[0].getAttribute("file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
								document.getElementsByClassName("custom-file-label")[i].innerHTML = 'Choose file';
							}
						}
					}

					if (document.querySelector("#ar-content") !== null)
					{
						document.querySelector("#ar-content").scrollIntoView(true);
					}
					
					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response =>
			{
				console.log(response);
			});
		}
	}
});

const Vue2FormWithList = new Vue(
{
	el: "#ar-app-form-wlist",
	data: 
	{
		form: {},
		showData: true,
		loadingData: true,
		loading: true,
		responseData: '',
		responseMessage: '',
		statusData: '',
		msgData: '',
		initResponse: [],
		getCityId: '',
		getVenueId: '',
		options: [],
		selectedCity: {},
		responseVenue: 		
		{
			data: {},
			selected: '',
		}
	},
	methods: 
	{
		listData: function(withStatus)
		{
			if (document.querySelector(".ar-fetch-list-data") !== null && 
				document.querySelector(".ar-fetch-list-data").getAttribute("data-url") !== null)
			{
				const getDataFetch = document.querySelector(".ar-fetch-list-data").getAttribute("data-url");

				axios.get(getDataFetch)
				.then(response => 
				{
					const getRes = response.data.slice(0)[0];

				 	this.responseData = response.data;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error)
				{
				 	console.log(error);
				})
				.finally(() => 
				{ 
					this.loadingData = false;
				});

				if (withStatus == true)
				{
					if (document.querySelector(".ar-data-status") !== null)
					{
						if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
						{
							document.querySelector(".ar-data-status").style.display = 'block';
						}
					}
				}

				if (document.querySelector(".ar-data-load") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
					{
						document.querySelector(".ar-data-load").style.display = 'block';
					}
				}
			}
		},
		inputCity: _.debounce(function(search, loading)
		{
			if (search.length)
			{
				const getURL = siteurl+'manage_venue/getListCities2?name=';

				loading(true);

				axios.get(getURL+encodeURI(search))
				.then(response => 
				{
					this.options = response.data.data;
					
					loading(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					loading(false);
				});
			}
		}, 100),
		refreshListData: function()
		{
			if (document.querySelector(".ar-fetch-list-data") !== null && 
				document.querySelector(".ar-fetch-list-data").getAttribute("data-url") !== null)
			{
				const getDataFetch = document.querySelector(".ar-fetch-list-data").getAttribute("data-url");

				axios.get(getDataFetch)
				.then(response => 
				{
					const getRes = response.data.slice(0)[0];

				 	this.responseData = response.data;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error)
				{
				 	console.log(error);
				})
				.finally(() => 
				{ 
					this.loadingData = false;
				});

				if (document.querySelector(".ar-data-status") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
					{
						document.querySelector(".ar-data-status").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-data-load") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
					{
						document.querySelector(".ar-data-load").style.display = 'block';
					}
				}
			}
		},
		deleteData: function(getDatas, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this item?",
				centerVertical: true,
				buttons: 
				{
					cancel: 
					{
						className: 'btn-danger',
						label: '<i class="fas fa-times fa-fw mr-1"></i> Cancel'
					},
					confirm: 
					{
						className: 'btn-success',
						label: '<i class="fas fa-check fa-fw mr-1"></i> Confirm'
					}
				},
				callback: function(result) 
				{
					if (result == true)
					{
						axios.get(getDataURL)
						.then(response => 
						{
							if (response.data.status == 'success')
							{
						 		getDatas.splice(index, 1);
							}
							else
							{
								bootbox.alert({
									title: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "Invalid Data Selected",
									centerVertical: true,
								});
							}
						})
						.catch(function(error)
						{
						 	console.log(error);
						});
					}
				}
			});
		},
		selectCityToVenue: async function(getCityId, getVenueId)
		{
			this.getCityId = getCityId;
			
			axios.get(baseurl+"manage_marketplace/getListCitiesVenue?cityid="+this.getCityId)
			.then(response =>
			{	
				this.responseVenue.data = response.data;
				this.statusData = response.data.status;
				this.msgData = response.data.msg;

				if (getVenueId == '' && this.responseVenue.data[0] != null)
				{
					this.responseVenue.selected = this.responseVenue.data[0].id;
				}
				else
				{
					this.responseVenue.selected = getVenueId;
				}

				if (document.querySelector(".ar-select-venue-default") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-venue-default'), null).display == 'block')
					{
						document.querySelector(".ar-select-venue-default").style.display = 'none';
					}
				}

				if (document.querySelector(".ar-select-venue-none") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-venue-none'), null).display == 'none')
					{
						document.querySelector(".ar-select-venue-none").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-select-venue") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-venue'), null).display == 'none')
					{
						document.querySelector(".ar-select-venue").style.display = 'block';
					}
				}
			})
			.catch(function(error) 
			{
				console.log(error);
			});
		},
		submitData: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].getAttribute("method");
			let formReset = document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].getAttribute("reset");
			let formWithCKEditor4 = document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].getAttribute("with-ckeditor4");
			let formWithEmailEditor = document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].getAttribute("with-emaileditor");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			if (formWithCKEditor4 == "true")
			{
				formData.append("content", CKEDITOR.instances.editor1.getData());
			}

			if (formWithEmailEditor == "true")
			{
				unlayer.addEventListener('design:updated', function(updates)
				{
					// Design is updated by the user
					let type = updates.type; // body, row, content
					let item = updates.item;
					let changes = updates.changes;

					console.log('design:updated', type, item, changes);

					// Design is updated by the user
					unlayer.exportHtml(function(data) 
					{
						let json = data.design; // design json
						let html = data.html; // final html

						// Do something with the json and html
						document.getElementsByClassName("form-control-emailhtml-editor")[0].value = html;
						document.getElementsByClassName("form-control-emailjson-editor")[0].value = JSON.stringify(json);

						console.log(data.text);
					});
				});
			}

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading font-size-inherit rounded\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						let toast = document.getElementsByClassName("sk-notice-toast")[0];
						toast.innerHTML = "<div class=\"ar-alert-submit text-white position-fixed m-3\"><div class=\"toast sk-toast-failed bg-success font-size-inherit text-white\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-check mr-2\"></i> Status <button type=\"button\" class=\"ml-2 mb-1 mt-n1 close text-white\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></h5> "+this.responseMessage+"</div></div></div>"; 

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("show");

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("hide");

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged font-size-inherit rounded\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-app-form-wlist").getElementsByTagName("form")[0].reset();
					}

					// Automaticaly reset value form input type file
					const ResetInputFile = document.querySelectorAll('.custom-file-input');
					const GetCustomInput = document.querySelectorAll('.custom-file-label');

					for (let i = 0; i < ResetInputFile.length; i++) 
					{
						const getOneUp = i+1;

						ResetInputFile[i].value = '';
						GetCustomInput[i].insertAdjacentHTML('beforebegin', '<label class="custom-file-label" for="customFile'+getOneUp+'">Choose file</label>');
						GetCustomInput[i].remove();
					}

					this.refreshListData(false);
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;

					let toast = document.getElementsByClassName("sk-notice-toast")[0];
					toast.innerHTML = "<div class=\"ar-alert-submit text-white position-fixed m-3\"><div class=\"toast sk-toast-failed bg-danger text-white\" data-autohide=\"false\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-exclamation-triangle mr-2\"></i> Notice <button type=\"button\" class=\"ml-2 mb-1 mt-n1 close text-white\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></h5> "+this.responseMessage+"</div></div></div>"; 

					// We still use JQuery because the Toast need JQuery to run
					$(".toast").toast("show");

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		previewImage: function(event, class_name)
		{
			if (event.target.files && event.target.files[0]) 
			{
				let reader = new FileReader();

				reader.onload = function(e) 
				{
					document.getElementsByClassName(class_name)[0].setAttribute("src", e.target.result);
				}

				reader.readAsDataURL(event.target.files[0]);
			}
		}
	},
	created: function()
	{
		this.listData(true);

		if (document.querySelector(".get_city_id") !== null &&
			document.querySelector(".get_city_id").getAttribute("value") !== null)
		{
			this.selectedCity.id = document.querySelector(".get_city_id").getAttribute("value");
		}
		
		if (document.querySelector(".get_city_name") !== null &&
			document.querySelector(".get_city_name").getAttribute("value") !== null)
		{
			const selectedCityBefore = 
			{
				'id': document.querySelector(".get_city_id").getAttribute("value"),
				'city_name': document.querySelector(".get_city_name").getAttribute("value"),
				'get_city_name': document.querySelector(".get_city_name").getAttribute("value")

			}

			this.options = [selectedCityBefore];
			this.selectedCity = selectedCityBefore;
		}

		if (document.querySelector(".ar-list-city") !== null && 
			document.querySelector(".ar-list-city").getAttribute("ar-default-cityid") !== null)
		{
			this.selectCityToVenue(document.getElementsByClassName("ar-list-city")[0].getAttribute("ar-default-cityid"), document.getElementsByClassName("ar-list-city")[0].getAttribute("ar-default-venueid"));
		}
	}
});

const Vue2FormOnly = new Vue(
{
	el: "#ar-app-form-only",
	data: 
	{
		form: {},
		showData: true,
		loadingData: true,
		loading: true,
		getTotal: '',
		getCityId: '',
		getCourier: '',
		getAddress: {},
		getPriceList: '',
		responseAddress: '',
		responseData: '',
		responseMessage: '',
		responseResult: '',
		responseResultCost: 0,
		responseFeeDelivery: 0,
		responseCities: 		
		{
			data: {},
			selected: '',
		},
		responseCourier: 		
		{
			data: {},
			selected: '',
		},
		initResponse: [],
		options: [],
		statusData: '',
		msgData: ''
	},
	methods: 
	{
		submitData: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("method");
			let formReset = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("reset");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading font-size-inherit rounded\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessage+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						let toast = new bootstrap.Toast(toastBox);
						toast.hide();

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged font-size-inherit rounded\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].reset();
					}

					// Automaticaly reset value form input type file
					const ResetInputFile = document.querySelectorAll('.custom-file-input');
					const GetCustomInput = document.querySelectorAll('.custom-file-label');

					for (let i = 0; i < ResetInputFile.length; i++) 
					{
						const getOneUp = i+1;

						ResetInputFile[i].value = '';
						GetCustomInput[i].insertAdjacentHTML('beforebegin', '<label class="custom-file-label" for="customFile'+getOneUp+'">Choose file</label>');
						GetCustomInput[i].remove();
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;

					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessage+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika font-size-inherit rounded\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		submitDataCSAlert: function(event)
		{
			event.preventDefault();

			// Get value of attribute in HTML.
			let formActionURL = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("method");
			let formReset = document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].getAttribute("reset");

			// Get value of submit button.
			let getValueButton = document.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'btn-block' : '';

			// Get using button large or not with value true and false from button-large attribute
			let getButtonLarge = this.$refs.formHTML.attributes['button-large']['value'] == 'true' ? 'btn-lg' : '';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-inherit';

			// Get using button large or not with value true and false from button-large attribute
			let getAddonClass = this.$refs.formHTML.attributes['addon-class']['value'] != '' ? this.$refs.formHTML.attributes['addon-class']['value'] : '';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading "+getButtonLarge+" "+getButtonBlock+" "+getFontSizeLarge+" "+getAddonClass+" rounded\"><div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data"}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						let notice = document.getElementsByClassName("ar-cs-alert")[0];
						notice.innerHTML = '<div class="bg-success text-white text-center p-3 rounded">'+response.data.msg+'</div>';

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonLarge+" "+getButtonBlock+" "+getFontSizeLarge+" "+getAddonClass+" rounded\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonLarge+" "+getButtonBlock+" "+getFontSizeLarge+" "+getAddonClass+" rounded\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-app-form-only").getElementsByTagName("form")[0].reset();
					}

					// Automaticaly reset value form input type file
					const ResetInputFile = document.querySelectorAll('.custom-file-input');
					const GetCustomInput = document.querySelectorAll('.custom-file-label');

					for (let i = 0; i < ResetInputFile.length; i++) 
					{
						const getOneUp = i+1;

						ResetInputFile[i].value = '';
						GetCustomInput[i].insertAdjacentHTML('beforebegin', '<label class="custom-file-label" for="customFile'+getOneUp+'">Choose file</label>');
						GetCustomInput[i].remove();
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;

					let notice = document.getElementsByClassName("ar-cs-alert")[0];
					notice.innerHTML = '<div class="bg-danger text-white text-center p-3 rounded">'+response.data.msg+'</div>';

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonLarge+" "+getButtonBlock+" "+getFontSizeLarge+" "+getAddonClass+" rounded\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		inputAddress_old: async function()
		{
			const formatter = new Intl.NumberFormat('id-ID', 
			{
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0
			});

			let DataTotalAmount = parseInt(document.getElementById("ar-select-area-form").getAttribute("data-total-amount"));

			this.loading = true;

			if (this.getAddress.length >= 5)
			{
				const getURL = siteurl+'our_menu/CalculatingPrice?address=';

				await axios.get(getURL+this.getAddress)
				.then(response => 
				{
					const initResultAddress = response.data.msg.order;

					this.responseAddress = initResultAddress.points[1];
					this.responseFeeDelivery = initResultAddress.delivery_fee_amount;
					
					let resultTotalAmount 	= (this.responseFeeDelivery !== 0) ? DataTotalAmount += parseInt(this.responseFeeDelivery) : DataTotalAmount;
					let getShippingCost 	= (this.responseFeeDelivery !== 0) ? formatter.format(this.responseFeeDelivery) : 0;
					
					this.responseResult 	= formatter.format(resultTotalAmount);
					this.responseResultCost	= getShippingCost;

					if (document.querySelector(".ar-result-address") !== null)
					{
						if (getComputedStyle(document.querySelector('.ar-result-address'), null).display == 'none')
						{
							document.querySelector(".ar-result-address").style.display = 'block';
						}
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
				});
			}
			else if (this.getAddress.length !== 0 && this.getAddress.length < 5)
			{
				this.loading 			= true;
				this.responseResult 	= formatter.format(DataTotalAmount);
				this.responseResultCost	= 0;

				if (document.querySelector(".ar-result-address") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-result-address'), null).display == 'none')
					{
						document.querySelector(".ar-result-address").style.display = 'block';
					}
				}
			}
			else if (this.getAddress.length == 0)
			{
				this.loading 			= false;
				this.getAddress 		= '';
				this.responseResult 	= formatter.format(DataTotalAmount);
				this.responseResultCost	= 0;

				document.getElementsByClassName("ar-shipping-address")[0].value = '';

				if (document.querySelector(".ar-result-address") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-result-address'), null).display == 'block')
					{
						document.querySelector(".ar-result-address").style.display = 'none';
					}
				}
			}

			if (document.querySelector(".ar-shipping-cost") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-shipping-cost'), null).display == 'none')
				{
					document.querySelector(".ar-shipping-cost").style.display = 'block';
				}
			}
		},
		inputAddress: _.debounce(function(search, loading)
		{
			if (search.length >= 6)
			{
				const getURL = siteurl+'account/getAddress?q=';

				loading(true);

				axios.get(getURL+encodeURI(search))
				.then(response => 
				{
					this.options = response.data.data;
					
					loading(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					loading(false);
				});
			}
		}, 500),
		priceList: function()
		{
			if (document.querySelector(".ar-price-list") !== null)
			{
				this.loading = true;

				const getURL = siteurl+'our_menu/CalculatingPrice';

				axios.get(getURL)
				.then(response => 
				{
					if (response.data.msg !== undefined)
					{
						this.getPriceList = response.data.msg.partners;
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
				});


				if (getComputedStyle(document.querySelector('.ar-price-list'), null).display == 'none')
				{
					document.querySelector(".ar-price-list").style.display = 'block';
				}
			}
		},
		selectCity: async function(getCityId)
		{
			this.getCityId = getCityId;
			this.responseCities.selected = '';

			axios.get(baseurl+"our_menu/getArea?coverage_city_id="+this.getCityId)
			.then(response =>
			{	
				this.responseCities.data = response.data;
				this.statusData = response.data.status;
				this.msgData = response.data.msg;

				if (document.querySelector(".ar-select-area-default") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-area-default'), null).display == 'block')
					{
						document.querySelector(".ar-select-area-default").style.display = 'none';
					}
				}

				if (document.querySelector(".ar-select-area-none") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-area-none'), null).display == 'none')
					{
						document.querySelector(".ar-select-area-none").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-select-area") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-select-area'), null).display == 'none')
					{
						document.querySelector(".ar-select-area").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-total-amount") !== null && 
					document.querySelector(".ar-total-amount").getAttribute("ar-total-data-amount") !== null)
				{
					this.selectAreawithCost(document.getElementsByClassName("ar-total-amount")[0].getAttribute("ar-total-data-amount"));
				}
			})
			.catch(function(error) 
			{
				console.log(error);
			});
		},
		selectAreawithCost: async function(getTotalAmount, getShippingCost, getSelected)
		{
			if (getSelected == 'true')
			{
				this.responseCities.selected = 'selected';
			}
			
			const formatter = new Intl.NumberFormat('id-ID', 
			{
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0
			});

			const resultTotalAmount = (getShippingCost !== undefined) ? parseInt(getTotalAmount)+parseInt(getShippingCost) : getTotalAmount;

			this.responseResult 		= formatter.format(resultTotalAmount);
			this.responseResultCost		= (getShippingCost !== undefined) ? formatter.format(getShippingCost) : 0;

			console.log(resultTotalAmount);

			if (document.querySelector(".ar-shipping-cost") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-shipping-cost'), null).display == 'none')
				{
					document.querySelector(".ar-shipping-cost").style.display = 'block';
				}
			}
		},
		selectCourierWithCost: async function(getTotalAmount, getShippingCost, getSelected)
		{
			/*
			if (getSelected == 'true')
			{
				this.responseCourier.selected = 'selected';
			}
			*/

			const formatter = new Intl.NumberFormat('id-ID', 
			{
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0
			});

			const resultTotalAmount = (getShippingCost !== undefined) ? parseInt(getTotalAmount) + parseInt(getShippingCost) : getTotalAmount;
			const courier = (document.querySelector(".ar-list-courier") !== null) ? document.querySelector(".ar-list-courier option:checked").getAttribute("courier") : '';

			this.responseResult 		= formatter.format(resultTotalAmount);
			this.responseResultCost		= (getShippingCost !== undefined) ? formatter.format(getShippingCost) : 0;
			this.getCourier 			= courier;

			if (document.querySelector(".ar-shipping-cost") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-shipping-cost'), null).display == 'none')
				{
					document.querySelector(".ar-shipping-cost").style.display = 'block';
				}
			}
		}
	},
	created: async function()
	{
		this.priceList();

		if (document.querySelector(".ar-total-amount") !== null && 
			document.querySelector(".ar-total-amount").getAttribute("ar-total-data-amount") !== null)
		{
			this.selectAreawithCost(document.getElementsByClassName("ar-total-amount")[0].getAttribute("ar-total-data-amount"));
			this.selectCourierWithCost(document.getElementsByClassName("ar-total-amount")[0].getAttribute("ar-total-data-amount"));
		}

		if (document.querySelector("#ar-get-address") !== null &&
			document.querySelector("#ar-get-address").getAttribute("value") !== null)
		{
			this.getAddress.display_name = document.querySelector("#ar-get-address").getAttribute("value");
			this.getAddress.latitude = document.querySelector("#ar-get-latitude").getAttribute("value");
			this.getAddress.longitude = document.querySelector("#ar-get-longitude").getAttribute("value");
			this.getAddress.country_code = document.querySelector("#ar-get-country_code").getAttribute("value");
		}
	}
});

const Vue2ListData = new Vue(
{
	el: "#ar-app-listdata",
	data: 
	{
		getData: {},
		getTotalData: '',
		getCategory: '',
		pageURL: '',
		pageCategory: '',
		pageCount: '',
		pageRange: '',
		currentPage: '',
		getTitle: '',
		resTitle: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		show: true,
		loading: true,
		loadingnextpage: true
	},
	components: 
	{
		VueLazyload
	},
	methods: 
	{
		listData: function()
		{
			if (document.querySelector(".ar-fetch-app-listdata") !== null && 
				document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data;
					this.getTotalData = getval.getDataPage.total_data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}

			if (document.querySelector(".ar-data-status") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
				{
					document.querySelector(".ar-data-status").style.display = 'block';
				}
			}

			if (document.querySelector(".ar-data-load") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
				{
					document.querySelector(".ar-data-load").style.display = 'block';
				}
			}

			if (document.querySelector(".ar-total-data-load") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-total-data-load'), null).display == 'none')
				{
					document.querySelector(".ar-total-data-load").style.display = 'block';
				}
			}
		},
		deleteData: function(getDataInfo, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this item?",
				centerVertical: true,
				buttons: 
				{
					cancel: 
					{
						className: 'btn-danger',
						label: '<i class="fas fa-times fa-fw mr-1"></i> Cancel'
					},
					confirm: 
					{
						className: 'btn-success',
						label: '<i class="fas fa-check fa-fw mr-1"></i> Confirm'
					}
				},
				callback: function(result) 
				{
					if (result == true)
					{
						axios.get(getDataURL)
						.then(response => 
						{
							if (response.data.status == 'success')
							{
								getDataInfo.splice(index, 1);

								bootbox.alert({
									title: "<i class=\"fas fa-check text-success fa-fw mr-1\"></i> Success",
									message: "<div class=\"text-center\">Data deleted !!</div>",
									centerVertical: true,
								});
							}
							else if (response.data.status == 'failed' && response.data.msg !== '')
							{
								bootbox.alert({
									search: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "<div class=\"text-center\">"+response.data.msg+"</div>",
									centerVertical: true,
								});
							}							
							else
							{
								bootbox.alert({
									title: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "<div class=\"text-center\">Invalid Data Selected</div>",
									centerVertical: true,
								});
							}
						})
						.catch(function(error)
						{
						 	console.log(error);
						});
					}
				}
			});
		},
		searchData: function(event)
		{
			const getTitle = this.getTitle.trim();

			if (document.querySelector(".ar-fetch-app-listdata") !== null && 
				document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url");

				if (this.pageCategory != '')
				{
					this.resTitle = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.resTitle = '?title='+this.getTitle;
				}

				this.loadingnextpage = true;

				axios.get(getUrl+this.resTitle)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.getTotalData = getval.getDataPage.total_data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}
		},
		clickCategory: function() 
		{
			if (document.querySelector(".ar-fetch-app-listdata") !== null && 
				document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url");

				if (this.getTitle != '')
				{
					this.getCat = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}

				document.querySelector("#ar-article").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.getTotalData = getval.getDataPage.total_data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		selectCategory: function(getCategory) 
		{
			if (document.querySelector(".ar-fetch-app-listdata") !== null && 
				document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url");

				this.pageCategory = getCategory;

				if (this.getTitle != '')
				{
					this.getCat = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}
				
				document.querySelector("#ar-article").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.getTotalData = getval.getDataPage.total_data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		clickPaginate: async function(page) 
		{
			if (document.querySelector(".ar-fetch-app-listdata") !== null && 
				document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listdata").getAttribute("data-url");

				if (this.getTitle != '')
				{
					if (page == 1)
					{
						if (this.pageCategory != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle;
						}
						else
						{
							this.pageUrl = '?title='+this.getTitle;
						}
					}
					else
					{
						if (this.pageCategory != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle+'&page='+page;
						}
						else
						{
							this.pageUrl = '?title='+this.getTitle+'&page='+page;
						}
					}
				}
				else if (this.pageCategory != '')
				{
					if (page == 1)
					{
						if (this.getTitle != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle;
						}
						else
						{
							this.pageUrl = '?category='+this.pageCategory;
						}
					}
					else
					{
						if (this.getTitle != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle+'&page='+page;
						}
						else
						{
							this.pageUrl = '?category='+this.pageCategory+'&page='+page;
						}
					}
				}
				else
				{
					if (page == 1)
					{
						this.pageUrl = '';
					}
					else
					{
						this.pageUrl = '?page='+page;
					}
				}

				this.loadingnextpage = true;

				await axios.get(url+this.pageUrl)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];

					if (this.currentPage >= this.pageCount)
					{
						this.currentPage = '';
					}

					this.getData = response.data
					this.getTotalData = getval.getDataPage.total_data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;

					document.querySelector("#ar-article").scrollIntoView(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}
		}
	},
	created: function()
	{
		this.listData();
	}
});

const Vue2ListItem = new Vue(
{
	el: "#ar-app-listitem",
	data: 
	{
		getData: {},
		getCategory: '',
		pageURL: '',
		pageCategory: '',
		pageCount: '',
		pageRange: '',
		currentPage: '',
		getTitle: '',
		resTitle: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		show: true,
		showData: true,
		loading: true,
		loadingnextpage: true,
		item: 
		{
			order_quantity: 0
		},
		availableItem: '',
		responseMessage: '',
	},
	components: 
	{
		VueLazyload
	},
	methods: 
	{
		listItem: function()
		{
			if (document.querySelector(".ar-fetch-app-listitem") !== null && 
				document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}

			if (document.querySelector(".ar-data-status") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
				{
					document.querySelector(".ar-data-status").style.display = 'block';
				}
			}

			if (document.querySelector(".ar-data-load") !== null)
			{
				if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
				{
					document.querySelector(".ar-data-load").style.display = 'block';
				}
			}
		},
		deleteData: function(getDataInfo, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this item?",
				centerVertical: true,
				buttons: 
				{
					cancel: 
					{
						className: 'btn-danger',
						label: '<i class="fas fa-times fa-fw mr-1"></i> Cancel'
					},
					confirm: 
					{
						className: 'btn-success',
						label: '<i class="fas fa-check fa-fw mr-1"></i> Confirm'
					}
				},
				callback: function(result) 
				{
					if (result == true)
					{
						axios.get(getDataURL)
						.then(response => 
						{
							if (response.data.status == 'success')
							{
								getDataInfo.splice(index, 1);

								bootbox.alert({
									title: "<i class=\"fas fa-check text-success fa-fw mr-1\"></i> Success",
									message: "<div class=\"text-center\">Data deleted !!</div>",
									centerVertical: true,
								});
							}
							else
							{
								bootbox.alert({
									title: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "<div class=\"text-center\">Invalid Data Selected</div>",
									centerVertical: true,
								});
							}
						})
						.catch(function(error)
						{
						 	console.log(error);
						});
					}
				}
			});
		},
		searchData: function(event)
		{
			const getTitle = this.getTitle.trim();

			if (document.querySelector(".ar-fetch-app-listitem") !== null && 
				document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url");

				if (this.pageCategory != '')
				{
					this.resTitle = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.resTitle = '?title='+this.getTitle;
				}

				this.loadingnextpage = true;

				axios.get(getUrl+this.resTitle)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}
		},
		clickCategory: function() 
		{
			if (document.querySelector(".ar-fetch-app-listitem") !== null && 
				document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url");

				if (this.getTitle != '')
				{
					this.getCat = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}

				document.querySelector("#ar-article").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		selectCategory: function(getCategory) 
		{
			if (document.querySelector(".ar-fetch-app-listitem") !== null && 
				document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url");

				this.pageCategory = getCategory;

				if (this.getTitle != '')
				{
					this.getCat = '?category='+this.pageCategory+'&title='+this.getTitle;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}
				
				document.querySelector("#ar-article").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currentPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		clickPaginate: async function(page) 
		{
			if (document.querySelector(".ar-fetch-app-listitem") !== null && 
				document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-app-listitem").getAttribute("data-url");

				if (this.getTitle != '')
				{
					if (page == 1)
					{
						if (this.pageCategory != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle;
						}
						else
						{
							this.pageUrl = '?title='+this.getTitle;
						}
					}
					else
					{
						if (this.pageCategory != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle+'&page='+page;
						}
						else
						{
							this.pageUrl = '?title='+this.getTitle+'&page='+page;
						}
					}
				}
				else if (this.pageCategory != '')
				{
					if (page == 1)
					{
						if (this.getTitle != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle;
						}
						else
						{
							this.pageUrl = '?category='+this.pageCategory;
						}
					}
					else
					{
						if (this.getTitle != '')
						{
							this.pageUrl = '?category='+this.pageCategory+'&title='+this.getTitle+'&page='+page;
						}
						else
						{
							this.pageUrl = '?category='+this.pageCategory+'&page='+page;
						}
					}
				}
				else
				{
					if (page == 1)
					{
						this.pageUrl = '';
					}
					else
					{
						this.pageUrl = '?page='+page;
					}
				}

				this.loadingnextpage = true;

				await axios.get(url+this.pageUrl)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];

					if (this.currentPage >= this.pageCount)
					{
						this.currentPage = '';
					}

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;

					document.querySelector("#ar-article").scrollIntoView(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});
			}
		}
	},
	created: function()
	{
		this.listItem();
	}
});

const Vue2Croppie = new Vue(
{
	el: '#ar-app-form-croppie',
	data: 
	{
		form: {},
		show: true,
		getData: '',
		reinitCroppie: '',
		responseMessage: ''
	},
	mounted: function() 
	{
		if (document.querySelector(".croppie") !== null &&
			document.querySelector(".upload") !== null)
		{
			const croppie = document.querySelector('.croppie');
			const initCroppie = new Croppie(croppie, 
			{
				url: '../assets/images/undraw_profile_pic_ic5t.svg',
				enableExif: true,
				viewport: 
				{
					width: 200,
					height: 200,
					type: 'square'
				},
				boundary:
				{
					width: 220,
					height: 220
				}
			});

			this.reinitCroppie = initCroppie;

			document.querySelector('.upload').addEventListener('change', function(ev)
			{
				if (this.files && this.files[0]) 
				{
					if (/^image/.test(this.files[0].type)) 
					{
						const reader = new FileReader();
						reader.onload = function(e) 
						{
							initCroppie.bind( 
							{
								url: e.target.result
							});
						}

						reader.readAsDataURL(this.files[0]);
					}
				}
			});
		}
	},
	methods: 
	{
		submit: async function(event) 
		{
			event.preventDefault();

			let formAction 	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("action");
			let formMethod 	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("method");
			let formReset	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("data-reset");

			// Get value of submit button.
			let getValSubmit 	= document.querySelector('input[type="submit"]').getAttribute("value");

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'btn-block' : '';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			document.getElementsByClassName("btn-bnight-blue")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-secondary "+getButtonBlock+" btn-loading m-0 px-3 py-2\">Loading <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-bnight-blue")[0].remove();
			
			const getImg = {profilepic:document.getElementsByClassName("cr-image")[0].getAttribute("src")};
			const getExt = getImg.profilepic.match(/[^:/]\w+(?=;|,)/)[0];

			this.reinitCroppie.result(
			{
				type: 'canvas',
				size: 'viewport',
				format: getExt
			}).then(function(res) 
			{
				formData.set('avatar', res);

				axios(
				{
					url: formAction,
					method: formMethod,
					data: formData,
					config: 
					{ 
						headers: 
						{ 
							"Content-Type": "multipart/form-data"
						} 
					}
				})
				.then(response => 
				{
					if (response.data.status == 'success')
					{
						if ( ! response.data.url)
						{
							this.responseMessage = response.data.msg;

							let toast = document.getElementsByClassName("sk-notice-toast")[0];
							toast.innerHTML = "<div class=\"ar-alert-submit position-fixed m-3\"><div class=\"toast sk-toast-failed bg-success text-white\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-exclamation-triangle mr-2\"></i> Notice <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+this.responseMessage+"</div></div></div>"; 

							// Update automatically avatar after successfuly new avatar uploaded
							let getAvatar = document.querySelectorAll(".ar-avatar");

							for (i = 0; i < getAvatar.length; i++)
							{
								getAvatar[i].setAttribute("src", response.data.getImg);
							}

							// We still use JQuery because the Toast need JQuery to run
							$(".toast").toast("show");

							document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue "+getButtonBlock+" px-3 py-2\" value=\""+getValSubmit+"\">");
							document.getElementsByClassName("btn-loading")[0].remove();
						}
						else
						{
							window.setTimeout(function() 
							{
								window.location.href = response.data.url;
							}, 500);
							
							// We still use JQuery because the Toast need JQuery to run
							$(".toast").toast("hide");

							document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-success btn-logged "+getButtonBlock+" m-0 px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
							document.getElementsByClassName("btn-loading")[0].remove();
						}

						if (formReset == "true")
						{
							document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].reset();
						}

						if (document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset") !== null)
						{
							const formFileReset	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset");
						
							if (formFileReset == "true")
							{
								const getResetFile = document.querySelectorAll('input[type="file"]');

								for (var i = 0; i < getResetFile.length; i++) 
								{
									getResetFile[i].value = '';
									document.getElementsByClassName("custom-file-label")[i].innerHTML = 'Choose file';
								}
							}
						}

						document.getElementsByClassName("cr-image")[0].setAttribute("src", "");
					}
					else if (response.data.status == 'failed')
					{
						this.responseMessage = response.data.msg;
						
						let toast = document.getElementsByClassName("sk-notice-toast")[0];
						toast.innerHTML = "<div class=\"ar-alert-submit position-fixed m-3\"><div class=\"toast sk-toast-failed bg-danger text-white\" data-autohide=\"false\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-exclamation-triangle mr-2\"></i> Notice <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+this.responseMessage+"</div></div></div>"; 

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("show");

						if (document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset") !== null)
						{
							const formFileReset	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset");
						
							if (formFileReset == "true")
							{
								const getResetFile = document.querySelectorAll('input[type="file"]');

								for (var i = 0; i < getResetFile.length; i++) 
								{
									getResetFile[i].value = '';
									document.getElementsByClassName("custom-file-label")[i].innerHTML = 'Choose file';
								}
							}
						}

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonBlock+" px-3 py-2\" value=\""+getValSubmit+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
				})
				.catch(response => 
				{ 
					console.log(response);
				});
			});
		}
	}
});

/* For List User sudah diupdate kodenya namun belum semuanya */

const Vue2ListUsers = new Vue(
{
	el: '#ar-listuser',
	data:
	{
		getData: {},
		getUserData: {},
		getCat: '',
		pageCount: '',
		pageRange: '',
		pageUrl: '',
		pageCategory: '',
		currPage: '',
		getUser: '',
		resUser: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		getPage: '',
		getUsers: '',
		show: true,
		showData: true,
		loading: true,
		loadingnextpage: true
	},
	methods: 
	{
		getAllUser: async function()
		{
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const url = document.querySelector(".ar-fetch").getAttribute("data-fetch-user");

				await axios.get(url)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data;
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});

				if (document.querySelector(".ar-data-status") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
					{
						document.querySelector(".ar-data-status").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-data-load") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
					{
						document.querySelector(".ar-data-load").style.display = 'block';
					}
				}
			}
		},
		deleteData: function(getDataInfo, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this item?",
				centerVertical: true,
				buttons: 
				{
					cancel: 
					{
						className: 'btn-danger',
						label: '<i class="fas fa-times fa-fw mr-1"></i> Cancel'
					},
					confirm: 
					{
						className: 'btn-success',
						label: '<i class="fas fa-check fa-fw mr-1"></i> Confirm'
					}
				},
				callback: function(result) 
				{
					if (result == true)
					{
						axios.get(getDataURL)
						.then(response => 
						{
							if (response.data.status == 'success')
							{								
								getDataInfo.splice(index, 1);

								bootbox.alert({
									title: "<i class=\"fas fa-check text-success fa-fw mr-1\"></i> Success",
									message: "<div class=\"text-center\">Data deleted !!</div>",
									centerVertical: true,
								});
							}
							else
							{
								bootbox.alert({
									title: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "<div class=\"text-center\">Invalid Data Selected</div>",
									centerVertical: true,
								});
							}
						})
						.catch(function(error)
						{
						 	console.log(error);
						});
					}
				}
			});
		},
		clickUserModal: async function(userId)
		{			
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-url-user") !== null)
			{
				const url_get_user = document.querySelector(".ar-fetch").getAttribute("data-url-user");

				$('#userModal').modal('show');

				await axios.get(url_get_user+userId)
				.then(response => 
				{
					this.getUserData = response.data;

					document.querySelector(".modal-body .ar-fullname").innerHTML = this.getUserData[0].fullname;
					document.querySelector(".modal-body .ar-username").innerHTML = '@'+this.getUserData[0].username;
					document.querySelector(".modal-body .ar-email").innerHTML = this.getUserData[0].email;
					document.querySelector(".modal-body .ar-status").innerHTML = this.getUserData[0].status;
					document.querySelector(".modal-body .ar-role").innerHTML = this.getUserData[0].role;
					document.querySelector(".modal-body .ar-gender").innerHTML = this.getUserData[0].gender;
					document.querySelector(".modal-body .ar-birthdate").innerHTML = this.getUserData[0].birthdate;
					document.querySelector(".modal-body .ar-phone-number").innerHTML = this.getUserData[0].phone_number;
					document.querySelector(".modal-body .ar-about").innerHTML = this.getUserData[0].about;

					if (this.getUserData[0].avatar != '')
					{
						document.querySelector(".ar-avatar-user").setAttribute("src", baseurl+this.getUserData[0].avatar);
						document.querySelector(".ar-avatar-user").style.display = 'block';
						document.querySelector(".ar-avatar-default").style.display = 'none';
					}
					else
					{
						document.querySelector(".ar-avatar-user").setAttribute("src", "");
						document.querySelector(".ar-avatar-user").style.display = 'none';
						document.querySelector(".ar-avatar-default").style.display = 'block';
					}					
				})
				.catch(function(error) 
				{
					console.log(error);
				});
			}
		},
		clickSelectAll: function()
		{
			const getSelectAll = document.querySelector("#clickSelectAll");

			if (getSelectAll.checked == true) 
			{
				const checkbox = document.querySelectorAll(".checkids");

				for (i = 0; i < checkbox.length; i++)
				{
					if (checkbox[i].checked == false)
					{
						checkbox[i].checked = true;
					}
				}
			} 
			else 
			{
				const checkbox = document.querySelectorAll(".checkids");

				for (i = 0; i < checkbox.length; i++)
				{
					if (checkbox[i].checked == true)
					{
						checkbox[i].checked = false;
					}
				}
			}
		},
		clickCheckbox: function(event)
		{
			const selectAll = document.querySelector("#clickSelectAll");

			if (selectAll.checked == true)
			{
				selectAll.checked = false;
			}
		},
		sendEmailBroadcast: async function(id, event)
		{
			const url = siteurl+"manage_email/sendbroadcast/"+id;

			document.getElementsByClassName("btn-sendbc")[event].classList.remove('d-inline-block');
			document.getElementsByClassName("btn-sendbc")[event].classList.add('d-none');

			document.getElementsByClassName("btn-loading-sendbc")[event].classList.remove('d-none');
			document.getElementsByClassName("btn-loading-sendbc")[event].classList.add('d-inline-block');

			await axios.get(url)
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					console.log('Sending email broadcast to user');

					let toast = document.getElementsByClassName("sk-notice-toast")[0];
					toast.innerHTML = "<div class=\"ar-alert-submit position-fixed\"><div class=\"toast sk-toast-failed bg-success text-white mx-3 my-1 mb-3 m-md-3\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-check mr-2\"></i> Status <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+response.data.msg+"</div></div></div>"; 

					// We still use JQuery because the Toast need JQuery to run
					$(".toast").toast("show");

					document.getElementsByClassName("btn-sendbc")[event].classList.remove('d-none');
					document.getElementsByClassName("btn-sendbc")[event].classList.add('d-inine-block');

					document.getElementsByClassName("btn-loading-sendbc")[event].classList.remove('d-inline-block');
					document.getElementsByClassName("btn-loading-sendbc")[event].classList.add('d-none');
				}
				else if (response.data.status == 'failed')
				{
					let toast = document.getElementsByClassName("sk-notice-toast")[0];
					toast.innerHTML = "<div class=\"ar-alert-submit position-fixed\"><div class=\"toast sk-toast-failed bg-danger text-white mx-3 my-1 mb-3 m-md-3\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-times mr-2\"></i> Notice <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+response.data.msg+"</div></div></div>"; 

					// We still use JQuery because the Toast need JQuery to run
					$(".toast").toast("show");

					document.getElementsByClassName("btn-sendbc")[event].classList.remove('d-none');
					document.getElementsByClassName("btn-sendbc")[event].classList.add('d-inine-block');

					document.getElementsByClassName("btn-loading-sendbc")[event].classList.remove('d-inline-block');
					document.getElementsByClassName("btn-loading-sendbc")[event].classList.add('d-none');
				}
			})
			.catch(response => 
			{ 
				console.log(response);
			});
		},
		searchUser: async function(event)
		{
			const getUser = this.getUser.trim();

			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch").getAttribute("data-fetch-user");

				this.getUsers = this.getUser;
				this.resUser = '?user='+this.getUser;
				this.loadingnextpage = true;

				await axios.get(getUrl+this.resUser)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
					this.currPage = getval.getDataPage.current_page;
					this.statusData = getRes.status;
					this.msgData = getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});

				if (document.querySelector(".btn-token") !== null)
				{
					document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
				}
			}
		},
		clickPaginate: async function(page) 
		{
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const url = document.querySelector(".ar-fetch").getAttribute("data-fetch-user");
				const checkbox = document.querySelectorAll(".checkids");
				const selectAll = document.querySelector("#clickSelectAll");

				for (i = 0; i < checkbox.length; i++)
				{
					if (checkbox[i].checked == true)
					{
						checkbox[i].checked = false;
					}
				}

				if (selectAll.checked == true)
				{
					selectAll.checked = false;
				}

				this.getPage = page;

				let params = (new URL(url)).searchParams;

				if (params.toString() !== '')
				{
					if (page == 1)
					{
						this.pageUrl = params.toString();
					}
					else
					{
						this.pageUrl = params.toString()+'&page='+page;
					}

					console.log(this.pageUrl);
				}
				else
				{
					if (page == 1)
					{
						this.pageUrl = '';
					}
					else
					{
						this.pageUrl = '?page='+page;
					}

					console.log(this.pageUrl);
				}

				/*
				if (this.getUser != '')
				{
					if (page == 1 || page == '')
					{
						this.pageUrl = '?user='+this.getUser;
					}
					else
					{
						this.pageUrl = '?user='+this.getUser+'&page='+page;
					}
				}
				else
				{
					if (page == 1 || page == '')
					{
						this.pageUrl = '';
					}
					else
					{
						this.pageUrl = '?page='+page;
					}
				}
				*/

				this.loadingnextpage = true;

				document.querySelector("#ar-listuser-load").scrollIntoView(true);

				await axios.get(url+this.pageUrl)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];

					if (this.currPage >= this.pageCount)
					{
						this.currPage = '';
					}

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading = false;
					this.loadingnextpage = false;
				});

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			}
		},
		afterUpdateStatus: async function()
		{
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const url = document.querySelector(".ar-fetch").getAttribute("data-fetch-user");
				const checkbox = document.querySelectorAll(".checkids");
				const selectAll = document.querySelector("#clickSelectAll");

				for (i = 0; i < checkbox.length; i++)
				{
					if (checkbox[i].checked == true)
					{
						checkbox[i].checked = false;
					}
				}

				if (selectAll.checked == true)
				{
					selectAll.checked = false;
				}

				if (this.getUsers != '')
				{
					if (this.getPage == 1 || this.getPage == '')
					{
						this.pageUrl = '?user='+this.getUsers;
					}
					else
					{
						this.pageUrl = '?user='+this.getUsers+'&page='+this.getPage;
					}
				}
				else
				{
					if (this.getPage == 1 || this.getPage == '')
					{
						this.pageUrl = '';
					}
					else
					{
						this.pageUrl = '?page='+this.getPage;
					}
				}

				await axios.get(url+this.pageUrl)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];

					if (this.currPage >= this.pageCount)
					{
						this.currPage = '';
					}

					this.getData = response.data
					this.pageCount = getval.getDataPage.total;
					this.pageRange = getval.getDataPage.num_per_page;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		submit: async function(event)
		{
			event.preventDefault();

			let formAction 	= document.getElementById("ar-listuser").getElementsByTagName("form")[0].getAttribute("action");
			let formMethod 	= document.getElementById("ar-listuser").getElementsByTagName("form")[0].getAttribute("method");
			let formReset	= document.getElementById("ar-listuser").getElementsByTagName("form")[0].getAttribute("data-reset");

			// Get value of submit button.
			let getValSubmit 	= document.querySelector('input[type="submit"]').getAttribute("value");

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'btn-block' : '';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			document.getElementsByClassName("btn-bnight-blue")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-secondary "+getButtonBlock+" btn-loading font-size-inherit m-0 px-3 py-2\">Loading <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-bnight-blue")[0].remove();

			await axios(
			{
				method: formMethod,
				url: formAction,
				data: formData,
				config: 
				{ 
					headers: 
					{ 
						"Content-Type": "multipart/form-data" 
					} 
				},
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessage = response.data.msg;

						let toast = document.getElementsByClassName("sk-notice-toast")[0];
						toast.innerHTML = "<div class=\"ar-alert-submit position-fixed\"><div class=\"toast sk-toast-failed bg-success text-white mx-3 my-1 mb-3 m-md-3\" data-delay=\"3500\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-check mr-2\"></i> Status <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+this.responseMessage+"</div></div></div>"; 

						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("show");

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonBlock+" font-size-inherit px-3 py-2\" value=\""+getValSubmit+"\">");
						document.getElementsByClassName("btn-loading")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);
						
						// We still use JQuery because the Toast need JQuery to run
						$(".toast").toast("hide");

						document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-success btn-logged "+getButtonBlock+" font-size-inherit m-0 px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-listuser").getElementsByTagName("form")[0].reset();
					}

					this.afterUpdateStatus();
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessage = response.data.msg;
					
					let toast = document.getElementsByClassName("sk-notice-toast")[0];
					toast.innerHTML = "<div class=\"ar-alert-submit position-fixed m-3\"><div class=\"toast sk-toast-failed bg-danger text-white\" data-autohide=\"false\"><div class=\"toast-body pt-3 px-3 pb-n3\"><h5 class=\"h6 mb-3\"><i class=\"fas fa-exclamation-triangle mr-2\"></i> Notice <span class=\"float-right\"><a href=\"javascript:void(0);\" class=\"mt-n2 close\" data-dismiss=\"toast\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"fas fa-times fa-fw text-white\" style=\"font-size: 16px\"></i></span></a></span></h5> "+this.responseMessage+"</div></div></div>"; 

					// We still use JQuery because the Toast need JQuery to run
					$(".toast").toast("show");

					document.getElementsByClassName("btn-loading")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika "+getButtonBlock+" font-size-inherit px-3 py-2\" value=\""+getValSubmit+"\">");
					document.getElementsByClassName("btn-loading")[0].remove();
				}

				document.getElementsByClassName("btn-token")[0].setAttribute("value", Cookies.get("malika_cms2022"));
			})
			.catch(response => 
			{ 
				console.log(response);
			});
		}
	},
	created: function()
	{
		this.getAllUser();
	}
});

/* For Translate sudah diupdate kodenya namun belum semuanya */

const Vue2Translate = new Vue(
{
	el: '#ar-translate',
	data:
	{
		form: {},
		getData: {},
		responseMessage: '',
	},
	methods:
	{
		fetch: async function()
		{
			if (document.querySelector('.ar-translate-fetch') !== null &&
				document.querySelector('.ar-translate-fetch').getAttribute('data-fetch') !== null)
			{
				const getURL = document.querySelector('.ar-translate-fetch').getAttribute('data-fetch');

				await axios.get(getURL)
				.then(response =>
				{
					this.getData = response.data;
				})
				.catch(function(error)
				{
					console.log(error);
				});
			}
		},
		submit: async function(e)
		{
			let formAction = document.querySelector('.ar-translate-form').getAttribute('action');
			let formMethod = document.querySelector('.ar-translate-form').getAttribute('method');
			let formData = new FormData(this.$refs.formHTML);

			let dialog = bootbox.dialog({ 
				message: '<div class="text-center p-4"><div class="spinner-grow text-danger mb-1" role="status"></div> <p class="font-weight-normal mb-0">Submitting ...</p></div>', 
				centerVertical: true,
				onEscape: true,
				backdrop: true,
				closeButton: false,
			});

			await axios(
			{
				data: formData,
				url: formAction,
				method: formMethod,
				headers:
				{
					'Content-Type': 'multipart/form-data'
				}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					dialog.init(function() 
					{
						dialog.find('.modal-body').prepend('<button type="button" class="bootbox-close-button close" aria-hidden="true">×</button>');
						dialog.find('.bootbox-body').html('<div class="p-2"><div class="text-center"><i class="fas fa-check text-success fa-2x mb-1"></i> <p class="font-weight-normal m-0">'+response.data.msg+'</p></div></div>');

						setTimeout(function()
						{
							bootbox.hideAll();
						}, 850);
					});
				}
				else if (response.data.status == 'failed')
				{
					dialog.init(function() 
					{
						dialog.find('.modal-body').prepend('<button type="button" class="bootbox-close-button close" aria-hidden="true">×</button>');
						dialog.find('.bootbox-body').html('<div class="p-2"><div class="text-center"><i class="fas fa-exclamation-triangle text-danger fa-2x mb-2"></i> <p class="font-weight-normal m-0">'+response.data.msg+'</p></div></div>');

						setTimeout(function()
						{
							bootbox.hideAll();
						}, 850);
					});
				}
			})
			.catch(response =>
			{
				console.log(response);
			});

			e.preventDefault();
		}
	}
});
