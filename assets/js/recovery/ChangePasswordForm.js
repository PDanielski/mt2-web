import React from 'react';
import Loader from "../form/Loader";
import {PasswordValidation} from "../form/input-validations";
import ErrorCheckingForm from "../form/ErrorCheckingForm";
import FieldErrorMessage from "../form/FieldErrorMessage";

export default class ChangePasswordForm extends ErrorCheckingForm {

    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.apiUrl = props.options.apiUrl;
        this.successUrl = props.options.successUrl;
        this.token = props.options.token;

        this.addField('password', '', new PasswordValidation());
        this.addField('confirmPassword', '', {
            isValid: (password) => this.getFieldValue('password') === password
        });
        this.addChangeObserver('password', () => {
            this.refreshValidity('confirmPassword');
        });
        this.addChangeHandler('password', this.errorCheckingChangeHandler);
        this.addChangeHandler('confirmPassword', this.errorCheckingChangeHandler);
    }

    handleSubmit(event) {
        event.preventDefault();
        this.flushAllErrorMessages();
        this.startLoading();

        fetch(this.apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                password: this.getFieldValue('password'),
                confirmPassword: this.getFieldValue('confirmPassword'),
                token: this.token
            })
        }).then((response) => {
            return response.json().then((json) => {
                return {
                    statusCode: response.status,
                    data: json
                }
            })
        }).then((response) => {
            if(response.statusCode === 400){
                this.setErrorMessage('password', response.data);
                this.showError('password');
                this.stopLoading();
            } else if(response.statusCode === 200) {
                window.location.href=this.successUrl;
            }
        });
    };


    render() {
        return (
            <form className="flex-container flex-centered" onSubmit={this.handleSubmit}>
                <div>

                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="password"  type="password" className="input-1" placeholder="Password"/>
                        <FieldErrorMessage errorMessage={this.getErrorMessage('password')}/>
                    </div>
                    <div className="my-3">
                        <input onChange={this.handleChange}  id="confirmPassword" type="password" className="input-1" placeholder="Confirm password"/>
                    </div>
                    <div className="my-3 flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light">Change password</button>
                    </div>
                </div>
            </form>
        )
    }
}