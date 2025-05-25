function toggleInfo(carId) {
    var infoBox = document.getElementById(carId);
    infoBox.style.display = (infoBox.style.display === 'none' || infoBox.style.display === '') ? 'block' : 'none';
}
