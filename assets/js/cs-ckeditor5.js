const checked = false;

ClassicEditor
.create(document.querySelector("#editor"), 
{
	toolbar: 
	{
		items: [
			"heading",
			"|",
			"bold",
			"italic",
			"link",
			"bulletedList",
			"numberedList",
			"TodoList",
			"|",
			"indent",
			"outdent",
			"alignment",
			"|",
			"CKFinder",
			"imageUpload",
			"blockQuote",
			"insertTable",
			"mediaEmbed",
			"undo",
			"redo",
			"removeFormat",
			"underline",
			"fontSize",
			"fontFamily",
			"highlight",
			"code",
			"codeBlock",
			"exportPdf",
			"WordCount"
		]
	},
	language: "en",
	image: 
	{
		toolbar: [
			"imageTextAlternative",
			"imageStyle:full",
			"imageStyle:side"
		]
	},
	table: 
	{
		contentToolbar: [
			"tableColumn",
			"tableRow",
			"mergeTableCells"
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