
// on attent que la page soit chargé
window.onload = function () {
    // le champ pour ajouter la license de juge du représentant est caché par défaut
    document.getElementById('lcj').parentElement.style.display = 'none';
    // quand on clique sur le bouton radio des particulier la licence de juge est caché et non requis
    document.getElementById('particulier').addEventListener('click', function () {
        document.getElementById('lcj').parentElement.style.display = 'none';
        document.getElementById('lcj').required = false;
    });
    // quand on clique sur le bouton radio des représentant la licence de juge est visible et non obligatoire
    document.getElementById('validator').addEventListener('click', function () {
        document.getElementById('lcj').parentElement.style.display = 'block';
        document.getElementById('lcj').required = true;
    });
}