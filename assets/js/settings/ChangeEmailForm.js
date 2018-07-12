import React from 'react';
import {EmailValidation, PasswordValidation} from "../form/input-validations";
import Loader from '../form/Loader';
import FieldErrorMessage from "../form/FieldErrorMessage";
import ErrorCheckingForm from "../form/ErrorCheckingForm";

export default class ChangeEmailForm extends ErrorCheckingForm {
    constructor(props) {
        super(props);
        this.apiUrl = props.options.apiUrl;
        this.successUrl = props.options.successUrl;

        this.addField('oldPassword', '', {
            isValid: (oldPassword) => !!oldPassword
        });
        this.addField('newEmail', '', new EmailValidation());
        this.addField('confirmNewEmail', '', {
            isValid: (confirmEmail) => confirmEmail === this.getFieldValue('newEmail')
        });
        this.addChangeHandler('oldPassword', this.errorCheckingChangeHandler);
        this.addChangeHandler('newEmail', this.errorCheckingChangeHandler);
        this.addChangeHandler('confirmNewEmail', this.errorCheckingChangeHandler);
        this.addChangeObserver('newEmail', () => {
            this.refreshValidity('confirmNewEmail');
        });
    }

    handleSubmit = (event) => {
        event.preventDefault();
        this.startLoading();
        this.flushAllErrorMessages();

        fetch(this.apiUrl, {
            method:'POST',
            credentials:'include',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                oldPassword:this.getFieldValue('oldPassword'),
                newEmail:this.getFieldValue('newEmail'),
                confirmNewEmail:this.getFieldValue('confirmNewEmail')
            })
        }).then((response) => {
            return response.json().then((json) => {
                return {
                    statusCode: response.status,
                    data: json
                };
            })
        }).then((response) => {
            if(response.statusCode === 200) {
                window.location.href = this.successUrl;
            } else {
                this.handleResponseErrors(response.data);
                this.stopLoading();
            }
        })
    };

    handleResponseErrors = (errorData) => {
        const fieldErrors = errorData.fieldErrors;
        if(fieldErrors.length > 0) {
            for (const fieldError of fieldErrors) {
                const fieldName = fieldError.field;
                const message = fieldError.message;
                if(fieldName && message){
                    this.showError(fieldName);
                    this.setErrorMessage(fieldName, message);
                }
            }
        }
    };

    render() {
        return (
            <form className="flex-container flex-centered" onSubmit={this.handleSubmit}>
                <div>
                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="oldPassword"  type="password" className="input-1" placeholder="Current password"/>
                        <FieldErrorMessage errorMessage={this.getErrorMessage('oldPassword')}/>
                    </div>
                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="newEmail" type="email" className="input-1" placeholder="New email"/>
                    </div>
                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="confirmNewEmail" type="email" className="input-1" placeholder="Confirm new email"/>
                    </div>
                    <div className="my-3 flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light">Change</button>
                    </div>
                </div>
            </form>
        );
    }
}