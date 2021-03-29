(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.submitForm();
            this.noResubmission();
        },
        submitForm : function () {
            const select = doc.querySelector('#sort-select');
            const form = select.parentElement;
            
            select.addEventListener('change', (e) => {
                form.submit();
            })
        },
        noResubmission: function() {
            /** to update the URL of the current history entry in response to user's actions **/
            if ( win.history.replaceState ) {
                win.history.replaceState( null, null, win.location.href );
            }
        }
    }
    allMyTeaShop.init();
})(window, document);