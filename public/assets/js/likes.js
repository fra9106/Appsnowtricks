function onClickBtnLike(e) {
    e.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-likes')
    const icon = this.querySelector('i')

    fetch(url).then(function (response) {
        if (response.ok) {
            response.json().then(function (data) {

                const likes = data.likes;
                spanCount.textContent = likes;

                if (icon.classList.contains('fas')) {
                    icon.classList.replace('fas', 'far');
                } else {
                    icon.classList.replace('far', 'fas');
                }
            });
        } else {
            alert('Please login to like');
        }
    })

}

document.querySelectorAll('a.js_like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
})

