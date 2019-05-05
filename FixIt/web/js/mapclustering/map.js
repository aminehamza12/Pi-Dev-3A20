"use strict";
<<<<<<< HEAD
function sp_init_map_script(_map_id,data){
	var directory_path = '';
	var _data_list		 = data;
	var dir_latitude	 = '33.8869';
	var dir_longitude	 = '9.5375';
=======
function sp_init_map_script(_map_id){
	var directory_path = '';
	var _data_list		 = data;
	var dir_latitude	 = '51.5001524';
	var dir_longitude	 = '-0.1262362';
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
	var dir_map_type	 = 'ROADMAP';
	var dir_close_marker		= directory_path+'images/icons/close.png';
	var dir_cluster_marker		= directory_path+'images/icons/cluster.png';
	var dir_map_marker			= directory_path+'images/icons/marker.png';
	var dir_cluster_color		= '#000';
	var dir_zoom				= '12';
	var dir_map_scroll			= 'false';
	var gmap_norecod			= '';
	var loader_html	= '<div class="provider-loader-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

<<<<<<< HEAD
	console.log(data);
	var lat=data.lat;
	var long=data.long;
	var lentgh=data.lat.length;

    var scrollwheel	= true;
    var lock			 = 'unlock';

    if( dir_map_scroll == 'false' ){
        scrollwheel	= false;
        lock			 = 'lock';
    }
    var myLatlng=new google.maps.LatLng(lat[1],long[1]);

    var mapOptions = {
        zoom: parseInt(dir_zoom),
        maxZoom: 20,
        scaleControl: true,
        center: myLatlng,
        scrollwheel: scrollwheel,
        disableDefaultUI: true
    };
    var bounds = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById(_map_id), mapOptions);



=======
	if( _data_list.status == 'found' ){
		var response_data	= _data_list.listing;
		var location_center = new google.maps.LatLng(response_data[0].latitude,response_data[0].longitude);
	} else{
		var location_center = new google.maps.LatLng(dir_latitude,dir_longitude);
	}

	if(dir_map_type == 'ROADMAP'){
		var map_id = google.maps.MapTypeId.ROADMAP;
	} else if(dir_map_type == 'SATELLITE'){
		var map_id = google.maps.MapTypeId.SATELLITE;
	} else if(dir_map_type == 'HYBRID'){
		var map_id = google.maps.MapTypeId.HYBRID;
	} else if(dir_map_type == 'TERRAIN'){
		var map_id = google.maps.MapTypeId.TERRAIN;
	} else {
		var map_id = google.maps.MapTypeId.ROADMAP;
	}

	var scrollwheel	= true;
	var lock			 = 'unlock';

	if( dir_map_scroll == 'false' ){
		scrollwheel	= false;
		lock			 = 'lock';
	}

	var mapOptions = {
		zoom: parseInt(dir_zoom),
		maxZoom: 20,
		mapTypeId: map_id,
		scaleControl: true,
		scrollwheel: scrollwheel,
		disableDefaultUI: true
	}

	var map = new google.maps.Map(document.getElementById(_map_id), mapOptions);
	var bounds = new google.maps.LatLngBounds();
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29

	//Zoom In
	if(document.getElementById('doc-mapplus') ){ 
		google.maps.event.addDomListener(document.getElementById('doc-mapplus'), 'click', function () {
			var current= parseInt( map.getZoom(),10 );
			current++;
			if(current>20){
				current=20;
			}
			map.setZoom(current);
		});
	}

	//Zoom Out
	if(document.getElementById('doc-mapminus') ){ 
		google.maps.event.addDomListener(document.getElementById('doc-mapminus'), 'click', function () {
			var current= parseInt( map.getZoom(),10);
			current--;
			if(current<0){
				current=0;
			}
			map.setZoom(current);
		});
	}

	//Lock Map
	if( document.getElementById('doc-lock') ){ 
		google.maps.event.addDomListener(document.getElementById('doc-lock'), 'click', function () {
			if(lock == 'lock'){
				map.setOptions({ 
						scrollwheel: true,
						draggable: true 
					}
				);
				jQuery("#doc-lock").html('<i class="fa fa-unlock-alt" aria-hidden="true"></i>');
				lock = 'unlock';
			}else if(lock == 'unlock'){
				map.setOptions({ 
						scrollwheel: false,
						draggable: false 
					}
				);
				jQuery("#doc-lock").html('<i class="fa fa-lock" aria-hidden="true"></i>');
				lock = 'lock';
			}
		});
	}

	//Map resize
	jQuery(document).on("click",'.tg-btnmapview', function(e){
        jQuery('.tg-mapinnerbanner').toggleClass('tg-open');
		if( jQuery('.tg-mapinnerbanner').hasClass('tg-open') ) {
<<<<<<< HEAD
            document.querySelector('div.tg-searchbox').style.display='none';
			//jQuery('.tg-mapinnerbanner').append(loader_html);
		}
		else
		{
            document.querySelector('div.tg-searchbox').style.display='block';
            jQuery('.tg-mapinnerbanner').find('.provider-loader-wrap').remove();
            google.maps.event.trigger(map,"resize");
		}
    });

	var i;

    for(i=0;i<lentgh;i++)
    {
        var myLatlng1=new google.maps.LatLng(lat[i],long[i]);
        var marker = new google.maps.Marker({
            position: myLatlng1,
            title:"Hello World!"
        });

// To add the marker to the map, call setMap();
        marker.setMap(map);

    }

	function getLatandLong(address) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var lat = results[0].geometry.location.lat();
                var long = results[0].geometry.location.lng();
                console.log(lat);
                console.log(long);
                var data={
                	lat:lat,
					long:long,
				};
                return data;
            }
        });
    }

}
=======
			jQuery('.tg-mapinnerbanner').append(loader_html);
		}
		setTimeout(function(){
			jQuery('.tg-mapinnerbanner').find('.provider-loader-wrap').remove();
			google.maps.event.trigger(map,"resize");
			map.setCenter(location_center);
		},1000);
    });
			
	if( _data_list.status == 'found' ){
		jQuery('#gmap-noresult').html('').hide(); //Hide No Result Div
		var markers = new Array();
		var info_windows = new Array();

		for (var i=0; i < response_data.length; i++) {
			markers[i] = new google.maps.Marker({
				position: new google.maps.LatLng(response_data[i].latitude,response_data[i].longitude),
				map: map,
				icon: response_data[i].marker,
				title: response_data[i].title,
				animation: google.maps.Animation.DROP,
				visible: true
			});
			bounds.extend(markers[i].getPosition());
			var boxText = document.createElement("div");
			boxText.className = 'tg-infoBox';
			
			var infobox_html = "";
			infobox_html += '<div class="tg-serviceprovider">';
			infobox_html += '<figure class="tg-featuredimg"><img src="'+response_data[i].image+'" alt="'+response_data[i].title+'"></figure>';
			infobox_html += '<div class="tg-companycontent">';
				if(response_data[i].featured == 'yes'){
					infobox_html += '<span class="tg-featured"><i class="fa fa-bolt"></i></span>';
				}
				/*if(response_data[i].featured == 'yes'){
					infobox_html += '<span class="tg-featured"><i class="fa fa-bolt"></i></span>';
				}*/
				//infobox_html += '<div class="tg-subjects">'+response_data[i].subjects+'</div>';
				infobox_html += '<ul class="tg-tags"><li><a class="tg-tag tg-featuredtag" href="#">featured</a></li><li><a class="tg-tag tg-verifiedtag" href="#">verified</a></li></ul>';
				infobox_html += '<div class="tg-title"><h3><a href="'+response_data[i].url+'">'+response_data[i].title+'</a></h3></div>';
				infobox_html += '<ul class="tg-matadata"><li><span class="tg-stars"><span></span></span></li><li><i class="fa fa-thumbs-o-up"></i><em>99% (1009 votes)</em></li></ul>';
			infobox_html += '</div>';
			boxText.innerHTML = infobox_html;
			
			var myOptions = {
				content: boxText,
				disableAutoPan: true,
				maxWidth: 0,
				alignBottom: true,
				pixelOffset: new google.maps.Size( -390, -70 ),
				zIndex: null,
				closeBoxMargin: "0 0 -16px -16px",
				closeBoxURL: dir_close_marker,
				infoBoxClearance: new google.maps.Size( 1, 1 ),
				isHidden: false,
				pane: "floatPane",
				enableEventPropagation: false
			};
			var ib = new InfoBox( myOptions );
			attachInfoBoxToMarker( map, markers[i], ib );
		}
		map.fitBounds(bounds);
		/* Marker Clusters */
		var markerClustererOptions = {
			ignoreHidden: true,
			//maxZoom: 14,
			styles: [{
				textColor: dir_cluster_color,
				url: dir_cluster_marker,
				width: 23,
				height: 30,
			}]
		};
		var markerClusterer = new MarkerClusterer( map, markers, markerClustererOptions );
	} else{
		map.fitBounds(bounds);
		jQuery('#gmap-noresult').html(gmap_norecod).show();
	}
}
//Assign Info window to marker
function attachInfoBoxToMarker( map, marker, infoBox ){
	google.maps.event.addListener( marker, 'click', function(){
		var scale = Math.pow( 2, map.getZoom() );
		var offsety = ( (100/scale) || 0 );
		var projection = map.getProjection();
		var markerPosition = marker.getPosition();
		var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
		var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
		var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
		map.setCenter( aboveMarkerLatLng );
		
		jQuery(".infoBox").hide();
		infoBox.open( map, marker );
		
	});
}
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
