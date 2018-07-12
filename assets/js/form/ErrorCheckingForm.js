import Form from "./Form";
import ShowHideErrorMixin from "./ShowHideErrorMixin";

export default class ErrorCheckingForm extends Form {
    constructor(props){
        super(props);
        this.errorCheckingChangeHandler = this.errorCheckingChangeHandler.bind(this);
        this.refreshValidity = this.refreshValidity.bind(this);
        Object.assign(ErrorCheckingForm.prototype, ShowHideErrorMixin);
    }

    errorCheckingChangeHandler(event) {
        this.basicChangeHandler(event);
        const id = event.target.id;
        const value = event.target.value;
        this.refreshValidity(id, value);
    }

    refreshValidity(fieldId, fieldValue = null) {
        if(fieldValue === null)
            fieldValue = this.getFieldValue(fieldId);
        this.flushErrorMessage(fieldId);
        if(this.getValidation(fieldId).isValid(fieldValue)) {
            this.hideError(fieldId);
        } else {
            this.showError(fieldId);
        }
    }

}