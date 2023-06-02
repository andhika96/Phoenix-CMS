const checked = false;

ClassicEditor
.create(document.querySelector("#editor"), 
{
	toolbar: 
	{
		items: [
			'heading',
			'|',
			'bold',
			'italic',
			'link',
			'bulletedList',
			'numberedList',
			'todoList',
			'|',
			'outdent',
			'indent',
			'alignment',
			'undo',
			'redo',
			'|',
			'CKFinder',
			'imageUpload',
			'imageInsert',
			'blockQuote',
			'insertTable',
			'mediaEmbed',
			'removeFormat',
			'underline',
			'fontFamily',
			'fontSize',
			'fontColor',
			'fontBackgroundColor',
			'highlight',
			'code',
			'codeBlock',
			'sourceEditing',
			'selectAll'
		]
	},
	language: 'en',
	image: {
		styles: [ 'alignCenter', 'alignLeft', 'alignRight' ],
		resizeOptions: [
			{
				name: 'resizeImage:original',
				label: 'Default image width',
				value: null
			},
			{
				name: 'resizeImage:25',
				label: '25% page width',
				value: '25'
			},
			{
				name: 'resizeImage:50',
				label: '50% page width',
				value: '50'
			},
			{
				name: 'resizeImage:75',
				label: '75% page width',
				value: '75'
			}
		],
		toolbar: [
			'imageTextAlternative', 'toggleImageCaption',
			'|',
			'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', 'imageStyle:side',
			'|',
			'resizeImage',
			'linkImage'
		]
	},
	table: {
		contentToolbar: [
			'tableColumn',
			'tableRow',
			'mergeTableCells',
			'tableCellProperties',
			'tableProperties'
		]
	},
	ckfinder: 
	{
		openerMethod: "modal",
		uploadUrl: baseurl+"assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json"
	},
	wordCount:
	{
		displayWords: false
	},
	licenseKey: "",
})
.then(editor => 
{
	window.editor = editor;

	editor.model.document.on("change:data", () => 
	{
		document.querySelector("#editor").value = editor.getData();
	});

	const wordCountPlugin = editor.plugins.get("WordCount");
	const wordCountWrapper = document.getElementById("word-count");
	wordCountWrapper.appendChild(wordCountPlugin.wordCountContainer);
})
.catch(error => 
{
	console.error("Oops, something gone wrong!");
	console.error("Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:" );
	console.warn("Build id: fobzdd17kl4w-7k0k8zs0bnk4");
	console.error(error);
});

$(".ar-schedule-pub").daterangepicker(
{
	singleDatePicker: true,
	timePicker: true,
	timePicker24Hour: true,
	autoUpdateInput: true,
	startDate: moment().format("MM/DD/YYYY HH:mm"),
	locale:
	{
		format: "MM/DD/YYYY HH:mm"
	}
},
function(ev, picker)
{
	$(this).val(picker.format("MM/DD/YYYY HH:mm:00"));	
});

$(".ar-event-date").daterangepicker(
{
	singleDatePicker: true,
	timePicker: true,
	timePicker24Hour: true,
	autoUpdateInput: true,
	startDate: moment().format("MM/DD/YYYY HH:mm"),
	locale:
	{
		format: "MM/DD/YYYY HH:mm"
	}
},
function(ev, picker)
{
	$(this).val(picker.format("MM/DD/YYYY HH:mm:00"));	
});