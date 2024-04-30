//REQUETE AJAX CHARGER //
jQuery(function($) {
    let page = -1;
    let loading = false;
    let $loadmoreButton = $('.load-more-button');
    
    $loadmoreButton.on('click', function(){
        console.log("Bouton 'charger plus' cliqué!");
        if( ! loading ) {
            loading = true;
            let data = {
                'action': 'load_more_photos',
                'page': page,
            };

            $.ajax({
                url: ajax_params.ajaxurl,
                type: 'POST',
                data: data,
                success: function(response){
                    console.log(response)
                    if(response) {
                        $('.photo-container').append(response);
                        page++;
                    } else {
                        $loadmoreButton.remove();
                    }
                    loading = false;
                }
            });
        }
    });
});

// OUVERTURE MODALE AVEC LE LIEN ET LE BOUTON //
document.addEventListener("DOMContentLoaded", function() {
    let myModal = document.querySelector('.modal');
    let myOverlay = document.querySelector('.overlay');
    let contactLink = document.querySelector('.contact');
    let contactLinkButton = document.querySelector('.contact-button');

    // Ouvrir et fermer la modale lorsque le lien "Contact" est cliqué
    contactLink.onclick = function(event) {
        event.preventDefault();
        myModal.classList.add('modal--open');
        myOverlay.style.display = "block";
    }

    // Ouvrir et fermer la modale lorsque le bouton "Contact" est cliqué
    if (contactLinkButton) {
        contactLinkButton.onclick = function(event) {
            event.preventDefault();
            myModal.classList.add('modal--open');
            myOverlay.style.display = "block";
        }
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


// SINGLE PAGE VIGNETTE AU SURVOL DES FLECHES //
document.addEventListener("DOMContentLoaded", function() {
    const previousLink = document.querySelector(".previous-post-link a");
    const nextLink = document.querySelector(".next-post-link a");
    const previousPhoto = document.querySelector(".previous-photo");
    const nextPhoto = document.querySelector(".next-photo");

    previousLink.addEventListener("mouseover", function() {
        previousPhoto.classList.add("visible");
        nextPhoto.classList.remove("visible");
    });

    nextLink.addEventListener("mouseover", function() {
        nextPhoto.classList.add("visible");
        previousPhoto.classList.remove("visible");
    });

    // Ajouter des écouteurs d'événements pour gérer le mouseout
    previousLink.addEventListener("mouseout", function() {
        previousPhoto.classList.remove("visible");
    });

    nextLink.addEventListener("mouseout", function() {
        nextPhoto.classList.remove("visible");
    });
});
