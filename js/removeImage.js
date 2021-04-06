(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.removeImage();
        },
        removeImage : function () {
            const images = doc.querySelectorAll('.remove-image');

            

            images.forEach((img, idx) => {
                const target = img.firstElementChild;
                const form = img.parentElement;

                img.addEventListener('mouseenter', hoverCloseIcon);
                img.addEventListener('mouseleave', hoverCloseIcon);
                img.addEventListener('click', (e) => {
                    console.log('hi')
                    form.submit();
                    form.parentElement.remove();
                });
                
            });

            function hoverCloseIcon(e) {
                e.preventDefault();
                const target = e.target.firstElementChild;
                target.classList.toggle('bi-x-circle-fill')
            }
        }
    }
    allMyTeaShop.init();
})(window, document);