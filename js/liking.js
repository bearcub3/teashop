(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.likeDiscusstion();
            this.deleteDiscussion();
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
        },
        deleteDiscussion: function() {
            const deletes = doc.querySelectorAll('.deleting');

            deletes.forEach((del) => {
                const target = del.firstElementChild;

                if (target.classList.contains('bi-trash-fill')){
                    return;
                } else {
                    del.addEventListener('mouseenter', fillBin);
                    del.addEventListener('mouseleave', unfillBin);
                }
            });

            function fillBin(e) {
                e.preventDefault();
                const target = e.target;
                const i = target.firstElementChild;
                if (i.classList.contains('bi-trash')){
                    i.classList.remove('bi-trash');
                    i.classList.add('bi-trash-fill');
                }
            }

            function unfillBin(e) {
                e.preventDefault();
                const target = e.target;
                const i = target.firstElementChild;

                if (i.classList.contains('bi-trash-fill')){
                    i.classList.remove('bi-trash-fill');
                    i.classList.add('bi-trash');
                }
            }
        }
    }
    allMyTeaShop.init();
})(window, document);