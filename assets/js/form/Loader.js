import React from 'react';

export default class Loader extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            width: props.width ? props.width : '1em',
            height: props.height ? props.height : '1em',
            hidden: props.hidden
        };
    }

    render() {
        return (
            <div className='loader' style={
                {
                    width:this.state.width,
                    height:this.state.height,
                    visibility: this.state.hidden ? 'hidden' : 'visible'
                }
            }></div>
        );
    }

    static getDerivedStateFromProps(nextProps, prevState) {
        return {
            hidden: nextProps.hidden
        }
    }
}