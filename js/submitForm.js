(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.submitForm();
        },
        submitForm : function () {
            const select = doc.querySelector('#sort-select');
            const form = select.parentElement;
            
            select.addEventListener('change', (e) => {
                form.submit();
            });
        }
    }
    allMyTeaShop.init();
})(window, document);