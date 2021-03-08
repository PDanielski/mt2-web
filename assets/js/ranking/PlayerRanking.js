import React from 'react';
import Loader from "../form/Loader";
import PlayerNameNavigator from "./PlayerNameNavigator";
import GuildPlayerNavigator from "./GuildPlayerNavigator";
import Ranking from "./Ranking";

export default class PlayerRanking extends Ranking {

    constructor(props) {
        super(props);
        this.apiUrl = props.options.apiUrl;
        this.title = props.options.title;
        this.desc = props.options.desc;
    }

    loadPage = (pageNumber) => {
        if(this.isPageLoaded(pageNumber))
            return new Promise(function(resolve){
               resolve();
            });

        this.startLoading();
        const offset = (pageNumber - 1) * this.pageSize;
        const limit = this.pageSize;
        return fetch(this.apiUrl.replace('pageNumber', this.getCurrentPage())+'?offset='+offset+'&limit='+limit).then((response) => {
            return response.json();
        }).then((response) => {
            this.saveEntriesToPage(pageNumber, response.players);
            this.stopLoading();
        })
    };

    nextPageClick = () => {
        this.switchPage(this.getCurrentPage()+1);
    };

    prevPageClick = () => {
        this.switchPage(this.getCurrentPage()-1);
    };

    onPositionNavigated = (position) => {
        return this.navigateToPosition(position, "#ranking-title");
    };

    renderNavButtons = () => {
        return (
            <div className="flex-container flex-space-between my-2">
                <button disabled={this.isLoading() || this.getCurrentPage() < 2 } className={"abtn abtn-sl abtn-light"} onClick={this.prevPageClick}>Prev</button>
                <Loader hidden={!this.isLoading()}/>
                <button disabled={this.isLoading()} className={"abtn abtn-sl abtn-light"} onClick={this.nextPageClick}>Next</button>
            </div>
        );
    };

    renderPlayersList = () => {
        const players = this.getEntriesInPage(this.getCurrentPage());
        let rows = [];
        for(const player of players) {
            const className = player.kingdomName + "-row-bg";
            rows.push(
                <tr id={this.getEntryIdFromPosition(player.position)} className={className} key={player.position}>
                    <td>{player.position + 1}</td>
                    <td>{player.name}</td>
                    <td>{player.raceName}</td>
                    <td>{player.kingdomName}</td>
                    <td>{player.guildName}</td>
                    <td>{player.level}</td>
                    <td>{player.prestige}</td>
                    <td>{player.mmr}</td>
                    <td>{player.tower}</td>
                </tr>
            );
        }
        return rows;
    };

    render() {
        let tableClassName = "player-list";
        if(this.isLoading()) tableClassName = tableClassName + " loading-target-element";
        let loadingOverlayClassName = "loading-overlay";
        if(!this.isLoading()) loadingOverlayClassName = loadingOverlayClassName + " visuallyhidden";

        const searchFormApiUrl = this.apiUrl + '/name/:playerName';
        const searchByGuildFormApiUrl = this.apiUrl + '/guild/:guildName';
        return (
            <div className="flex-container flex-space-between">
                <div className="f-6 px-3 py-3">
                    <div id="ranking-title" className="title-3">{this.title}</div>
                    <p style={{fontWeight: 300}}>{this.desc}</p>
                    {this.renderNavButtons()}
                    <div className={"title-hr"}></div>
                    <div style={{position:"relative"}}>
                        <table className={tableClassName}>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Race</th>
                                    <th>Kingdom</th>
                                    <th>Guild</th>
                                    <th>Level</th>
                                    <th>Prestige</th>
                                    <th>Mmr</th>
                                    <th>Piano Torre</th>
                                </tr>
                            </thead>
                            <tbody>
                                {this.renderPlayersList()}
                            </tbody>
                        </table>
                        {this.renderNavButtons()}
                    </div>
                </div>
                <div style={{position:'sticky', top:0, alignSelf:'flex-start'}} className="f-2 px-2">
                    <div className="box my-3">
                        <div className="box-title">
                            <strong>Find by player name</strong>
                        </div>
                        <div className="title-hr"></div>
                        <PlayerNameNavigator apiUrl={searchFormApiUrl} onPositionNavigated={this.onPositionNavigated}/>
                    </div>
                    <div className="box my-3">
                        <div className="box-title">
                            <strong>Find by guild name</strong>
                        </div>
                        <div className="title-hr"></div>
                        <GuildPlayerNavigator apiUrl={searchByGuildFormApiUrl} onPositionNavigated={this.onPositionNavigated}/>
                    </div>
                </div>
            </div>
        );
    }
}