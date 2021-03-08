import React from 'react';
import Loader from "../form/Loader";
import FieldErrorMessage from "../form/FieldErrorMessage";
import ErrorCheckingForm from "../form/ErrorCheckingForm";

export default class LoginForm extends ErrorCheckingForm {

    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.loginUrl = props.options.apiUrl;
        this.lostPasswordUrl = props.options.lostPasswordUrl;
        this.afterLoginUrl = props.options.successUrl;
        this.errorMessage = props.options.errorMessage;

        this.addField('login', '', {
            isValid: (login) => !!login
        });

        this.addField('password', '', {
            isValid: (password) => !!password
        });

        this.addChangeHandler('login', this.errorCheckingChangeHandler);
        this.addChangeHandler('password', this.errorCheckingChangeHandler);
    }

    handleSubmit(event) {
        event.preventDefault();
        this.startLoading();
        fetch(this.loginUrl,{
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            credentials: 'include',
            body: '_username='+encodeURIComponent(this.getFieldValue('login'))+'&_password='+encodeURIComponent(this.getFieldValue('password'))
        }).then((response) => {
            if(response.status === 401 ) {
                this.stopLoading();
                this.setErrorMessage('login', this.errorMessage);
                this.showError('login');
            } else if(response.ok) {
                window.location.href = this.afterLoginUrl;
            }
        });
    }


    render() {
        return (
            <form className="flex-container flex-centered" onSubmit={this.handleSubmit}>
                <div>

                    <div className="input-row my-3">
                        <input onChange={this.handleChange} id="login"  type="text" className="input-1" placeholder="Login"/>
                        <FieldErrorMessage errorMessage={this.getErrorMessage('login')}/>
                    </div>
                    <div className="my-3">
                        <input onChange={this.handleChange} id="password" type="password" className="input-1" placeholder="Password"/>
                        <div className="centered">
                            <a href={this.lostPasswordUrl} className="link-red">
                                <small>Have you forgotten your password?</small>
                            </a>
                        </div>
                    </div>

                    <div className="my-3 flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light" href="#">Put me in</button>
                    </div>
                </div>
            </form>
        )
    }
}