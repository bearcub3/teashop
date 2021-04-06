(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.rating();
        },
        rating: function() {
            const stars = doc.querySelectorAll('.rating');
            const input = doc.querySelector('.rating-value');
            // const starArray = Array.from(stars);
            const role = doc.querySelector('div[role]');
            let totalRate = 0;

            stars.forEach((el, i) => {
                el.addEventListener('keypress', (e) => {
                    const { key, target } = e;
                    if (key === 'Enter') interaction(i);
                });

                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    interaction(i);
                });
            });

        function interaction(i) {
            stars.forEach((el, j) => {
                const star = el.firstElementChild;

                if (i === j) {
                    if (star.classList.contains('bi-star')){
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                        star.parentElement.setAttribute('aria-checked', true);
                        totalRate++;
                    } else {
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                        star.parentElement.setAttribute('aria-checked', false);
                        totalRate--;
                    }
                } else if (i > j){
                    if (star.classList.contains('bi-star')){
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                        star.parentElement.setAttribute('aria-checked', true);
                        totalRate++;
                    }
                } else if (i < j){
                    if (star.classList.contains('bi-star-fill')) {
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                        star.parentElement.setAttribute('aria-checked', false);
                        totalRate--;
                    }
                }
            });

            input.setAttribute('value', totalRate);
            role.setAttribute('aria-label', `Your rating is ${totalRate}`);
        }
    }
}
    allMyTeaShop.init();
})(window, document);
