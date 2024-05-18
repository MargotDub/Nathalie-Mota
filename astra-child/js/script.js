// OUVERTURE MODALE AVEC LE LIEN ET LE BOUTON //
document.addEventListener("DOMContentLoaded", function() {
    let myModal = document.querySelector('.modal');
    let myOverlay = document.querySelector('.overlay');
    let contactLink = Array.from(document.querySelectorAll('.contact'));
    let contactLinkButton = document.querySelector('.contact-button');

    // Ouvrir et fermer la modale lorsque le lien "Contact" est cliqué
    contactLink.forEach(el => {
        el.onclick = function(event) {
            event.preventDefault();
            myModal.classList.add('modal--open');
            myOverlay.style.display = "block";
        }    
    })

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

    if (previousLink) {
        previousLink.addEventListener("mouseover", function() {
            previousPhoto.classList.add("visible");
            nextPhoto.classList.remove("visible");
        });

    // Ajouter des écouteurs d'événements pour gérer le mouseout
        previousLink.addEventListener("mouseout", function() {
        previousPhoto.classList.remove("visible");
    });
}
    if (nextLink) {
        nextLink.addEventListener("mouseover", function() {
            nextPhoto.classList.add("visible");
            previousPhoto.classList.remove("visible");
        });

        nextLink.addEventListener("mouseout", function() {
            nextPhoto.classList.remove("visible");
        });
    }
});

// LIGHTBOX //
class Lightbox {
    constructor(images, currentIndex) {
        this.images = images;
        this.currentIndex = currentIndex;
        this.element = this.buildDOM();
        this.loadImage(this.images[this.currentIndex]);
        document.body.appendChild(this.element);

        const closeButton = this.element.querySelector('.lightbox__close');
        closeButton.addEventListener('click', () => this.close());

        const nextButton = this.element.querySelector('.lightbox__next');
        nextButton.addEventListener('click', () => this.next());

        const prevButton = this.element.querySelector('.lightbox__prev');
        prevButton.addEventListener('click', () => this.prev());
    }

    loadImage(imageData) {
        const { url, reference, category } = imageData;
        const image = new Image();
        const container = this.element.querySelector('.lightbox__container');
        container.innerHTML = ''; 
        const loader = document.createElement('div');
        loader.classList.add('lightbox__loader');
        container.appendChild(loader);
        image.onload = function () {
            container.removeChild(loader);
            container.appendChild(image);
        };
        image.src = url;

        // Mettre à jour les informations de la lightbox
        this.element.querySelector('.reference_lightbox-info').textContent = reference;
        this.element.querySelector('.categorie_lightbox-info').textContent = category;
    }

    buildDOM() {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `
            <button class="lightbox__close">Fermer</button>
            <button class="lightbox__next">Suivant</button>
            <button class="lightbox__prev">Précédent</button>
            <div class="lightbox__container"></div>
            <div class="lightbox__info">
                <p class="reference_lightbox-info"></p>
                <p class="categorie_lightbox-info"></p>
            </div>`;
        return dom;
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.loadImage(this.images[this.currentIndex]);
    }

    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        this.loadImage(this.images[this.currentIndex]);
    }

    close() {
        document.body.removeChild(this.element);
    }

    static init() {
        const photoContainer = document.querySelector('.flexbox-layout');
        if (photoContainer) {
            photoContainer.addEventListener('click', (event) => {
                if (event.target.classList.contains('fullscreen-button')) {
                    const images = Array.from(document.querySelectorAll('.fullscreen-button')).map(btn => ({
                        url: btn.getAttribute('data-image-url'),
                        reference: btn.getAttribute('data-reference'),
                        category: btn.getAttribute('data-category')
                    }));
                    const currentIndex = images.findIndex(image => image.url === event.target.getAttribute('data-image-url'));
                    new Lightbox(images, currentIndex);
                }
            });
        }
    }
}

Lightbox.init();

// Fonction pour charger les photos via AJAX en fonction des filtres sélectionnés et de la pagination
jQuery(document).ready(function($) {
    function loadPhotos(page = 1) {
        let categories = $('#categories').val();
        let formats = $('#formats').val();
        let trierPar = $('#trier-par').val();

        $.ajax({
            url: my_ajax_vars.ajaxurl,
            type: 'post',
            data: {
                action: 'load_more_photos',
                categories: categories,
                formats: formats,
                trierPar: trierPar,
                page: page
            },
            success: function(response) {
                if (page === 1) {
                    $('.flexbox-layout').html(response);
                } else {
                    $('.flexbox-layout').append(response);
                }
                if (response === 'fin') {
                    $('.load-more-button').hide();
                } else {
                    initializeEyeButtons();
                }
            }
        });
    }

    $('#categories, #formats, #trier-par').on('change', function() {
        loadPhotos();
    });

    // Initialise la class eye-button
    function initializeEyeButtons() {
        const eyeButtons = document.querySelectorAll('.eye-button');

        eyeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const postUrl = button.getAttribute('data-post-url');
                window.location.href = postUrl;
            });
        });
    }

    // Gestion de l'événement de clic sur le bouton "Charger plus" pour charger plus de photos via AJAX
    let page = 2;
    let loading = false;

    $('.load-more-button').on('click', function() {
        if (!loading) {
            loading = true;
            let categories = $('#categories').val();
            let formats = $('#formats').val();
            let trierPar = $('#trier-par').val();

            $.ajax({
                url: my_ajax_vars.ajaxurl,
                type: 'post',
                data: {
                    action: 'load_more_photos',
                    page: page,
                    categories: categories,
                    formats: formats,
                    trierPar: trierPar
                },
                success: function(response) {
                    if (response !== 'fin') {
                        $('.flexbox-layout').append(response);
                        page++;
                        initializeEyeButtons();
                    } else {
                        $('.load-more-button').hide();
                    }
                    loading = false;
                }
            });
        }
    });
    
    initializeEyeButtons();
});
