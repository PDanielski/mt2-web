import ErrorCheckingForm from "../form/ErrorCheckingForm";
import Loader from "../form/Loader";
import React from 'react';

export default class GuildPlayerNavigator extends ErrorCheckingForm {
    constructor(props) {
        super(props);
        this.state['players'] = [];
        this.state['currentlyFocusedPlayerId'] = 0;

        this.apiUrl = props.apiUrl;
        this.onPositionNavigated = props.onPositionNavigated;

        this.addField('guildName', '', {
            isValid: (guildName) => !!guildName
        });
        this.addChangeHandler('guildName', this.errorCheckingChangeHandler);
    }

    reset = () => {
      this.setState({
          players:[],
          currentlyFocusedPlayerId: 0
      });
    };
    handleSubmit = (event) => {
        event.preventDefault();
        this.startLoading();
        this.reset();
        fetch(this.apiUrl.replace(':guildName', this.getFieldValue('guildName'))).then((response) => {
            return response.json();
        }).then((response) => {
            if(response.count > 0) {
                this.setState({players: response.players});
                this.setFieldValue('guildName', '');
                this.onPositionNavigated(response.players[0].position);
            } else {
                this.showError('guildName');
            }
            this.stopLoading();
        })
    };


    goLeft = () => {
        const index = this.state.currentlyFocusedPlayerId;
        if(index > 0) {
            this.startLoading();
            this.onPositionNavigated(this.state.players[index-1].position).then(() => {
                this.setState({currentlyFocusedPlayerId: index-1});
                this.stopLoading();
            });
        }
    };

    goRight = () => {
        const index = this.state.currentlyFocusedPlayerId+1;
        if(index < this.state.players.length){
            this.startLoading();

            this.onPositionNavigated(this.state.players[index].position).then(() => {
                this.setState({currentlyFocusedPlayerId: index});
                this.stopLoading();
            });

        }
    };

    renderSearchNavigation = () => {
        if(this.state.players.length > 0)
            return (
                <div className="flex-container flex-space-between my-2">
                    <button disabled={this.isLoading()} className={"abtn abtn-sl abtn-light"} onClick={this.goLeft}>Prev</button>
                    <div>{this.state.currentlyFocusedPlayerId+1}/{this.state.players.length}</div>
                    <button disabled={this.isLoading()} className={"abtn abtn-sl abtn-light"} onClick={this.goRight}>Next</button>
                </div>
            );
    };

    render() {
        return (
            <div>
                <form onSubmit={this.handleSubmit}>
                    <div className="input-row">
                        <input value={this.getFieldValue('guildName')} id="guildName" className="input-1 input-1-sl" placeholder="Guild name" onChange={this.handleChange}/>
                    </div>
                    <div className="flex-container flex-space-between flex-align-center">
                        <Loader hidden={!this.isLoading()}/>
                        <button disabled={!this.canBeSubmitted()} type="submit" className="abtn abtn-light">Search</button>
                    </div>
                </form>
                {this.renderSearchNavigation()}
            </div>
        )
    }
}