export const MIN_LOGIN_LENGTH = 4;
export const MAX_LOGIN_LENGTH = 16;
export const MIN_PASSWORD_LENGTH = 6;
export const MAX_PASSWORD_LENGTH = 16;
export const SOCIAL_ID_LENGTH = 7;

export class LoginValidation {

    constructor() {
        this.minLength = MIN_LOGIN_LENGTH;
        this.maxLength = MAX_LOGIN_LENGTH;
    }

    isValid = (login) => {
        if(!login)
            return false;
        const re = /^[a-z0-9]+$/i;
        const length = login.length;
        return length >= this.minLength && length < this.maxLength + 1 && re.test(login);
    };

}
export class PasswordValidation {

    constructor() {
        this.minLength = MIN_PASSWORD_LENGTH;
        this.maxLength = MAX_PASSWORD_LENGTH;
    }

    isValid = (password) => {
        if(!password)
            return false;
        const length = password.length;
        return length >= this.minLength && length < this.maxLength + 1;
    };

}
export class EmailValidation {

    isValid = (email) => {
        if(!email)
            return false;
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };

}
export class SocialIdValidation {

    constructor() {
        this.length = SOCIAL_ID_LENGTH;
    }

    isValid = (socialId) => {
        if(!socialId)
            return false;
        const length = socialId.length;
        return !isNaN(socialId - parseFloat(socialId)) && length === this.length;
    };

}
