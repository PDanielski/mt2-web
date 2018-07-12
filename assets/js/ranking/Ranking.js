import React from "react";

export default class Ranking extends React.Component {
    constructor(props) {
        super(props);
        this.currentPage = props.options.currentPage ? props.options.currentPage : 1;
        this.pageSize = props.options.pageSize ? props.options.pageSize : 10;
        this.maxPage = props.options.maxPage;
        this.baseUrl = props.options.baseUrl;
        this.state = ({
            currentPage: this.currentPage,
            loadedPages: [],
            isLoading: false
        });
        this.highlightedPositions = [];
    }

    componentDidMount(){
        this.loadPage(this.getCurrentPage());
    }

    loadPage = (pageNumber) => {
        throw new Error("You must implement this method in the derivated classes");
    };

    isPageLoaded = (pageNumber) => {
        return this.state.loadedPages[pageNumber] && this.state.loadedPages[pageNumber].constructor === Array;
    };

    getCurrentPage = () => {
        return this.state.currentPage;
    };

    setCurrentPage = (currentPage) => {
        this.setState({currentPage:currentPage});
    };

    isLoading = () => {
        return this.state.isLoading;
    };

    startLoading = () => {
        this.setState({isLoading:true});
    };

    stopLoading = () => {
        this.setState({isLoading:false});
    };

    getEntryIdFromPosition = (position) => {
        return 'row'+position;
    };

    getPageFromPosition = (position) => {
        return Math.floor(position/this.pageSize) + 1;
    };

    saveEntriesToPage = (pageNumber, entries) => {
        let tempLoadedPages = this.state.loadedPages;
        tempLoadedPages[pageNumber] = entries;
        this.setState({loadedPages:tempLoadedPages});
    };

    getEntriesInPage = (pageNumber) => {
        if(this.state.loadedPages[pageNumber]) {
            return this.state.loadedPages[pageNumber];
        }
        return [];
    };

    highlightPosition = (position) => {
        const id = this.getEntryIdFromPosition(position);
        let elem = document.getElementById(id);
        if(elem){
            elem.classList.add("highlighted-row");
            this.highlightedPositions.push(id);
        }
    };

    flushHighlightedPositions = () => {
        for(const index in this.highlightedPositions) {
            let elem = document.getElementById(this.highlightedPositions[index]);
            if(elem){
                elem.classList.remove("highlighted-row");
                this.highlightedPositions.splice(index, 1);
            }
        }
    };

    switchPage = (pageNumber) => {
        this.flushHighlightedPositions();
        if(this.getCurrentPage() === pageNumber)
            return new Promise(resolve => resolve());

        if(this.isPageLoaded(pageNumber)){
            return new Promise((resolve) => {
                history.pushState(null, null, this.baseUrl+'/'+pageNumber);
                this.setCurrentPage(pageNumber);
                resolve();
            });
        } else {
            return this.loadPage(pageNumber).then(() => {
                history.pushState(null, null, this.baseUrl+'/'+pageNumber);
                this.setCurrentPage(pageNumber)
            });
        }
    };

    navigateToPosition = (position, topAnchorId) => {
        return this.switchPage(this.getPageFromPosition(position)).then(() => {
            this.flushHighlightedPositions();
            this.highlightPosition(position);
            const topsideEntries = position % this.pageSize;
            if(topsideEntries > 5) {
                window.location.href = '#'+this.getEntryIdFromPosition(position - 5);
            } else {
                window.location.href = topAnchorId;
            }
        })
    };

}
