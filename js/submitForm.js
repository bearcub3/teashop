(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.submitForm();
            console.log(userSort)
        },
        submitForm : function () {
            const select = doc.querySelector('#sort-select');
            const form = select.parentElement;

            select.addEventListener('change', (e) => {
                const { target } = e;
                const { value } = e.target;

                if(value === 'hightolow'){
                    target.lastElementChild.previousElementSibling.setAttribute('selected', '');  
                    target.firstElementChild.nextElementSibling.removeAttribute('selected'); 
                    target.lastElementChild.removeAttribute('selected');  
                }
                if(value === 'lowtohigh'){
                    target.firstElementChild.nextElementSibling.setAttribute('selected', '');
                    target.lastElementChild.previousElementSibling.removeAttribute('selected');   
                    target.lastElementChild.removeAttribute('selected');   
                }
                if(value === 'name') {
                    target.lastElementChild.setAttribute('selected', '');
                    target.lastElementChild.previousElementSibling.removeAttribute('selected'); 
                    target.firstElementChild.nextElementSibling.removeAttribute('selected'); 
                }
                form.submit();
            });
        }
    }
    allMyTeaShop.init();
})(window, document);