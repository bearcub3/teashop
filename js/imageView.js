(function (win, doc){
    const furniture = {
        init : function () {
            this.imageViewer();
        },
        imageViewer : function (){
            const viewer = doc.querySelector('.image-view');
            const imgBtn = doc.querySelectorAll('.image-btn');
            const imageSrc = viewer.getAttribute('src');
            const regex = /\/\w\D*/g;
            const imageSrcPrefix = imageSrc.match(regex)[0];

            imgBtn.forEach((el, index) => {
                if (index === 0) {
                    el.classList.add('selected');
                    el.firstChild.classList.add('border','border-primary','border-2');
                }

                el.addEventListener('click', function(){        
                    if(this.classList.contains('selected')) {
                        return;
                    } 

                    if(!this.classList.contains('selected')) {
                        this.classList.add('selected');
                        this.firstChild.classList.add('border','border-primary','border-2');
                        viewer.setAttribute('src', `assets/${imageSrcPrefix}${index+1}.jpeg`);
                        
                        imgBtn.forEach((el, i) => {
                            if(el.classList.contains('selected') && index != i){
                                el.classList.remove('selected');
                                el.firstChild.classList.remove('border','border-primary','border-2');
                            }
                        });
                    }
                });
            });
        }
    }

    furniture.init();
})(window, document);

