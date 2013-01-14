jQuery(window).load(function(){

    gmap_init(lat, lng);

});


var options = {
    'zoom': 12,        
    'mapTypeId': google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    sensor: 'false'
};


function gmap_init(lat, lng)
{
    var map = new google.maps.Map(document.getElementById("gmap"), options);

    var image = new google.maps.MarkerImage(gmap_point,
          new google.maps.Size(35,53),
          new google.maps.Point(0,0),
          new google.maps.Point(16,52));

    var latLng = new google.maps.LatLng(lat, lng);

    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: image
//        text: point.text
    });

    map.setCenter(latLng, 13);
}