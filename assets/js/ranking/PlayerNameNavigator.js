import ErrorCheckingForm from "../form/ErrorCheckingForm";
import Loader from "../form/Loader";
import React from 'react';

export default class PlayerNameNavigator extends ErrorCheckingForm {
    constructor(props){
        super(props);
        this.apiUrl = props.apiUrl;
        this.onPositionNavigated = props.onPositionNavigated;

        this.addField('playerName', '', {
            isValid: (playerName) => !!playerName
        });
        this.addChangeHandler('playerName', this.errorCheckingChangeHandler);
    }

    handleSubmit = (event) => {
        event.preventDefault();
        this.startLoading();
        fetch(this.apiUrl.replace(":playerName", this.getFieldValue('playerName'))).then((response) => {
            return response.json().then((json) => {
                return {
                    statusCode: response.status,
                    data: json
                };
            })
        }).then((response) => {
            if(response.statusCode === 200) {
                this.onPositionNavigated(response.data.position);
            } else {
                this.setErrorMessage('playerName', response.data.message);
                this.showError('playerName');
            }
            this.setFieldValue('playerName', '');
        }).finally(() => this.stopLoading());
    };

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="input-row">
                    <input value={this.getFieldValue('playerName')} id="playerName" className="input-1 input-1-sl" placeholder="Player name" onChange={this.handleChange}/>
                </div>
                <div className="flex-container flex-space-between flex-align-center">
                    <Loader hidden={!this.isLoading()}/>
                    <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light">Search</button>
                </div>
            </form>
        )
    }
}