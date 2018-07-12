const ShowHideErrorMixin = {
    showError: (fieldId) => {
        if(fieldId) {
            let elem = document.getElementById(fieldId);
            if(elem) {
                elem.classList.add('input-error');
            }
        }
    },
    hideError: (fieldId) => {
        if(fieldId) {
            let elem = document.getElementById(fieldId);
            if(elem) {
                elem.classList.remove('input-error');
            }
        }
    }
};

export default ShowHideErrorMixin;