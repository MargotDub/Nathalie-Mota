document.addEventListener("DOMContentLoaded", function() {
    var myModal = document.querySelector('.modal');
    var myOverlay = document.querySelector('.overlay');
    var contactLink = document.getElementById('contact');

    // Ouvrir la modale lorsque le lien "Contact" est cliqué
    contactLink.onclick = function(event) {
        event.preventDefault();
        myModal.classList.add('modal--open');
        myOverlay.style.display = "block";
    }

    // Fermer la modale lorsque l'overlay est cliqué
    myOverlay.onclick = function() {
        closeModal();
    }

    // Fonction pour fermer la modale
    function closeModal() {
        myModal.classList.remove('modal--open');
        myOverlay.style.display = "none";
    }
});