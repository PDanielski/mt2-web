import React from 'react';
import {PasswordValidation} from "../form/input-validations";
import Loader from '../form/Loader';
import FieldErrorMessage from "../form/FieldErrorMessage";
import ErrorCheckingForm from "../form/ErrorCheckingForm";

export default class ChangePasswordForm extends ErrorCheckingForm {

    constructor(props) {
        super(props);
        this.apiUrl = props.options.apiUrl;
        this.successUrl = props.options.successUrl;

        this.addField('oldPassword', '', {
            isValid: (oldPassword) => !!oldPassword
        });
        this.addField('newPassword', '', new PasswordValidation());
        this.addField('confirmNewPassword', '', {
            isValid: (confirmPassword) => confirmPassword === this.getFieldValue('newPassword')
        });
        this.addChangeHandler('oldPassword', this.errorCheckingChangeHandler);
        this.addChangeHandler('newPassword', this.errorCheckingChangeHandler);
        this.addChangeHandler('confirmNewPassword', this.errorCheckingChangeHandler);
        this.addChangeObserver('newPassword', () => {
            this.refreshValidity('confirmNewPassword');
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
                newPassword:this.getFieldValue('newPassword'),
                confirmNewPassword:this.getFieldValue('confirmNewPassword')
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
                        <input onChange={this.handleChange} id="oldPassword"  type="password" className="input-1" placeholder="Old password"/>
                        <FieldErrorMessage errorMessage={this.getErrorMessage('oldPassword')}/>
                    </div>
                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="newPassword" type="password" className="input-1" placeholder="New password"/>
                    </div>
                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="confirmNewPassword" type="password" className="input-1" placeholder="Confirm new password"/>
                    </div>

                    <div className="my-3 flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light" href="#">Change</button>
                    </div>
                </div>
            </form>
        )
    }
}