if (document.querySelector("#arv5-mobile-menu-open") !== null)
{	
	document.getElementById("arv5-mobile-menu-open").onclick = function() 
	{
		document.getElementsByClassName("arv5-sidebar-container")[0].style.marginLeft = '0';
		document.getElementsByClassName("arv5-overlay")[0].style.zIndex = '100';
		document.getElementsByClassName("arv5-overlay")[0].style.opacity = '1';
		document.getElementsByTagName("body")[0].style.overflowY = 'hidden';
	};
}

if (document.querySelector("#arv5-mobile-menu-close") !== null)
{
	document.getElementById("arv5-mobile-menu-close").onclick = function() 
	{
		if (document.getElementsByClassName("arv5-sidebar-container")[0].hasAttribute("style"))
		{
			document.getElementsByTagName("body")[0].removeAttribute("style");
			document.getElementsByClassName("arv5-sidebar-container")[0].removeAttribute("style");
			document.getElementsByClassName("arv5-overlay")[0].style.opacity = '0';

			setTimeout(function()
			{
				document.getElementsByClassName("arv5-overlay")[0].style.zIndex = '0';
			}, 9.5);
		}
	};
}

if (document.querySelector(".arv5-overlay") !== null)
{
	document.getElementsByClassName("arv5-overlay")[0].onclick = function() 
	{
		if (document.getElementsByClassName("arv5-sidebar-container")[0].hasAttribute("style"))
		{
			document.getElementsByTagName("body")[0].removeAttribute("style");
			document.getElementsByClassName("arv5-sidebar-container")[0].removeAttribute("style");
			document.getElementsByClassName("arv5-overlay")[0].style.opacity = '0';

			setTimeout(function()
			{
				document.getElementsByClassName("arv5-overlay")[0].style.zIndex = '0';
			}, 9.5);
		}
	};
}

const getFormCheckDate = document.querySelectorAll('.form-check-input-date');

for (let i = 0; i < getFormCheckDate.length; i++) 
{
	document.getElementsByClassName("form-check-input-date")[i].onclick = function() 
	{
		if (document.getElementsByClassName("form-check-input-date")[i].checked == true)
		{
			document.getElementsByClassName("form-input-start-date")[i].value = '';
			document.getElementsByClassName("form-input-start-date")[i].setAttribute("disabled", "disabled");
	
			document.getElementsByClassName("form-input-end-date")[i].value = '';
			document.getElementsByClassName("form-input-end-date")[i].setAttribute("disabled", "disabled");
		}
		else if (document.getElementsByClassName("form-check-input-date")[i].checked == false)
		{
			document.getElementsByClassName("form-input-start-date")[i].removeAttribute("disabled");
			document.getElementsByClassName("form-input-end-date")[i].removeAttribute("disabled");
		}
	}
}

$(document).ready(function() 
{
	// $(function() 
	// {
	// 	$('[data-toggle="tooltip"]').tooltip();
	// });

	$('.custom-file-input').change(function(e) 
	{
		let parent = $(this).parents(".custom-file");
		let fileName = e.target.files[0].name;

		parent.find(".custom-file-label").html(fileName);
	});

	$(".ps-y").each(function() 
	{
		const ps = new PerfectScrollbar($(this)[0], 
		{
			useBothWheelAxes: false,
			suppressScrollX: true
		});
	});

	// Listen for click on toggle checkbox
	$("#selectAll").click(function(event) 
	{
		if (this.checked) 
		{
			// Iterate each checkbox
			$(".checkids").each(function() 
			{
				this.checked = true;                        
			});
		} 
		else 
		{
			$(".checkids").each(function() 
			{
				this.checked = false;                       
			});
		}
	});

	$("input.form-control").bind("focus blur", function () 
	{
		$(this).parent(".form-group-no-border").toggleClass("input-group-focus");
		$(this).parent(".input-group-signup").toggleClass("input-group-focus");
	});
});

/*
const InputFormControl = document.querySelectorAll(".form-control");

for (i = 0; i < InputFormControl.length; i++)
{
	InputFormControl[i].addEventListener("focus", myFocusFunction, true);
	InputFormControl[i].addEventListener("blur", myBlurFunction, true);	
}

function myFocusFunction() 
{
	const IGT = document.querySelectorAll(".input-group-signup");

	for (i = 0; i < IGT.length; i++)
	{
		IGT[i].classList.add("input-group-focus");
		// IGT[i].classList.toggle("input-group-focus");
	}
}

function myBlurFunction() 
{
	const IGT = document.querySelectorAll(".input-group-signup");

	for (i = 0; i < IGT.length; i++)
	{
		IGT[i].classList.remove("input-group-focus");
		// IGT[i].classList.toggle("input-group-focus");
	} 
}
*/