window.onload = function () {
    console.log("page loaded")
    document.getElementById('lcj').parentElement.style.display = 'none';
    document.getElementById('particulier').addEventListener('click', function () {
        document.getElementById('lcj').parentElement.style.display = 'none';
        document.getElementById('lcj').required = false;
    });
    document.getElementById('validator').addEventListener('click', function () {
        document.getElementById('lcj').parentElement.style.display = 'block';
        document.getElementById('lcj').required = true;
    });
}