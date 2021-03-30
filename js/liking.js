(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.likeDiscusstion();
        },
        likeDiscusstion: function() {
            const hearts = doc.querySelectorAll('.liking');
            
            hearts.forEach((heart) => {
                const target = heart.firstElementChild;

                if (target.classList.contains('bi-heart-fill')){
                    return;
                } else {
                    heart.addEventListener('mouseenter', fillHeart);
                    heart.addEventListener('mouseleave', unfillHeart);
                }
            });

            function fillHeart(e) {
                e.preventDefault();
                const target = e.target;
                const i = target.firstElementChild;
                if (i.classList.contains('bi-heart')){
                    i.classList.remove('bi-heart');
                    i.classList.add('bi-heart-fill');
                }
            }

            function unfillHeart(e) {
                e.preventDefault();
                const target = e.target;
                const i = target.firstElementChild;

                if (i.classList.contains('bi-heart-fill')){
                    i.classList.remove('bi-heart-fill');
                    i.classList.add('bi-heart');
                }
            }
        }
    }
    allMyTeaShop.init();
})(window, document);