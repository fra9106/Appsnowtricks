(function () {

    //partie ajout / suppression des champs add images et add videos
        const trickImages = document.getElementById('trick_images');
        const trickVideos = document.getElementById('trick_videos');
    
        let indexImages = trickImages.querySelectorAll('.form-group').length;
        let indexVideos = trickVideos.querySelectorAll('.form-group').length;
        
        if (indexImages == 0) {
            addImageField(trickImages);
        }
        if (indexVideos == 0) {
            addVideoField(trickVideos);
        }
    
        document.querySelector('.btn-add-images').addEventListener('click', function (e) {
                e.preventDefault();
                addImageField(trickImages);
            })
    
        function addImageField(trickImages) {
        const protoImage = trickImages.getAttribute('data-prototype');
        const tplImage = protoImage.replace(/__name__/g, indexImages);
        trickImages.insertAdjacentHTML('beforeend', tplImage);
        indexImages++;
        handleDeleteButtons();
    }
    
        document.querySelector('.btn-add-videos').addEventListener('click', (e) => {
            e.preventDefault();
            addVideoField(trickVideos);
        })
    
        function addVideoField(trickVideos) {
        const protoVideo = trickVideos.getAttribute('data-prototype');
        const tplVideo = protoVideo.replace(/__name__/g, indexVideos);
        trickVideos.insertAdjacentHTML('beforeend', tplVideo);
        indexVideos++;
        handleDeleteButtons();
    }
    
        function handleDeleteButtons() {
        document.querySelectorAll('button.btn-delete-image.btn.btn-danger.fas.fa-trash-alt').forEach((elem) => {
            elem.addEventListener('click', function (e) {
                e.preventDefault();
                this.parentNode.parentNode.remove();
            });
        });
        document.querySelectorAll('button.btn-delete-video.btn.btn-danger.fas.fa-trash-alt').forEach((elem) => {
            elem.addEventListener('click', function (e) {
                e.preventDefault();
                this.parentNode.parentNode.remove();
            });
        });
    }
    
    // Partie modale
        const modalImage = () => {
            const btn = '<button type="button" class="js-modal-close">X</button>';
            const formRow = trickImages.querySelectorAll('.form-group');
            const modalElem = document.querySelectorAll('.js-modal-image');
            const modalWrapper = trickImages.querySelectorAll('.modal-none');
           
            for (let i = 0; i < formRow.length; i++) {
                formRow[i].classList.add('modal');
                formRow[i].setAttribute("id", "modal-image-" + i);
                formRow[i].setAttribute("aria-hidden", "true");
                formRow[i].setAttribute("role", "dialog");
                formRow[i].setAttribute("aria-modal", "false");
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
            const btn = '<button type="button" class="js-modal-close">X</button>';
            const formRow = trickVideos.querySelectorAll('.form-group');
            const modalElem = document.querySelectorAll('.js-modal-video');
            const modalWrapper = trickVideos.querySelectorAll('.modal-none');
    
            for (let i = 0; i < formRow.length; i++) {
                formRow[i].classList.add('modal');
                formRow[i].setAttribute("id", "modal-video-" + i);
                formRow[i].setAttribute("aria-hidden", "true");
                formRow[i].setAttribute("role", "dialog");
                formRow[i].setAttribute("aria-modal", "false");
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
            modal.style.display = "none";
            modal.setAttribute("aria-hidden", "true");
            modal.removeAttribute("aria-modal");
            modal.removeEventListener('click', closeModal);
            modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);
            modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
            modal = null;
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
    
        //suppression mini-image
        const btnDeleteImage = document.querySelectorAll('.btn-delete-image.fas.fa-trash-alt');
        for (let i = 0; i < btnDeleteImage.length; i++) {
            btnDeleteImage[i].setAttribute("href", "#modal-picture-" + i);
            //console.log(btnDeleteImage);
        }
    
        btnDeleteImage.forEach((element) => {
            element.addEventListener('click', function(e) {
                let target = document.querySelector(e.target.getAttribute("href"));
                console.log(target);
                e.preventDefault();
                if(confirm("Do you realy want to delete this picture ?!!")) {
                   target.remove();
                   this.parentNode.parentNode.remove();
                }else{
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
            element.addEventListener('click', function(e) {
                let target = document.querySelector(e.target.getAttribute("href"));
                e.preventDefault();
                if(confirm("Do you realy want to delete this video ?!!")) {
                    target.remove();
                    this.parentNode.parentNode.remove();
                }else{
                     this.location.reload();
                }
            })
        })
    })()
      