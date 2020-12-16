(function () {
// Modale
    const trickImages = document.getElementById('trick_images');
    const trickVideos = document.getElementById('trick_videos');

    const modalImage = () => {
        const btn = '<button type="button" class="js-modal-close"><i class="fas fa-times"></i></button>';
        const formGroup = trickImages.querySelectorAll('.form-group');
        const modalElem = document.querySelectorAll('.js-modal-image');
        const modalWrapper = trickImages.querySelectorAll('.modal-none');

        for (let i = 0; i < formGroup.length; i++) {
            formGroup[i].classList.add('modal');
            formGroup[i].setAttribute("id", "modal-image-" + i);
            formGroup[i].setAttribute("role", "dialog");
            formGroup[i].setAttribute("aria-modal", "false");
            formGroup[i].setAttribute("aria-hidden", "true");
        }
        for (let i = 0; i < modalWrapper.length; i++) {
            modalWrapper[i].insertAdjacentHTML('afterbegin', btn);
            modalWrapper[i].className = 'modal-wrapper js-modal-stop';
        }
        for (let i = 0; i < modalElem.length; i++) {
            modalElem[i].setAttribute("href", "#modal-image-" + i);
        }
    }
    const modalVideo = () => {
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
            modalWrapper[i].className = 'modal-wrapper js-modal-stop';
        }
        for (let i = 0; i < modalElem.length; i++) {
            modalElem[i].setAttribute("href", "#modal-video-" + i);
        }

    }
    modalImage();
    modalVideo();

    let modal = null;
    const openModal = (e) => {
        e.preventDefault()
        let target = document.querySelector(e.target.getAttribute("href"));
        target.querySelector('.fas.fa-trash-alt').style.display = "none";
        target.style.display = "block";
        target.removeAttribute("aria-hidden");
        target.setAttribute("aria-modal", "true");
        modal = target;
        modal.addEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
    }
    const closeModal = (e) => {
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
        modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
       
    }
    const stopPropagation = (e) => {
        e.stopPropagation();
    }
    document.querySelectorAll('.js-modal-image').forEach(a => {
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

    //suppression mini-image
    const btnDeleteImage = document.querySelectorAll('.btn-delete-image.fas.fa-trash-alt');
    for (let i = 0; i < btnDeleteImage.length; i++) {
        btnDeleteImage[i].setAttribute("href", "#modal-image-" + i);
        //console.log(btnDeleteImage);
    }

    btnDeleteImage.forEach((element) => {
        element.addEventListener('click', function (e) {
            let target = document.querySelector(e.target.getAttribute("href"));
            console.log(target);
            e.preventDefault();
            if (confirm("Do you realy want to delete this picture ?!!")) {
                target.remove();
                this.parentNode.parentNode.remove();
            } else {
                this.location.reload();
            }
        })
    })

    //suppression mini-videos
    const btnDeleteVideo = document.querySelectorAll('.btn-delete-video.fas.fa-trash-alt');
    for (let i = 0; i < btnDeleteVideo.length; i++) {
        btnDeleteVideo[i].setAttribute("href", "#modal-video-" + i);
    }

    btnDeleteVideo.forEach((element) => {
        element.addEventListener('click', function (e) {
            let target = document.querySelector(e.target.getAttribute("href"));
            e.preventDefault();
            if (confirm("Do you realy want to delete this video ?!!")) {
                target.remove();
                this.parentNode.parentNode.remove();
            } else {
                this.location.reload();
            }
        })
    })
})()
