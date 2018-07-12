import React from 'react';

function FieldErrorMessage(props) {
    if(props.errorMessage){
        return (
            <div className="input-error-text"><small>{props.errorMessage}</small></div>
        );
    }
    return null;
}

export default FieldErrorMessage;