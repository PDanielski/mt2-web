import React from 'react';
import Loader from "../form/Loader";;
import FieldErrorMessage from "../form/FieldErrorMessage";
import ErrorCheckingForm from "../form/ErrorCheckingForm";

export default class LostPasswordForm extends ErrorCheckingForm {

    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.apiUrl = props.options.apiUrl;
        this.successUrl = props.options.successUrl;

        this.addField('login', '', {
            isValid: (login) => !!login
        });
        this.addChangeHandler('login', this.errorCheckingChangeHandler);
    }

    handleSubmit(event) {
        event.preventDefault();

        this.startLoading();
        this.flushAllErrorMessages();

        fetch(this.apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({login: this.getFieldValue('login')})
        }).then((response) => {
            return response.json().then((json) => {
                return {
                    statusCode: response.status,
                    data: json
                }
            })
        }).then((response) => {
            if(response.statusCode === 400){
                this.setErrorMessage('login', response.data);
                this.showError('login');
                this.stopLoading();
            } else if(response.statusCode === 200) {
                const email = response.data.email;
                window.location.href=this.successUrl + '?email=' + email;
            }
        });
    }

    render() {
        return (
            <form className="flex-container flex-centered" onSubmit={this.handleSubmit}>
                <div>
                    <div className="input-row my-3">
                        <input placeholder="Login" className="input-1" type="text" id="login" onChange={this.handleChange}/>
                        <FieldErrorMessage errorMessage={this.getErrorMessage('login')}/>
                    </div>
                    <div className="my-3 flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted() && "true"} type="submit" className="abtn abtn-light abtn-bold">Send email</button>
                    </div>
                </div>
            </form>
        )
    }
}
