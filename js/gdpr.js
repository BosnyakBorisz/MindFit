if (localStorage.getItem('privacy-accepted') === 'true') {
    document.getElementById('privacy-popup').style.display = 'none';
}

document.getElementById('accept-privacy').addEventListener('click', function() {
    localStorage.setItem('privacy-accepted', 'true');
    document.getElementById('privacy-popup').style.display = 'none';
});