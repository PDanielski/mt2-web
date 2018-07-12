import React from 'react';
import * as validations from '../form/input-validations';
import Loader from '../form/Loader';
import FieldErrorMessage from "../form/FieldErrorMessage";
import ErrorCheckingForm from "../form/ErrorCheckingForm";

var verify = function(response) {
    console.log(response);
};

export default class RegistrationForm extends ErrorCheckingForm {

    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleResponseErrors = this.handleResponseErrors.bind(this);

        this.apiUrl = props.options.apiUrl;
        this.afterSuccessUrl = props.options.successUrl;

        this.addField('login', '', new validations.LoginValidation());
        this.addField('password', '', new validations.PasswordValidation());
        this.addField('confirmPassword', '', {
            isValid: (password) => {
                return this.getFieldValue('password') === password;
            }
        });
        this.addField('g-recaptcha-response', '', {
            isValid: () => true
        });
        this.addField('email', '', new validations.EmailValidation());
        this.addField('socialId', '', new validations.SocialIdValidation());
        this.addChangeHandler('login', this.errorCheckingChangeHandler);
        this.addChangeHandler('password', this.errorCheckingChangeHandler);
        this.addChangeHandler('confirmPassword', this.errorCheckingChangeHandler);
        this.addChangeHandler('email', this.errorCheckingChangeHandler);
        this.addChangeHandler('socialId', this.errorCheckingChangeHandler);
        this.addChangeObserver('password', () => {
            this.refreshValidity('confirmPassword');
        });

    }

    handleSubmit(event) {
        event.preventDefault();
        this.flushAllErrorMessages();

        const data = {
            account: {
                login: this.getFieldValue('login'),
                password: this.getFieldValue('password'),
                confirmPassword: this.getFieldValue('confirmPassword'),
                email: this.getFieldValue('email'),
                socialId: this.getFieldValue('socialId')
            },
            "g-recaptcha-response": document.getElementById('g-recaptcha-response').value
        };

        this.startLoading();

        fetch(this.apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json().then(json => {
                return {
                    statusCode: response.status,
                    data: json
                };
            });
        }).then((response) => {
            if(response.statusCode === 400) {
                this.handleResponseErrors(response.data);
                this.stopLoading();
            } else if(response.statusCode === 201) {
                window.location.href = this.afterSuccessUrl;
            }
        });
    }

    handleResponseErrors(errorData) {
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
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>

                <div className="input-row my-3">
                    <input minLength={validations.MIN_LOGIN_LENGTH} maxLength={validations.MAX_LOGIN_LENGTH} id="login" className="input-1" type="text" placeholder="Login" onChange={this.handleChange}/>
                    <FieldErrorMessage errorMessage={this.getErrorMessage('login')}/>
                </div>
                <div className="input-row my-3">
                    <input minLength={validations.MIN_PASSWORD_LENGTH} maxLength={validations.MAX_PASSWORD_LENGTH} id="password" className="input-1" type="password" placeholder="Password" onChange={this.handleChange}/>
                    <FieldErrorMessage errorMessage={this.getErrorMessage('password')}/>
                </div>
                <div className="input-row my-3">
                    <input id="confirmPassword" className="input-1" type="password" placeholder="Confirm password" onChange={this.handleChange}/>
                    <FieldErrorMessage errorMessage={this.getErrorMessage('confirmPassword')}/>
                </div>
                <div className="input-row my-3">
                    <input id="email" className="input-1" type="email" placeholder="Email" onChange={this.handleChange}/>
                    <FieldErrorMessage errorMessage={this.getErrorMessage('email')}/>
                </div>
                <div className="input-row my-3">
                    <input id="socialId" minLength={validations.SOCIAL_ID_LENGTH} maxLength={validations.SOCIAL_ID_LENGTH} className="input-1" type="text" placeholder="Cancellation code" onChange={this.handleChange}/>
                    <FieldErrorMessage errorMessage={this.getErrorMessage('socialId')}/>
                </div>
                <div className="g-recaptcha" data-sitekey="6LdeX1gUAAAAAGcY8ODR03EC8LtJ04SeOzJfXJsC"></div>
                <FieldErrorMessage errorMessage={this.getErrorMessage('g-recaptcha-response')}/>
                <div className="my-3 flex-container flex-space-between flex-align-center">
                    <Loader hidden={!this.isLoading()}/>
                    <button disabled={!this.canBeSubmitted() && "true"} type="submit" className="abtn abtn-light abtn-bold">Register</button>
                </div>
            </form>
        );
    }
}