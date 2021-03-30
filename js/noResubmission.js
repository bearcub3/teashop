(function (win, doc){
    const allMyTeaShop = {
        init : function () {
            this.noResubmission();
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