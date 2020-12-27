//suppression mini-image
// on récupère ttes les classes correspondantes aux boutons de suppression des images
const btnDeleteImage = document.querySelectorAll('.btn-delete-image.fas.fa-trash-alt');
for (let i = 0; i < btnDeleteImage.length; i++) {// on boucle dessus...  
    btnDeleteImage[i].setAttribute("href", "#modal-image-" + i);//pour recupérer le modal de chq image
    console.log(btnDeleteImage);
}

btnDeleteImage.forEach((element) => {// on boucle sur chaque element pour écouter le click
    element.addEventListener('click', function (e) {
        let target = document.querySelector(e.target.getAttribute("href"));// on récupère le href cliqué (modal)
        console.log(target);
        e.preventDefault();//on stop la navigation par défaut
        if (confirm("Do you realy want to delete this picture ?!!")) {//confirmation utilisateur
            target.remove();//on supp la modale
            this.parentNode.parentNode.remove();//on supp les neuds parends (image et boutons)
        } else {
            this.location;//si on annule, on reste sur la page
        }
    })
})

//suppression mini-videos
const btnDeleteVideo = document.querySelectorAll('.btn-delete-video.fas.fa-trash-alt');
for (let i = 0; i < btnDeleteVideo.length; i++) {
    btnDeleteVideo[i].setAttribute("href", "#modal-video-" + i);
    console.log(btnDeleteVideo);
}

btnDeleteVideo.forEach((element) => {
    element.addEventListener('click', function (e) {
        let target = document.querySelector(e.target.getAttribute("href"));
        console.log(target);
        e.preventDefault();
        if (confirm("Do you realy want to delete this video ?!!")) {
            target.remove();
            this.parentNode.parentNode.remove();
        } else {
            this.location;
        }
    })
})

