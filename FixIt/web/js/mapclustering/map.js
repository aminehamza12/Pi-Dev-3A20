"use strict";
function sp_init_map_script(_map_id,data){
	var directory_path = '';
	var _data_list		 = data;
	var dir_latitude	 = '33.8869';
	var dir_longitude	 = '9.5375';
	var dir_map_type	 = 'ROADMAP';
	var dir_close_marker		= directory_path+'images/icons/close.png';
	var dir_cluster_marker		= directory_path+'images/icons/cluster.png';
	var dir_map_marker			= directory_path+'images/icons/marker.png';
	var dir_cluster_color		= '#000';
	var dir_zoom				= '12';
	var dir_map_scroll			= 'false';
	var gmap_norecod			= '';
	var loader_html	= '<div class="provider-loader-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

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
