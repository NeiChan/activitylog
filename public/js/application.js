$(function() {
    dropDownSelector('.selector-dropdown-datatypes', '#deselectAll-datatypes');
    dropDownSelector('.selector-dropdown-companies', '#deselectAll-companies');
});

function initMap() {
    var getLat = document.getElementById('lat');
    var getLong = document.getElementById('long');

    var myLatLng = { lat: parseFloat(getLat.value), lng: parseFloat(getLong.value) };
    if(getLat.value != "" && getLong.value != ""){
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 13
        });
    }else{
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.9244200, lng: 4.4777330},
            zoom: 13
        });
    }

    var input = /** @type {!HTMLInputElement} */(
        document.getElementById('pac-input'));

    var types = document.getElementById('type-selector');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

    var options = {
        componentRestrictions: {country: "nl"}
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    if(getLat.value != "" && getLong.value != "") {
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });
    }else{
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
    }

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
            codeAddress();
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });
}

// This is sooo important. Never forget.
function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var address = document.getElementById("pac-input").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //console.log("Latitude: "+results[0].geometry.location.lat());
            //console.log("Longitude: "+results[0].geometry.location.lng());

            // Places the lat and long coordination temporarily in two hidden input fields.
            document.getElementById("lat").value = results[0].geometry.location.lat();
            document.getElementById("long").value = results[0].geometry.location.lng();
        }

        else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}

function dropDownSelector(el, reset)
{
    $(el).multiselect();

    $(reset).on('click', function(e) {
        $(el).multiselect('deselectAll', false);
        $(el).multiselect('updateButtonText');
        e.preventDefault();
    });
}
function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var profile = googleUser.getBasicProfile();

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url + '/google/Login');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        //console.log('Signed in as: ' + xhr.responseText);
        location.reload();
    };
    xhr.send('id=' + profile.getId() + '&' + 'email=' + profile.getEmail());
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });

    $.ajax({
            method: "POST",
            url: url + '/google/SignOut',
        })
        .done(function (msg) {
            location.reload();
        });
}