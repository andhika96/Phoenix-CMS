let map;

function initMap() 
{
	const map = new google.maps.Map(document.getElementById("map"), 
	{
		zoom: 10,
		center: 
		{
			lat: -6.2362789, 
			lng: 106.8280339
		},
		mapTypeId: "roadmap",
	});

	setMarkers(map);

	searchPlaces(map);
}

function searchPlaces(map) 
{
	const inputSearch	= document.getElementById("search-dealer");
	const buttonSearch 	= document.getElementsByClassName("btn-search-dealer")[0];

	// Create the search box and link it to the UI element.
	const input = document.getElementById("search-dealer");
	const searchBox = new google.maps.places.SearchBox(input);

	// Disable auto set position in map by Andhika Adhitia N
	// map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	// Bias the SearchBox results towards current map's viewport.
	map.addListener("bounds_changed", () => 
	{
		searchBox.setBounds(map.getBounds());
	});

	let markers = [];

	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener("places_changed", () => 
	{
		// Empty
	});

	buttonSearch.onclick = function()
	{
		getSearchResult(map, searchBox, markers);
	};
}

const locations = 
[
	["MG MOTOR JAKARTA", -6.0900163, 106.7418265, 7],
	["Car Dealership MG Motors Jakarta", -6.1661012, 106.7603856, 6],
	["MG Motor Bekasi MIMOSA", -6.2629184, 107.060914, 5],
	["Kredit MG Jakarta | Sales Marketing", -6.236725, 106.7824168, 4],
	["MORRIS GARAGE JAKARTA", -6.2554782, 106.7795142, 3],
	["MG JAKARTA SELATAN", -6.240848, 106.7808625, 2],
	["MG Motor Pondok Indah (Andalan Motor)", -6.2408547, 106.7809563, 1],
];

function getSearchResult(map, searchBox, markers)
{
	let places = searchBox.getPlaces();

	setTimeout(function () { document.getElementById("search-dealer").focus() }, 100);

	if (places.length == 0) 
	{
		return;
	}

	// Clear out the old markers.
	markers.forEach((marker) => 
	{
		marker.setMap(null);
	});
	
	markers = [];

	// For each place, get the icon, name and location.
	const bounds = new google.maps.LatLngBounds();

	places.forEach((place) => 
	{
		if ( ! place.geometry || ! place.geometry.location) 
		{
			console.log("Returned place contains no geometry");
			return;
		}

		// Create a marker for each place.
		markers.push(
			new google.maps.Marker(
			{
				map,
				title: place.name,
				position: place.geometry.location,
			})
		);
		
		if (place.geometry.viewport) 
		{
			// Only geocodes have viewport.
			bounds.union(place.geometry.viewport);
		} 
		else 
		{
			bounds.extend(place.geometry.location);
		}
	});

	map.fitBounds(bounds);
}

function setMarkers(map) 
{
	for (let i = 0; i < locations.length; i++) 
	{
		const location = locations[i];

		new google.maps.Marker(
		{
			position: { lat: location[1], lng: location[2] },
			map,
			title: location[0],
			zIndex: location[3],
		});
	}
}

window.initMap = initMap;