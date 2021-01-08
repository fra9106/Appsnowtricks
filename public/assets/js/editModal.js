window.onload = () => {

    //on va chercher le trick et son prototype par son id
    const trickImages = document.querySelector('#trick_images');
    const trickVideos = document.querySelector('#trick_videos');

    const modalImage = () => { //on récupère dans une variable le bouton de fermeture, tous les form-group, toutes les images, et tt les wrapper (partie blanche contenant l'input file)
        const btn = '<button type="button" class="js-modal-close"><i class="fas fa-times"></i></button>';
        const formGroup = trickImages.querySelectorAll('.form-group');
        const modalElem = document.querySelectorAll('.js-modal-image');
        const modalWrapper = trickImages.querySelectorAll('.modal-none');

        for (let i = 0; i < formGroup.length; i++) {// on boucle sur tt les form-group pour générer la modale en dynamique en settant tous les attributs classique d'une modal)
            formGroup[i].classList.add('modal');
            formGroup[i].setAttribute("id", "modal-image-" + i);
            formGroup[i].setAttribute("role", "dialog");
            formGroup[i].setAttribute("aria-modal", "false");
            formGroup[i].setAttribute("aria-hidden", "true");
        }
        for (let i = 0; i < modalWrapper.length; i++) {// même chose pour placer le bouton close dans la partie wrapper et on stop la propagation pour ne pas fermer le wrapper lors du click dedans
            modalWrapper[i].insertAdjacentHTML('afterbegin', btn);
            modalWrapper[i].className = 'modal-wrapper js-modal-stop-propagation';
        }
        for (let i = 0; i < modalElem.length; i++) {// ici on boucle sur ttes les images, pour setter le href et l'image en question
            modalElem[i].setAttribute("href", "#modal-image-" + i);
        }
    }
    const modalVideo = () => {//idem que pour l'image
        const btn = '<button type="button" class="js-modal-close"><i class="fas fa-times"></i></button>';
        const formGroup = trickVideos.querySelectorAll('.form-group');
        const modalElem = document.querySelectorAll('.js-modal-video');
        const modalWrapper = trickVideos.querySelectorAll('.modal-none');

        for (let i = 0; i < formGroup.length; i++) {
            formGroup[i].classList.add('modal');
            formGroup[i].setAttribute("id", "modal-video-" + i);
            formGroup[i].setAttribute("role", "dialog");
            formGroup[i].setAttribute("aria-modal", "false");
            formGroup[i].setAttribute("aria-hidden", "true");
        }
        for (let i = 0; i < modalWrapper.length; i++) {
            modalWrapper[i].insertAdjacentHTML('afterbegin', btn);
            modalWrapper[i].className = 'modal-wrapper js-modal-stop-propagation';
        }
        for (let i = 0; i < modalElem.length; i++) {
            modalElem[i].setAttribute("href", "#modal-video-" + i);
        }

    }
    modalImage();
    modalVideo();

    let modal = null;// variable qui permetra de savoir quelle modal est ouverte
    const openModal = (e) => {
        e.preventDefault()
        const target = document.querySelector(e.target.getAttribute("href")); //on récupère le href pour sélectionner l'élément
        target.querySelector('.fas.fa-trash-alt').style.display = "none";// on cache le bouton du block _trick_images_entry_widget
        target.style.display = "block";// on passe la modal de none à block (visible)
        target.removeAttribute("aria-hidden");//on remove le aria-hidden qui est passé en visible
        target.setAttribute("aria-modal", "true");//on passe le aria-modal de false à true (accessiblité liseuses etc...)
        modal = target;//on stocke dans la variable modal la modal cible (pour mettre en place la fermeture)
        modal.addEventListener('click', closeModal);// on écoute le click pour appeler la fonction closeModal
        modal.querySelector('.js-modal-close').addEventListener('click', closeModal);//click sur le X de fermeture, appel closeModal aussi
        modal.querySelector('.js-modal-stop-propagation').addEventListener('click', stopPropagation);
        //on stop la propagation de l'évenement vers les parents évitant ainsi de ne pas fermer le wrapper lors du click dedans
    }
    const closeModal = (e) => {// pour fermer, on inverse tout ce qu'on a fait pour ouvrir la modale
        if (modal === null) {
            return;
        }
        e.preventDefault()
        window.setTimeout(function () {
            modal.style.display = "none"
            modal = null;
        }, 500)
        modal.setAttribute("aria-hidden", "true");
        modal.removeAttribute("aria-modal");
        modal.removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);//à la fermeture de la modal, on supprime l'écouteur
        modal.querySelector('.js-modal-stop-propagation').removeEventListener('click', stopPropagation);//idem

    }
    const stopPropagation = (e) => {
        e.stopPropagation();
    }
    document.querySelectorAll('.js-modal-image').forEach(a => {// je récupère ttes les images et leurs liens et au click on ouvre une modal
        a.addEventListener('click', openModal);
    })
    document.querySelectorAll('.js-modal-video').forEach(a => {
        a.addEventListener('click', openModal);
    })

    //Fermeture modal clavier

    window.addEventListener('keydown', (e) => {
        if (e.key === "Escape" || e.key === "Esc") {
            closeModal(e);
        }
    })
};
