import React from 'react';

export default class Form extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            fields: {},
            errorMessages: {},
            isLoading: false
        };

        this.addField = this.addField.bind(this);
        this.getFieldValue = this.getFieldValue.bind(this);
        this.setFieldValue = this.setFieldValue.bind(this);
        this.getValidation = this.getValidation.bind(this);
        this.getChangeHandler = this.getChangeHandler.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.addChangeHandler = this.addChangeHandler.bind(this);
        this.basicChangeHandler = this.basicChangeHandler.bind(this);
        this.getErrorMessage = this.getErrorMessage.bind(this);
        this.setErrorMessage = this.setErrorMessage.bind(this);
        this.flushAllErrorMessages = this.flushAllErrorMessages.bind(this);
        this.flushErrorMessage = this.flushErrorMessage.bind(this);
        this.isLoading = this.isLoading.bind(this);
        this.startLoading = this.startLoading.bind(this);
        this.stopLoading = this.stopLoading.bind(this);
        this.canBeSubmitted = this.canBeSubmitted.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.addChangeObserver = this.addChangeObserver.bind(this);

        this.validations = {};
        this.changeHandlers = {};
        this.changeObservers = {};
    }


    addField(fieldId, initialFieldValue = '', validation = null) {
        this.state.fields[fieldId] = initialFieldValue;

        if(validation && typeof validation.isValid !== 'function') {
            throw new Error("The validation must have an isValid method");
        }

        this.validations[fieldId] = validation;
    };

    addChangeObserver(subjectFieldId, observer) {
        if(this.changeObservers[subjectFieldId]) {
            this.changeObservers[subjectFieldId].push(observer);
        } else {
            this.changeObservers[subjectFieldId] = [observer];
        }
    }

    getFieldValue(fieldId) {
        return this.state.fields[fieldId];
    }

    setFieldValue(fieldId, fieldValue) {
        let tempFields = this.state.fields;
        tempFields[fieldId] = fieldValue;
        this.setState({fields: tempFields});
    }

    getChangeHandler(fieldId) {
        if(this.changeHandlers[fieldId]){
            return this.changeHandlers[fieldId];
        }
        return null;
    }

    getValidation(fieldId) {
        if(!this.validations[fieldId])
            return null;

        return this.validations[fieldId];
    }

    handleChange(event) {
        const handler = this.changeHandlers[event.target.id];
        if(typeof handler === 'function'){
            handler(event);
            const observers = this.changeObservers[event.target.id];
            if(observers && observers.length > 0) {
                for(const observer of observers) {
                    observer(event);
                }
            }
        } else
            throw new Error("The handler for " + event.target.id + " is not set or invalid");
    }

    addChangeHandler(fieldId, changeHandler) {
        if(!this.state.fields[fieldId] && this.state.fields[fieldId] !== '') {
            throw new Error("You cannot set a change handler for a not registered field. Use addField first");
        }

        if(typeof changeHandler !== 'function'){
            throw new Error("The change handler must ba a callback");
        }

        this.changeHandlers[fieldId] = changeHandler;
    };

    basicChangeHandler(event) {
        let fields = this.state.fields;
        fields[event.target.id] = event.target.value;
        this.setState({
            fields: fields
        });
    }

    getErrorMessage(fieldId){
        return this.state.errorMessages[fieldId];
    }

    setErrorMessage(fieldId, errorMessage) {
        let errorMessages = this.state.errorMessages;
        if(!this.state.fields[fieldId]  && this.state.fields[fieldId] !== ''){
            throw new Error("You cannot set an error message for a not registered field. Use addField first");
        }
        errorMessages[fieldId] = errorMessage;
        this.setState({errorMessages:errorMessages});
    }

    flushErrorMessage(fieldId) {
        this.setErrorMessage(fieldId, '');
    }

    flushAllErrorMessages() {
        this.setState({errorMessages:{}});
    }

    isLoading() {
        return this.state.isLoading;
    }

    startLoading()  {
        this.setState({isLoading: true});
    }

    stopLoading() {
        this.setState({isLoading: false});
    }

    canBeSubmitted() {
        for(const id in this.validations) {
            if(this.validations.hasOwnProperty(id) && typeof this.validations[id].isValid === 'function') {
                if(!this.validations[id].isValid(this.getFieldValue(id)))
                    return false;
            }
        }

        return !this.isLoading();
    }

}