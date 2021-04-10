(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.navigationActive();
        },
        navigationActive : function (){
            const params = new URLSearchParams(doc.location.search.substring(1));
            const category = params.get("category");

            const navLinks = doc.querySelectorAll('.nav-link');

            navLinks.forEach((el) => {
                let menu = el.firstChild.textContent;
                if (menu === category) {
                    if (el.classList.contains('active')){
                        return;
                    } else {
                        el.classList.add('active');
                        el.setAttribute('aria-current', 'page');
                    }
                } else {
                    if (el.classList.contains('active')){
                        el.classList.remove('active');
                        el.removeAttribute('aria-current');
                    }
                }
            });
        }
    }

    allMyTeaShop.init();
})(window, document);

