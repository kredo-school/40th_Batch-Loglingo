window.initContactMap = function() {
    const location = { lat: 35.6604, lng: 139.7292 };
    const mapElement = document.getElementById("modal-map");
    
    if (mapElement) {
        const map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: location,
            disableDefaultUI: true,
            zoomControl: true,
        });

        new google.maps.Marker({
            position: location,
            map: map,
            title: "LogLingo HQ",
            animation: google.maps.Animation.DROP
        });
    }
};