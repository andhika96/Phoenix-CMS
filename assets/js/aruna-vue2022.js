// VueJS 2

Vue.component('paginate', VuejsPaginate);
Vue.component('v-select', VueSelect.VueSelect);

Vue.use(VueLazyload, 
{
	observer: true,
	error: baseurl+'assets/plugins/fontawesome/5.15.3/svgs/brands/elementor.svg',
	loading: baseurl+'assets/plugins/fontawesome/5.15.3/svgs/solid/redo-alt.svg'
});

const Vue2Form = new Vue(
{
	el: "#ar-app-form",
	data: 
	{
		form: {},
		responseMessageSubmit: '',
		responseMessageSignup: '',
		initResponse: [],
		initFormSignup: 
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
		submit: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		submitForSignup: function(event)
		{
			event.preventDefault();

			// Get id form signup
			let getIdFormSignup = document.getElementById("ar-form-signup");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSignup.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSignup.getElementsByTagName("form")[0].getAttribute("method");

			// Get value of submit button.
			let getValueButton = getIdFormSignup.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-inherit';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-signup")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-signup "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-signup")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						alert('Key URL for redirect after response callback not found!');
						console.log('Key URL for redirect after response callback not found!');

						document.getElementsByClassName("btn-loading-signup")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-signup "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-signup")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						document.getElementsByClassName("btn-loading-signup")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-signup")[0].remove();
					}

					// Set to false if all form have no errors
					this.initFormSignup['email'] 		= false;
					this.initFormSignup['username'] 	= false;
					this.initFormSignup['fullname'] 	= false;
					this.initFormSignup['password'] 	= false;
					this.initFormSignup['agreecheck'] 	= false;
				}
				else if (response.data.status == 'failed')
				{
					// Get data from response data
					this.responseMessageSignup = response.data.message;

					// Check variable if form have notice error and set to true
					this.initFormSignup['email'] 		= (this.responseMessageSignup['email'] != undefined) ? true : false;
					this.initFormSignup['username'] 	= (this.responseMessageSignup['username'] != undefined) ? true : false;
					this.initFormSignup['fullname'] 	= (this.responseMessageSignup['fullname'] != undefined) ? true : false;
					this.initFormSignup['password'] 	= (this.responseMessageSignup['password'] != undefined) ? true : false;
					this.initFormSignup['agreecheck'] 	= (this.responseMessageSignup['agreecheck'] != undefined) ? true : false;

					document.getElementsByClassName("btn-loading-signup")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-signup "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-signup")[0].remove();
				}

				document.getElementsByClassName("btn-token-signup")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-signup")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-signup "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-signup")[0].remove();

					document.getElementsByClassName("btn-token-signup")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		}
	}
});

const Vue2FormArticle = new Vue(
{
	el: "#ar-app-form-article",
	data: 
	{
		form: {},
		getDataVars: {},
		getDataVarText: [{ key: '', value: '' }],
		getDataVarImage: [{ key: '', value: '' }],
		getListCategory: [],
		getListSubcategory: [],
		getSelectedCategory: [],
		getSelectedSubcategory: [],
		responseMessageSubmit: '',
		imageEncode: '',
		metaImageEncode: '',
		loadingVars: true,
		loadingCategory: true,
		loadingSubcategory: true
	},
	methods: 
	{
		submit: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		submitSEO: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit-seo");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTMLSEO);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit-seo")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit-seo "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit-seo")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-seo")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit-seo")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit-seo "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit-seo")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-seo")[0];
						let toast = new bootstrap.Toast(toastBox);
						toast.hide();

						document.getElementsByClassName("btn-loading-submit-seo")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged-seo "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit-seo")[0].remove();
					}

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast-seo")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit-seo")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit-seo "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit-seo")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit-seo")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		submitCustomField: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit-custom-field");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTMLCustomField.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTMLCustomField.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTMLCustomField.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTMLCustomField);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit-custom-field")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit-custom-field "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit-custom-field")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-custom-field")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit-custom-field")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit btn-malika-submit-custom-field "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit-custom-field")[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-custom-field")[0];
						let toast = new bootstrap.Toast(toastBox);
						toast.hide();

						document.getElementsByClassName("btn-loading-submit-custom-field")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged-custom-field "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit-custom-field")[0].remove();
					}

					// this.listDataVars();

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast-custom-field")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit-custom-field")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit-custom-field "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit-custom-field")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit-custom-field")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast-custom-field")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit-custom-field")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit-custom-field "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+"\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit-custom-field")[0].remove();

					document.getElementsByClassName("btn-token-submit-custom-field")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		listDataVars: function()
		{
			if (document.querySelector(".ar-fetch-listdata-vars") !== null && 
				document.querySelector(".ar-fetch-listdata-vars").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-vars").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					if (response.data !== null)
					{
						this.getDataVarText = (response.data.custom_field.text !== undefined) ? response.data.custom_field.text : [];
						this.getDataVarImage = (response.data.custom_field.image !== undefined) ? response.data.custom_field.image : [];
					}
					else
					{
						this.getDataVarText.text = [];
						this.getDataVarImage.image = [];
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loadingVars = false;
				});
			}
		},
		addNewField: function(part_section)
		{
			if (part_section == 'custom_field_text')
			{
				this.getDataVarText.push({ key: '', value: ''});
			}
			else if (part_section == 'custom_field_image')
			{
				this.getDataVarImage.push({ key: '', value: ''});
			}
		},
		removeField: function(getData, index, menu_id, type)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+type+'/'+index+'/'+menu_id;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this menu, this action cannot be undone if you click Confirm?",
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
								getData.splice(index, 1);

								window.setTimeout(function() 
								{
									document.querySelector(".btn-malika-submit-custom-field").click();
								}, 100);

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
		activeSchedulePost: function()
		{
			// const getFormCheck = document.querySelectorAll('.form-check-input');

			// for (let i = 0; i < getFormCheck.length; i++) 
			// {
			// 	document.getElementsByClassName("form-check-input")[i].onclick = function() 
			// 	{
			// 		if (document.getElementsByClassName("form-check-input")[i].checked == true)
			// 		{
			// 			document.getElementsByClassName("form-from-check-input")[i].value = '';
			// 			document.getElementsByClassName("form-from-check-input")[i].setAttribute("disabled", "disabled");
			// 		}
			// 		else if (document.getElementsByClassName("form-check-input")[i].checked == false)
			// 		{
			// 			document.getElementsByClassName("form-from-check-input")[i].removeAttribute("disabled");
			// 		}
			// 	}
			// }

			if (document.getElementsByClassName("form-check-input")[0].checked == true)
			{
				document.getElementsByClassName("form-control-schedule-posts")[0].removeAttribute("disabled");
			}
			else if (document.getElementsByClassName("form-control-schedule-posts")[0].checked == false)
			{
				document.getElementsByClassName("form-control-schedule-posts")[0].setAttribute("disabled", "disabled");
			}
		},
		previewImage: function(event)
		{
			const fileReader = new FileReader();
			const image = new Image();
			const files = event.target.files;

			const imagePreview = document.getElementById("img-preview");

			const filename = files[0].name;
			fileReader.addEventListener('load', () => 
			{
				image.src = fileReader.result;

				image.addEventListener('load', () => 
				{
					// console.log(image.width+' x '+image.height);

					if (image.width > image.height)
					{
						imagePreview.classList.remove("h-100");

						// console.log('Its Landscape');
					} 
					else if (image.width < image.height)
					{
						imagePreview.classList.add("h-100");

						// console.log('Its Portrait');
					}
					else if (image.width == 0 && image.height == 0)
					{
						imagePreview.classList.add("h-100");
					}
					else
					{
						imagePreview.classList.remove("h-100");

						// console.log('Its Square');
					}

					this.imageEncode = fileReader.result;

					console.log(this.imageEncode);
				});
			});

			fileReader.readAsDataURL(files[0]);
		},
		previewMetaImage: function(event)
		{
			const fileReader = new FileReader();
			const image = new Image();
			const files = event.target.files;

			const imagePreview = document.getElementById("meta-image-preview");

			const filename = files[0].name;
			fileReader.addEventListener('load', () => 
			{
				image.src = fileReader.result;

				image.addEventListener('load', () => 
				{
					// console.log(image.width+' x '+image.height);

					if (image.width > image.height)
					{
						imagePreview.classList.remove("h-100");

						// console.log('Its Landscape');
					} 
					else if (image.width < image.height)
					{
						imagePreview.classList.add("h-100");

						// console.log('Its Portrait');
					}
					else if (image.width == 0 && image.height == 0)
					{
						imagePreview.classList.add("h-100");
					}
					else
					{
						imagePreview.classList.remove("h-100");

						// console.log('Its Square');
					}

					this.metaImageEncode = fileReader.result;
				});
			});

			fileReader.readAsDataURL(files[0]);
		},
		previewImageExist: function()
		{
			if (document.querySelector(".ar-fetch-detail-article") !== null && 
				document.querySelector(".ar-fetch-detail-article").getAttribute("data-url") !== null)
			{
				const image = new Image();
				const url = document.querySelector(".ar-fetch-detail-article").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const imagePreview = document.getElementById("img-preview");

					if (response.data[0].status != 'failed')
					{
						this.imageEncode = response.data[0].get_thumbnail;

						image.src = this.imageEncode;

						image.onload = function()
						{
							if (image.width > image.height)
							{
								imagePreview.classList.remove("h-100");

								// console.log('Its Landscape');
							} 
							else if (image.width < image.height)
							{
								imagePreview.classList.add("h-100");

								// console.log('Its Portrait');
							}
							else if (image.width == 0 && image.height == 0)
							{
								imagePreview.classList.add("h-100");
							}
							else
							{
								imagePreview.classList.remove("h-100");

								// console.log('Its Square');
							}
						}
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					// Empty
				});
			}
		},
		previewMetaImageExist: function()
		{
			if (document.querySelector(".ar-fetch-detail-metatag-article") !== null && 
				document.querySelector(".ar-fetch-detail-metatag-article").getAttribute("data-url") !== null)
			{
				const image = new Image();
				const url = document.querySelector(".ar-fetch-detail-metatag-article").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const imagePreview = document.getElementById("meta-image-preview");

					if (response.data[0].status != 'failed')
					{
						this.metaImageEncode = response.data[0].get_thumbnail;

						image.src = this.metaImageEncode;

						image.onload = function()
						{
							if (image.width > image.height)
							{
								imagePreview.classList.remove("h-100");

								// console.log('Its Landscape');
							} 
							else if (image.width < image.height)
							{
								imagePreview.classList.add("h-100");

								// console.log('Its Portrait');
							}
							else if (image.width == 0 && image.height == 0)
							{
								imagePreview.classList.add("h-100");
							}
							else
							{
								imagePreview.classList.remove("h-100");

								// console.log('Its Square');
							}
						}
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					// Empty
				});
			}
		}
	},
	created: function()
	{
		this.listDataVars();
		
		this.previewImageExist();

		this.previewMetaImageExist();
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
		responseMessageSubmit: ''
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

			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-secondary "+getButtonBlock+" btn-loading-submit m-0 px-3 py-2\">Loading <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();
			
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
							this.responseMessageSubmit = response.data.message;

							// We use toast from Bootstrap 5
							let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
							toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

							let toast = new bootstrap.Toast(toastBox);
							toast.show();

							document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika-submit "+getButtonBlock+" px-3 py-2\" value=\""+getValSubmit+"\">");
							document.getElementsByClassName("btn-loading-submit")[0].remove();
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

							document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-success btn-logged "+getButtonBlock+" m-0 px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
							document.getElementsByClassName("btn-loading-submit")[0].remove();
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
								}
							}
						}

						document.getElementsByClassName("cr-image")[0].setAttribute("src", "");
					}
					else if (response.data.status == 'failed')
					{
						this.responseMessageSubmit = response.data.message;
						
						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						if (document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset") !== null)
						{
							const formFileReset	= document.getElementById("ar-app-form-croppie").getElementsByTagName("form")[0].getAttribute("datafile-reset");
						
							if (formFileReset == "true")
							{
								const getResetFile = document.querySelectorAll('input[type="file"]');

								for (var i = 0; i < getResetFile.length; i++) 
								{
									getResetFile[i].value = '';
								}
							}
						}

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-bnight-blue btn-malika-submit "+getButtonBlock+" px-3 py-2\" value=\""+getValSubmit+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				})
				.catch(response => 
				{ 
					console.log(response);
				});
			});
		}
	}
});

const Vue2ListData = new Vue(
{
	el: "#ar-app-listdata",
	data: 
	{
		getData: {},
		getDataWOPage: {},
		getSelectedRoleofMenus: [],
		getListRoles: [],
		getListFormSlideshow: [{ name: '', id: undefined }],
		getListFormCoverimage: [{ name: '', id: undefined }],
		getTotalData: '',
		getCategory: '',
		pageURL: '',
		pageCategory: '',
		pageCount: '',
		pageRange: '',
		currentPage: '',
		getSearch: '',
		resSearch: '',
		responseMessageSubmit: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		show: true,
		showData: true,
		loading: true,
		loadingWOPage: true,
		loadingnextpage: true,
		loadingSlideshowPage: true,
		loadingCoverimagePage: true
	},
	methods: 
	{
		submit: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-inherit';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get with list data without pagination system or not
			let withListDataWOPage = this.$refs.formHTML.attributes['with-list-wopage']['value'] == 'true' ? true : false;

			// Get with list data without pagination system or not
			let withListDataSlideShowPage = this.$refs.formHTML.attributes['with-list-slideshow-page']['value'] == 'true' ? true : false;

			// Get with list data without pagination system or not
			let withListDataCoverImagePage = this.$refs.formHTML.attributes['with-list-coverimage-page']['value'] == 'true' ? true : false;

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit "+getButtonBlock+" "+getRoundedPill+" "+getFontSizeLarge+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}

					if (withListDataWOPage == true)
					{
						// Auto load list data without pagination sistem
						this.listDataWOPage();
					}

					if (withListDataSlideShowPage == true)
					{
						// Auto load list data without pagination sistem
						this.listDataSlideshow();
					}

					if (withListDataCoverImagePage == true)
					{
						// Auto load list data without pagination sistem
						this.listDataCoverimage();
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(response =>
			{
				this.responseMessageSubmit = response.response.data.message;

				let display_error = "";

				if (response.response.data.type == 'exception_error')
				{
					display_error = "<div> <p class=\"mb-2\">Type: "+response.response.data.title+"</p> <p class=\"mb-2\">Message: "+response.response.data.message+"</p> <p class=\"mb-2\">File Name: "+response.response.data.filename+"</p> <p class=\"mb-2\">Line Number: "+response.response.data.linenumber+"</p> </div>";
				}
				else
				{
					display_error = "<div> <p class=\"mb-2\">Type: "+response.response.data.title+"</p> <p class=\"mb-2\">Message: "+response.response.data.message+"</p> </div>";
				}

				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+display_error+"</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();

				document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
				document.getElementsByClassName("btn-loading-submit")[0].remove();

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'))
			});
		},
		listData: function()
		{
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data;
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
		listDataWOPage: function()
		{
			if (document.querySelector(".ar-fetch-listdata-wopage") !== null && 
				document.querySelector(".ar-fetch-listdata-wopage").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-wopage").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getRes = response.data.slice(0)[0];

					this.getDataWOPage 	= response.data;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loadingWOPage = false;
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
		listDataSlideshow: function()
		{
			if (document.querySelector(".ar-fetch-listdata-slideshow") !== null && 
				document.querySelector(".ar-fetch-listdata-slideshow").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-slideshow").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getRes = response.data.slice(0)[0];

					this.getListFormSlideshow 	= response.data;
					this.statusData 			= getRes.status;
					this.msgData 				= getRes.msg;

					if (document.querySelector(".color-picker") !== undefined)
					{
						$(function() 
						{
							$(".color-picker").spectrum(
							{
								type: "component",
								showInput: true,
								showInitial: true
							});
						
							$(".color-picker").on('change.spectrum', function(e, tinycolor) 
							{ 
								// Re-assign variable getListFormSlideshow to get data from response
								this.getListFormSlideshow	= response.data;

								// Get index data from list data
								let getThisIndex = $(this)[0].getAttribute("index-list");

								// Change value background overlay from user input
								this.getListFormSlideshow[getThisIndex].get_vars.style.background_overlay = tinycolor;
							});
						});
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					/*
					if (document.querySelector(".color-picker") !== undefined)
					{
						$(document).ready(function() 
						{
							$(".color-picker").spectrum({
								type: "component",
								showInput: true,
								showInitial: true
							});
						});
					}
					*/

					this.loadingSlideshowPage = false;
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
		listDataCoverimage: function()
		{
			if (document.querySelector(".ar-fetch-listdata-coverimage") !== null && 
				document.querySelector(".ar-fetch-listdata-coverimage").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-coverimage").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getRes = response.data.slice(0)[0];

					this.getListFormCoverimage	= response.data;
					this.statusData				= getRes.status;
					this.msgData				= getRes.msg;

					if (document.querySelector("#color-picker") !== undefined)
					{
						$(function() 
						{
							$("#color-picker").spectrum(
							{
								type: "component",
								showInput: true,
								showInitial: true
							});
						
							$("#color-picker").on('change.spectrum', function(e, tinycolor) 
							{ 
								// Re-assign variable getListFormCoverimage to get data from response
								this.getListFormCoverimage	= response.data;

								// Change value background overlay from user input
								this.getListFormCoverimage[0].get_var_style_background_overlay = tinycolor;
							});
						});
					}
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{
					this.loadingCoverimagePage = false;
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
				search: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
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
									search: "<i class=\"fas fa-check text-success fa-fw mr-1\"></i> Success",
									message: "<div class=\"text-center\">Data deleted !!</div>",
									centerVertical: true,
								});
							}
							else if (response.data.status == 'failed' && response.data.message !== '')
							{
								bootbox.alert({
									search: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
									message: "<div class=\"text-center\">"+response.data.message+"</div>",
									centerVertical: true,
								});
							}
							else
							{
								bootbox.alert({
									search: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
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
		deleteForm: function(getDataInfo, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			if (getId == undefined)
			{
				getDataInfo.splice(index, 1);
			}
			else
			{
				bootbox.confirm(
				{
					search: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
					message: "Are you sure, do you want to delete this item?",
					centerVertical: true,
					closeButton: false,
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
										search: "<i class=\"fas fa-check text-success fa-fw mr-1\"></i> Success",
										message: "<div class=\"text-center h6 m-0\">Data deleted !!</div>",
										centerVertical: true,
										closeButton: false
									});
								}
								else if (response.data.status == 'failed' && response.data.message !== '' && response.data.message !== undefined)
								{
									bootbox.alert({
										search: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
										message: "<div class=\"text-center h6 m-0\">"+response.data.message+"</div>",
										centerVertical: true,
										closeButton: false
									});
								}
								else if (response.data.status == 'failed' && response.data.message == undefined)
								{
									getDataInfo.splice(index, 1);
								}
								else
								{
									bootbox.alert({
										search: "<i class=\"fas fa-exclamation-triangle text-danger fa-fw mr-1\"></i> Error",
										message: "<div class=\"text-center h6 m-0\">Invalid Data Selected</div>",
										centerVertical: true,
										closeButton: false
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
			}
		},
		searchData: function(event)
		{
			const getSearch = this.getSearch.trim();

			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				if (this.pageCategory != '')
				{
					this.resSearch = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.resSearch = '?search='+this.getSearch;
				}

				this.loadingnextpage = true;

				axios.get(getUrl+this.resSearch)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				if (this.getSearch != '')
				{
					this.getCat = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}

				document.querySelector("#ar-data").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				this.pageCategory = getCategory;

				if (this.getSearch != '')
				{
					this.getCat = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}
				
				document.querySelector("#ar-data").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		selectCoverImageType: function(getType)
		{
			if (getType == 'only_image')
			{
				const SelectSizeDesktop = document.querySelector(".ph-form-select-size-desktop");
				const SelectSizeMobile = document.querySelector(".ph-form-select-size-mobile");
				const SelectParallax = document.querySelector(".ph-form-select-is-parallax");

				SelectSizeDesktop.setAttribute("disabled", "");
				SelectSizeMobile.setAttribute("disabled", "");
				SelectParallax.setAttribute("disabled", "");
			}
			else
			{
				const SelectSizeDesktop = document.querySelector(".ph-form-select-size-desktop");
				const SelectSizeMobile = document.querySelector(".ph-form-select-size-mobile");
				const SelectParallax = document.querySelector(".ph-form-select-is-parallax");

				SelectSizeDesktop.removeAttribute("disabled", "");
				SelectSizeMobile.removeAttribute("disabled", "");
				SelectParallax.removeAttribute("disabled", "");
			}
		},
		clickPaginate: async function(page) 
		{
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				let params = (new URL(url)).searchParams;

				if (this.pageCategory !== '')
				{
					params.set('category', this.pageCategory);
				}
				
				if (this.getSearch !== '')
				{
					params.set('getSearch', this.getSearch);
				}

				if (params.toString() !== '')
				{
					if (page == 1)
					{
						this.pageUrl = '?'+params.toString();
					}
					else
					{
						this.pageUrl = '?'+params.toString()+'&page='+page;
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

					this.getData 		= response.data;
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;

					document.querySelector("#ar-data").scrollIntoView(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading 			= false;
					this.loadingnextpage 	= false;
				});
			}
		},
		getListDataRoles: function()
		{
			if (document.querySelector(".ar-fetch-listdata-getlistroles") !== null && 
				document.querySelector(".ar-fetch-listdata-getlistroles").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-getlistroles").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					this.getListRoles = response.data;
				})
				.catch(function(error) 
				{
					console.log(error);
				});
			}
		},
		getListSelectedRoleofMenus: function()
		{
			if (document.querySelector(".ar-fetch-listdata-getrolemenus") !== null && 
				document.querySelector(".ar-fetch-listdata-getrolemenus").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-getrolemenus").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					this.getSelectedRoleofMenus = response.data;
				})
				.catch(function(error) 
				{
					console.log(error);
				});
			}
		},
		addFormSlideshow: function(part_section)
		{
			if (this.getListFormSlideshow.length < 5)
			{
				this.getListFormSlideshow.push({ title: '', caption: '', get_vars: { button: [ {title: '', content: ''}, {title: '', content: ''} ], style: {position: 'center', background_overlay: '' } }});

				$(document).ready(function() 
				{
					$(".color-picker").spectrum({
						type: "component",
						showInput: true,
						showInitial: true
					});
				});

				console.log(this.getListFormSlideshow);
			}
			else
			{
				alert('Maximum form for slideshow is '+this.getListFormSlideshow.length);
			}
		},
		addFormCoverimage: function(part_section)
		{
			if (this.getListFormCoverimage.length < 5)
			{
				this.getListFormCoverimage.push({ name: ''});
			}
			else
			{
				alert('Maximum form for cover image is '+this.getListFormCoverimage.length);
			}
		}
	},
	created: function()
	{
		// Auto load list data with pagination system
		this.listData();

		// Auto load list data without pagination sistem
		this.listDataWOPage();

		this.listDataSlideshow();

		this.listDataCoverimage();

		this.getListDataRoles();

		this.getListSelectedRoleofMenus();
	}
});

const Vue2FooterContent = new Vue(
{
	el: "#ar-app-footer-content",
	data: 
	{
		getData: {},
		getDataIcon: {},
		getListDataIcon: {},
		getListForm: [{ name: ''}],
		getListFooter1: [{ icon: '', link: '', content: '', type: 'text'}],
		getListFooter2: [{ icon: '', link: '', content: '', type: 'text'}],
		getListFooter3: [{ icon: '', link: '', content: '', type: 'text'}],
		getSearchIcon: '',
		showData: true,
		loadingData: true,
		loadingDataIcon: true,
		statusData: '',
		messageData: '',
		statusDataIcon: '',
		messageDataIcon: ''
	},
	methods:
	{
		listData: function()
		{
			if (document.querySelector(".ar-fetch-listdata-footer") !== null && 
				document.querySelector(".ar-fetch-listdata-footer").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-footer").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					// const getRes = response.data.slice(0)[0];

					const initListFooter1 = response.data.footer_right_link1;

					this.getListFooter1 = response.data.footer_right_link1;
					this.getListFooter2 = response.data.footer_right_link2;
					this.getListFooter3 = response.data.footer_right_link3;

					// this.statusData 	= getRes.status;
					// this.messageData 	= getRes.message;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{
					IconPicker.Init(
					{
						jsonUrl: baseurl+"assets/plugins/iconpicker/dist/iconpicker-1.5.0.json",
						searchPlaceholder: "Search Icon",
						showAllButton: "Show All",
						cancelButton: "Cancel",
						noResultsFound: "No results found.",
						borderRadius: "20px",
					});	

					const GetFAIconListFooter1 = document.querySelectorAll(".GetFAIconListFooter1");

					for (let i = 0; i < GetFAIconListFooter1.length; i++) 
					{
						IconPicker.Run(".GetIconPickerListFooter1_"+i);
					}

					const GetFAIconListFooter2 = document.querySelectorAll(".GetFAIconListFooter2");

					for (let i = 0; i < GetFAIconListFooter1.length; i++) 
					{
						IconPicker.Run(".GetIconPickerListFooter2_"+i);
					}

					const GetFAIconListFooter3 = document.querySelectorAll(".GetFAIconListFooter3");

					for (let i = 0; i < GetFAIconListFooter1.length; i++) 
					{
						IconPicker.Run(".GetIconPickerListFooter3_"+i);
					}

					this.loadingData = false;
				});
			}

			// if (document.querySelector(".ar-data-status") !== null)
			// {
			// 	if (getComputedStyle(document.querySelector('.ar-data-status'), null).display == 'none')
			// 	{
			// 		document.querySelector(".ar-data-status").style.display = 'block';
			// 	}
			// }

			// if (document.querySelector(".ar-data-load") !== null)
			// {
			// 	if (getComputedStyle(document.querySelector('.ar-data-load'), null).display == 'none')
			// 	{
			// 		document.querySelector(".ar-data-load").style.display = 'block';
			// 	}
			// }

			// if (document.querySelector(".ar-total-data-load") !== null)
			// {
			// 	if (getComputedStyle(document.querySelector('.ar-total-data-load'), null).display == 'none')
			// 	{
			// 		document.querySelector(".ar-total-data-load").style.display = 'block';
			// 	}
			// }
		},
		multipleSubmit: function(event, idSubmit)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit-"+idSubmit);

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs['formHTML'+idSubmit].attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs['formHTML'+idSubmit].attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-inherit';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs['formHTML'+idSubmit].attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs['formHTML'+idSubmit]);

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit-"+idSubmit)[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit-"+idSubmit+" "+getButtonBlock+" "+getRoundedPill+" "+getFontSizeLarge+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit-"+idSubmit)[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-"+idSubmit)[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit btn-malika-submit-"+idSubmit+" "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].remove();
					}
					else
					{
						window.setTimeout(function() 
						{
							window.location.href = response.data.url;
						}, 500);

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast-"+idSubmit)[0];
						let toast = new bootstrap.Toast(toastBox);
						toast.hide();

						document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged-"+idSubmit+" "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].remove();
					}

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}

					console.log(response.data);
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast-"+idSubmit)[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit btn-malika-submit-"+idSubmit+" "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit-"+idSubmit)[0].remove();
				}

				document.getElementsByClassName("btn-token-submit-"+idSubmit)[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(response =>
			{
				console.log(response);
			});
		},
		addNewForm: function(part_section)
		{
			if (part_section == 'list_footer1')
			{
				this.getListFooter1.push({ icon: '', link: '', content: '', type: 'text'});

				setTimeout(function() 
				{
					const GetFAIconListFooter1 = document.querySelectorAll(".GetFAIconListFooter1");

					const getBeforeLatestID = GetFAIconListFooter1.length-1;

					IconPicker.Run(".GetIconPickerListFooter1_"+getBeforeLatestID);

				}, 100);
			}
			else if (part_section == 'list_footer2')
			{
				this.getListFooter2.push({ icon: '', link: '', content: '', type: 'text'});

				setTimeout(function() 
				{
					const GetFAIconListFooter2 = document.querySelectorAll(".GetFAIconListFooter2");

					const getBeforeLatestID = GetFAIconListFooter2.length-1;

					IconPicker.Run(".GetIconPickerListFooter2_"+getBeforeLatestID);

				}, 100);
			}
			else if (part_section == 'list_footer3')
			{
				this.getListFooter3.push({ icon: '', link: '', content: '', type: 'text'});

				setTimeout(function() 
				{
					const GetFAIconListFooter3 = document.querySelectorAll(".GetFAIconListFooter3");

					const getBeforeLatestID = GetFAIconListFooter3.length-1;

					IconPicker.Run(".GetIconPickerListFooter3_"+getBeforeLatestID);

				}, 100);
			}
		},
		deleteForm: function(getDataInfo, index, getId)
		{
			bootbox.confirm(
			{
				search: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this item?",
				centerVertical: true,
				closeButton: false,
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
						getDataInfo.splice(index, 1);
					}
				}
			});
		},
		selectFooterType: function(event)
		{
			console.log(event.target.value);

			if (event.target.value == 'text')
			{
				if (document.querySelector(".ar-display-footer-text") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-display-footer-text'), null).display == 'none')
					{
						document.querySelector(".ar-display-footer-text").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-display-footer-logo") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-display-footer-logo'), null).display == 'block')
					{
						document.querySelector(".ar-display-footer-logo").style.display = 'none';
					}
				}
			}
			else if (event.target.value == 'logo')
			{
				if (document.querySelector(".ar-display-footer-text") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-display-footer-text'), null).display == 'block')
					{
						document.querySelector(".ar-display-footer-text").style.display = 'none';
					}
				}

				if (document.querySelector(".ar-display-footer-logo") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-display-footer-logo'), null).display == 'none')
					{
						document.querySelector(".ar-display-footer-logo").style.display = 'block';
					}
				}
			}
		}
	},
	created: function()
	{
		this.listData();
	}
});

const Vue2ListDataForArticle = new Vue(
{
	el: "#ar-app-listdata-article",
	data: 
	{
		getData: {},
		getDataModal: {},
		getTotalData: '',
		getCategory: '',
		pageURL: '',
		pageCategory: '',
		pageCount: '',
		pageRange: '',
		currentPage: '',
		getSearch: '',
		resSearch: '',
		resModal: '',
		responseMessageSubmit: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		msgDataModal: '',
		show: true,
		showData: true,
		showDataModal: true,
		loading: true,
		loadingnextpage: true,
		loadingmodal: true
	},
	methods: 
	{
		listData: function()
		{
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data;
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
		openDataModal: function(detail_key)
		{
			const detailModalPortofolio = new bootstrap.Modal(document.getElementById('detailModalPortofolio'));

			detailModalPortofolio.show();

			if (document.querySelector(".ar-fetch-data-modal") !== null && 
				document.querySelector(".ar-fetch-data-modal").getAttribute("data-modal-url") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch-data-modal").getAttribute("data-modal-url");

				this.resModal = '?uri='+detail_key;

				axios.get(getUrl+this.resModal)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getDataModal 		= response.data
					this.statusDataModal	= getRes.status;
					this.msgDataModal 		= getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loadingmodal = false;

					if (document.querySelector(".ar-modal-data-load") !== null)
					{
						if (getComputedStyle(document.querySelector(".ar-modal-data-load"), null).display == 'block')
						{
							document.querySelector(".ar-modal-data-load").style.display = 'none';
						}
					}

					if (document.querySelector(".ar-modal-data-list") !== null)
					{
						if (getComputedStyle(document.querySelector(".ar-modal-data-list"), null).display == 'none')
						{
							document.querySelector(".ar-modal-data-list").style.display = 'block';
						}
					}
				});
			}

			let myModalEl = document.getElementById('detailModalPortofolio');
			myModalEl.addEventListener('hidden.bs.modal', function(event) 
			{
				if (document.querySelector(".ar-modal-data-load") !== null)
				{
					if (getComputedStyle(document.querySelector(".ar-modal-data-load"), null).display == 'none')
					{
						document.querySelector(".ar-modal-data-load").style.display = 'block';
					}
				}

				if (document.querySelector(".ar-modal-data-list") !== null)
				{
					if (getComputedStyle(document.querySelector(".ar-modal-data-list"), null).display == 'block')
					{
						document.querySelector(".ar-modal-data-list").style.display = 'none';
					}
				}
			});
		},
		searchData: function(event)
		{
			const getSearch = this.getSearch.trim();

			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				if (this.pageCategory != '')
				{
					this.resSearch = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.resSearch = '?search='+this.getSearch;
				}

				this.loadingnextpage = true;

				axios.get(getUrl+this.resSearch)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
		selectCategory: function() 
		{
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				if (this.getSearch != '')
				{
					this.getCat = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}

				document.querySelector("#ar-data").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => this.loading = false);
			}
		},
		clickCategory: function(getCategory) 
		{
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				this.pageCategory = getCategory;

				if (this.getSearch != '')
				{
					this.getCat = '?category='+this.pageCategory+'&search='+this.getSearch;
				}
				else
				{
					this.getCat = '?category='+this.pageCategory;
				}
				
				document.querySelector("#ar-data").scrollIntoView(true);

				this.loading = true;

				axios.get(url+this.getCat)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					this.getData 		= response.data
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;
					this.currentPage 	= getval.getDataPage.current_page;
					this.statusData 	= getRes.status;
					this.msgData 		= getRes.msg;
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
			if (document.querySelector(".ar-fetch-listdata") !== null && 
				document.querySelector(".ar-fetch-listdata").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata").getAttribute("data-url");

				let params = (new URL(url)).searchParams;

				if (this.pageCategory !== '')
				{
					params.set('category', this.pageCategory);
				}
				
				if (this.getSearch !== '')
				{
					params.set('search', this.getSearch);
				}

				if (params.toString() !== '')
				{
					if (page == 1)
					{
						this.pageUrl = '?'+params.toString();
					}
					else
					{
						this.pageUrl = '?'+params.toString()+'&page='+page;
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

					this.getData 		= response.data;
					this.getTotalData 	= getval.getDataPage.total_data;
					this.pageCount 		= getval.getDataPage.total;
					this.pageRange 		= getval.getDataPage.num_per_page;

					document.querySelector("#ar-data").scrollIntoView(true);
				})
				.catch(function(error) 
				{
					console.log(error);
				})
				.finally(() => 
				{ 
					this.loading 			= false;
					this.loadingnextpage 	= false;
				});
			}
		}
	},
	created: function()
	{
		this.listData();
	}
});

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
		searchUser: async function(event)
		{
			const getUser = this.getUser.trim();

			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const getUrl = document.querySelector(".ar-fetch").getAttribute("data-fetch-user");

				this.getUsers 			= this.getUser;
				this.resUser 			= '?user='+this.getUser;
				this.loadingnextpage 	= true;

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

				if (document.querySelector(".btn-token-submit") !== null)
				{
					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			}
		},
		clickPaginate: async function(page) 
		{
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const url 		= document.querySelector(".ar-fetch").getAttribute("data-fetch-user");
				const checkbox 	= document.querySelectorAll(".checkids");
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

				if (this.getUsers !== '')
				{
					params.set('user', this.getUsers);
				}

				if (params.toString() !== '')
				{
					if (page == 1)
					{
						this.pageUrl = '?'+params.toString();
					}
					else
					{
						this.pageUrl = '?'+params.toString()+'&page='+page;
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

				if (document.querySelector(".btn-token-submit") !== null)
				{
					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			}
		},
		afterUpdateStatus: async function()
		{
			if (document.querySelector(".ar-fetch") !== null && 
				document.querySelector(".ar-fetch").getAttribute("data-fetch-user") !== null)
			{
				const url 		= document.querySelector(".ar-fetch").getAttribute("data-fetch-user");
				const checkbox 	= document.querySelectorAll(".checkids");
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
				
				let params = (new URL(url)).searchParams;

				if (this.getUsers !== '')
				{
					params.set('user', this.getUsers);
				}

				if (params.toString() !== '')
				{
					if (this.getPage == 1)
					{
						this.pageUrl = '?'+params.toString();
					}
					else
					{
						this.pageUrl = '?'+params.toString()+'&page='+this.getPage;
					}
				}
				else
				{
					if (this.getPage == 1)
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

				if (document.querySelector(".btn-token-submit") !== null)
				{
					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
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

			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-secondary "+getButtonBlock+" btn-loading-submit font-size-inherit m-0 px-3 py-2\">Loading <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

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
						this.msgData = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.msgData+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" font-size-inherit px-3 py-2\" value=\""+getValSubmit+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a href=\"javascript:void(0)\" class=\"btn btn-success btn-logged "+getButtonBlock+" font-size-inherit m-0 px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					if (formReset == "true")
					{
						document.getElementById("ar-listuser").getElementsByTagName("form")[0].reset();
					}

					this.afterUpdateStatus();
				}
				else if (response.data.status == 'failed')
				{
					this.msgData = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.msgData+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" font-size-inherit px-3 py-2\" value=\""+getValSubmit+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
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

const VueImage = new Vue({
	el: '#ar-listimages',
	data:
	{
		getData: {},
		getCat: '',
		pageCount: '',
		pageRange: '',
		pageUrl: '',
		pageCategory: '',
		currentPage: '',
		getTitle: '',
		resArticle: '',
		isAvailable: 0,
		statusData: '',
		msgData: '',
		isData: true,
		show: true,
		loading: true,
		loadingnextpage: true
	},
	methods:
	{
		fetchListImages: function()
		{
			console.log("Loaded");

			if (document.querySelector(".ar-fetch-listimage") !== null && 
				document.querySelector(".ar-fetch-listimage").getAttribute("data-url") !== null)
			{
				const getDataFetch = document.querySelector(".ar-fetch-listimage").getAttribute("data-url");

				axios.get(getDataFetch)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];

					if (getRes.status == 'failed')
					{
						this.statusData = getRes.status;
						this.msgData 	= getRes.msg;
					}
					else
					{
					 	this.getData 	= response.data;
						this.pageCount 	= getval.getDataPage.total;
						this.pageRange 	= getval.getDataPage.num_per_page;
						this.isData 	= false;
					}
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
		initDeletePopupData: function(getDataInfo, index, getId)
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
		/*
		openNewUploadPopup: function()
		{
			$('#NewPhotoModal').modal('show');
		},
		*/
		closeNewUploadPopup: function()
		{
			/*
			setTimeout(function() { $('#NewPhotoModal').modal('hide'); }, 150);

			if (document.querySelector(".ar-fetch-listimage") !== null && 
				document.querySelector(".ar-fetch-listimage").getAttribute("data-url") !== null)
			{
				const getDataFetch = document.querySelector(".ar-fetch-listimage").getAttribute("data-url");

				axios.get(getDataFetch)
				.then(response => 
				{
					const getval = response.data.slice(-1)[0];
					const getRes = response.data.slice(0)[0];
					
					if (getRes.status == 'failed')
					{
						this.statusData = getRes.status;
						this.msgData = getRes.msg;
					}
					else
					{
					 	this.getData = response.data;
						this.pageCount = getval.getDataPage.total;
						this.pageRange = getval.getDataPage.num_per_page;
						this.currentPage = getval.getDataPage.current_page;
						this.isData = false;
					}
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
			*/

			bootstrap.Modal.getInstance(document.getElementById('uploadImageModal')).hide();

			this.fetchListImages();
		},
		clickPaginate: function(page) 
		{
			if (document.querySelector(".ar-fetch-listimage") !== null && 
				document.querySelector(".ar-fetch-listimage").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listimage").getAttribute("data-url");

				if (page == 1)
				{
					this.pageUrl = '';
				}
				else
				{
					this.pageUrl = '?page='+page;
				}

				this.loadingnextpage = true;

				document.querySelector("#ar-listimages").scrollIntoView(true);

				axios.get(url+this.pageUrl)
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
		this.fetchListImages();
	}
});

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
						dialog.find('.bootbox-body').html('<div class="p-2"><div class="text-center"><i class="fas fa-check text-success fa-2x mb-1"></i> <p class="font-weight-normal m-0">'+response.data.message+'</p></div></div>');

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
						dialog.find('.bootbox-body').html('<div class="p-2"><div class="text-center"><i class="fas fa-exclamation-triangle text-danger fa-2x mb-2"></i> <p class="font-weight-normal m-0">'+response.data.message+'</p></div></div>');

						setTimeout(function()
						{
							bootbox.hideAll();
						}, 850);
					});
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(response =>
			{
				console.log(response);
			});

			e.preventDefault();
		}
	}
});

const Vue2ListDataForDropdown = new Vue(
{
	el: "#ar-app-listdata-dropdown",
	data: 
	{
		getData: [{ menu_type: '', menu_name: '', menu_link: '', menu_icon: '' }],
		getNewMenu: '',
		getNewCustomMenu:
		{
			menu_name: '',
			menu_link: ''
		},
		statusData: '',
		msgData: '',
		msgDataModal: '',
		menu_type: '',
		menu_id: 0,
		menu_icon: '',
		show: true,
		showData: true,
		showDataModal: true,
		loading: true,
		loadingnextpage: true,
		loadingmodal: true
	},
	methods: 
	{
		submit: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			formData.append('menu_vars', JSON.stringify(this.getData));

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					this.listData();

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		listData: function()
		{
			if (document.querySelector(".ar-fetch-listdata-dropdown") !== null && 
				document.querySelector(".ar-fetch-listdata-dropdown").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-dropdown").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					this.getData = response.data;
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
		deleteDataMenuIcon: function(getDataInfo, index, getId)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+getId;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this menu icon, this action cannot be undone if you click Confirm?",
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
		selectMenuType: function(event) 
		{
			if (event.target.value == 'page')
			{
				if (document.querySelector(".ar-form-dropdown-type-page") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-dropdown-type-page'), null).display == 'none')
					{
						document.querySelector(".ar-form-dropdown-type-page").style.display = 'flex';
					}
				}

				if (document.querySelector(".ar-form-dropdown-type-custom") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-dropdown-type-custom'), null).display == 'flex')
					{
						document.querySelector(".ar-form-dropdown-type-custom").style.display = 'none';
					}
				}
			}
			else if (event.target.value == 'custom_link')
			{
				if (document.querySelector(".ar-form-dropdown-type-page") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-dropdown-type-page'), null).display == 'flex')
					{
						document.querySelector(".ar-form-dropdown-type-page").style.display = 'none';
					}
				}

				if (document.querySelector(".ar-form-dropdown-type-custom") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-dropdown-type-custom'), null).display == 'none')
					{
						document.querySelector(".ar-form-dropdown-type-custom").style.display = 'flex';
					}
				}
			}

			this.menu_type = event.target.value;

			document.getElementsByClassName("menu_type")[0].setAttribute("value", event.target.value);
		},
		addIcon: function(event)
		{
			this.menu_icon = event.target.files[0];
		},
		addMenu: function() 
		{
			if (this.menu_type == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please select menu type</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else if (this.menu_type == 'page' && this.getNewMenu == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please select menu</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else if (this.menu_type == 'custom_link' && this.getNewCustomMenu.menu_name == '' ||
					 this.menu_type == 'custom_link' && this.getNewCustomMenu.menu_link == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please enter Menu Name and Menu Link</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">New menu added</div></div>";					

				let toast = new bootstrap.Toast(toastBox);
				toast.show();

				if (this.menu_type == 'page')
				{					
					this.getData.push({ menu_type: document.getElementsByClassName("menu_type")[0].getAttribute("value"), menu_name: this.ucFirst(this.getNewMenu), menu_link: this.getNewMenu, menu_icon: this.menu_icon });
				
					// Reset value after succesfully add the new menu
					this.getNewMenu = '';
				}
				else if (this.menu_type == 'custom_link')
				{
					this.getData.push({ menu_type: document.getElementsByClassName("menu_type")[0].getAttribute("value"), menu_name: this.getNewCustomMenu.menu_name, menu_link: this.getNewCustomMenu.menu_link, menu_icon: this.menu_icon });
				
					// Reset value after succesfully add the new menu
					this.getNewCustomMenu.menu_name = '';
					this.getNewCustomMenu.menu_link = '';
				}

				const getBeforeLatestIndex = this.getData.length-1;

				if (this.menu_icon !== '')
				{
					// Create a new File object
					const myFile = new File([this.menu_icon.slice(0, this.menu_icon.size, this.menu_icon.type)], this.menu_icon.name);

					const getResetFile = document.querySelector('.form-control-file-0').value = '';

					this.menu_icon = '';

					setTimeout(function()
					{
						const fileInput = document.querySelector(".menu_icon_"+getBeforeLatestIndex);

						// Now let's create a DataTransfer to get a FileList
						const dataTransfer = new DataTransfer();
						dataTransfer.items.add(myFile);
						fileInput.files = dataTransfer.files;
					}, 100);
				}
			}
		},
		removeMenu: function(getData, index, menu_id)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+index+'/'+menu_id;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this menu, this action cannot be undone if you click Confirm?",
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
								getData.splice(index, 1);

								document.querySelector("input[type='submit']").click();

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
		ucFirst: function(string)
		{
			string = string.toLowerCase().replace(/\b[a-z]/g, function(letter) 
			{
				return letter.toUpperCase();
			});

			return string;
		},
		strToLowerCase: function(string)
		{
			string = string.toLowerCase().replace(/\s/g, "");

			return string;
		}
	},
	created: function()
	{
		this.listData();
	}
});

const Vue2ListDataForHeader = new Vue(
{
	el: "#ar-app-listdata-header",
	data: 
	{
		getData: [{ menu_type: '', menu_code: '', menu_name: '', menu_link: '', menu_icon: '' }],
		getNewMenu: '',
		getNewCustomMenu:
		{
			menu_name: '',
			menu_link: ''
		},
		statusData: '',
		msgData: '',
		msgDataModal: '',
		menu_type: '',
		menu_id: 0,
		menu_icon: '',
		show: true,
		showData: true,
		loading: true
	},
	methods: 
	{
		submit: function(event)
		{
			event.preventDefault();

			// Get id form submit
			let getIdFormSubmit = document.getElementById("ar-form-submit");

			// Get value of attribute in HTML.
			let formActionURL = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("action"); 
			let formMethod = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("method");

			// Reset form or input file
			let formReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-reset");
			let formFileReset = getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset");

			// Get value of submit button.
			let getValueButton = getIdFormSubmit.querySelector('input[type="submit"]').getAttribute('value');

			// Get using button block or not with value true and false from button-block attribute
			let getButtonBlock = this.$refs.formHTML.attributes['button-block']['value'] == 'true' ? 'w-100' : '';

			// Get rounded pill button or just rounded
			let getRoundedPill = this.$refs.formHTML.attributes['button-rounded-pill']['value'] == 'true' ? 'rounded-pill' : 'rounded';

			// Get using button large or not with value true and false from button-large attribute
			let getFontSizeLarge = this.$refs.formHTML.attributes['font-size-large']['value'] == 'true' ? 'font-size-large' : 'font-size-normal';

			// FormData objects are used to capture HTML form and submit it using fetch or another network method.
			let formData = new FormData(this.$refs.formHTML);

			formData.append('hmenu_vars', JSON.stringify(this.getData));

			// Get class button name to change the button to button loading state .
			document.getElementsByClassName("btn-malika-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-secondary btn-loading-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Submitting <div class=\"spinner-border spinner-border-sm text-light ml-1\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></a>");
			document.getElementsByClassName("btn-malika-submit")[0].remove();

			axios(
			{
				url: formActionURL,
				method: formMethod,
				data: formData,
				headers: {"Content-Type": "multipart/form-data", 'X-Requested-With': 'XMLHttpRequest'}
			})
			.then(response => 
			{
				if (response.data.status == 'success')
				{
					if ( ! response.data.url)
					{
						this.responseMessageSubmit = response.data.message;

						// We use toast from Bootstrap 5
						let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
						toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";					

						let toast = new bootstrap.Toast(toastBox);
						toast.show();

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
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

						document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<a class=\"btn btn-success btn-logged "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\">Success <i class=\"far fa-check-circle fa-fw mr-1\"></i></div></a>");
						document.getElementsByClassName("btn-loading-submit")[0].remove();
					}

					this.listData();

					if (formReset == "true")
					{
						getIdFormSubmit.getElementsByTagName("form")[0].reset();
					}

					if (getIdFormSubmit.getElementsByTagName("form")[0].getAttribute("form-file-reset") !== null)
					{					
						if (formFileReset == "true")
						{
							const getResetFile = document.querySelectorAll('input[type="file"]');

							for (var i = 0; i < getResetFile.length; i++) 
							{
								getResetFile[i].value = '';
							}
						}
					}
				}
				else if (response.data.status == 'failed')
				{
					this.responseMessageSubmit = response.data.message;
					
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+this.responseMessageSubmit+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();
				}

				document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
			})
			.catch(error =>
			{
				if (error.response !== undefined)
				{
					// We use toast from Bootstrap 5
					let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
					toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">"+error.response.statusText+"</div></div>";

					let toast = new bootstrap.Toast(toastBox);
					toast.show();

					document.getElementsByClassName("btn-loading-submit")[0].insertAdjacentHTML("beforebegin", "<input type=\"submit\" class=\"btn btn-malika-submit "+getButtonBlock+" "+getFontSizeLarge+" "+getRoundedPill+" px-3 py-2\" value=\""+getValueButton+"\">");
					document.getElementsByClassName("btn-loading-submit")[0].remove();

					document.getElementsByClassName("btn-token-submit")[0].setAttribute("value", this.$cookies.get('csrf_phoenix_cms_2023'));
				}
			});
		},
		listData: function()
		{
			if (document.querySelector(".ar-fetch-listdata-header") !== null && 
				document.querySelector(".ar-fetch-listdata-header").getAttribute("data-url") !== null)
			{
				const url = document.querySelector(".ar-fetch-listdata-header").getAttribute("data-url");

				axios.get(url)
				.then(response => 
				{
					this.getData = response.data;
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
		selectMenuType: function(event) 
		{
			if (event.target.value == 'page')
			{
				if (document.querySelector(".ar-form-header-type-page") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-header-type-page'), null).display == 'none')
					{
						document.querySelector(".ar-form-header-type-page").style.display = 'flex';
					}
				}

				if (document.querySelector(".ar-form-header-type-custom") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-header-type-custom'), null).display == 'flex')
					{
						document.querySelector(".ar-form-header-type-custom").style.display = 'none';
					}
				}
			}
			else if (event.target.value == 'custom_link')
			{
				if (document.querySelector(".ar-form-header-type-page") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-header-type-page'), null).display == 'flex')
					{
						document.querySelector(".ar-form-header-type-page").style.display = 'none';
					}
				}

				if (document.querySelector(".ar-form-header-type-custom") !== null)
				{
					if (getComputedStyle(document.querySelector('.ar-form-header-type-custom'), null).display == 'none')
					{
						document.querySelector(".ar-form-header-type-custom").style.display = 'flex';
					}
				}
			}

			this.menu_type = event.target.value;

			document.getElementsByClassName("menu_type")[0].setAttribute("value", event.target.value);
		},
		addIcon: function(event)
		{
			this.menu_icon = event.target.files[0];
		},
		addMenu: function() 
		{
			if (this.menu_type == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please select menu type</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else if (this.menu_type == 'page' && this.getNewMenu == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please select menu</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else if (this.menu_type == 'custom_link' && this.getNewCustomMenu.menu_name == '' ||
					 this.menu_type == 'custom_link' && this.getNewCustomMenu.menu_link == '')
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-danger rounded m-xl-3\"><div class=\"toast-header bg-danger text-white\"><h6 class=\"m-0\"><i class=\"fas fa-exclamation-triangle me-2\"></i> Notice</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">Please enter Menu Name and Menu Link</div></div>";

				let toast = new bootstrap.Toast(toastBox);
				toast.show();
			}
			else
			{
				// We use toast from Bootstrap 5
				let toastBox = document.getElementsByClassName("ar-notice-toast")[0];
				toastBox.innerHTML = "<div class=\"ar-alert position-fixed bg-success rounded m-xl-3\"><div class=\"toast-header bg-success text-white\"><h6 class=\"m-0\"><i class=\"fas fa-check me-2\"></i> Success</h6> <button type=\"button\" class=\"btn-close btn-close-white me-0 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Close\"></button></div> <div class=\"toast-body text-white\">New menu added</div></div>";					

				let toast = new bootstrap.Toast(toastBox);
				toast.show();

				if (this.menu_type == 'page')
				{
					this.getData.push({ menu_type: document.getElementsByClassName("menu_type")[0].getAttribute("value"), menu_code: this.strToLowerCase(this.getNewMenu), menu_name: this.ucFirst(this.getNewMenu), menu_link: this.getNewMenu, menu_icon: this.menu_icon });
				
					// Reset value after succesfully add the new menu
					this.getNewMenu = '';
				}
				else if (this.menu_type == 'custom_link')
				{
					this.getData.push({ menu_type: document.getElementsByClassName("menu_type")[0].getAttribute("value"), menu_code: this.strToLowerCase(this.getNewCustomMenu.menu_name), menu_name: this.getNewCustomMenu.menu_name, menu_link: this.getNewCustomMenu.menu_link, menu_icon: this.menu_icon });
				
					// Reset value after succesfully add the new menu
					this.getNewCustomMenu.menu_name = '';
					this.getNewCustomMenu.menu_link = '';
				}

				const getBeforeLatestIndex = this.getData.length-1;

				if (this.menu_icon !== '')
				{
					// Create a new File object
					const myFile = new File([this.menu_icon.slice(0, this.menu_icon.size, this.menu_icon.type)], this.menu_icon.name);

					const getResetFile = document.querySelector('.form-control-file-0').value = '';

					this.menu_icon = '';

					setTimeout(function()
					{
						const fileInput = document.querySelector(".menu_icon_"+getBeforeLatestIndex);

						// Now let's create a DataTransfer to get a FileList
						const dataTransfer = new DataTransfer();
						dataTransfer.items.add(myFile);
						fileInput.files = dataTransfer.files;
					}, 100);
				}
			}
		},
		removeMenu: function(getData, index, menu_id)
		{
			const initClass = document.getElementsByClassName("ar-alert-bootbox")[0];
			const getDataURL = initClass.getAttribute("data-url")+index+'/'+menu_id;
			const getParentClass = initClass.parentNode;

			bootbox.confirm(
			{
				title: "<i class=\"fas fa-question-circle text-primary fa-fw mr-1\"></i> Confirmation Message",
				message: "Are you sure, do you want to delete this menu, this action cannot be undone if you click Confirm?",
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
								getData.splice(index, 1);

								document.querySelector("input[type='submit']").click();

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
		ucFirst: function(string)
		{
			string = string.toLowerCase().replace(/\b[a-z]/g, function(letter) 
			{
				return letter.toUpperCase();
			});

			return string;
		},
		strToLowerCase: function(string)
		{
			string = string.toLowerCase().replace(/\s/g, "");

			return string;
		}
	},
	created: function()
	{
		this.listData();
	}
});