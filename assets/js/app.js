import './images.js';
import './styles.js';
import './routes.js';
import React from 'react';
import ReactDOM from 'react-dom';
import RegistrationForm from './registration/RegistrationForm';
import LostPasswordForm from './recovery/LostPasswordForm';
import LoginForm from "./login/LoginForm";
import RecoveryChangePasswordForm  from "./recovery/ChangePasswordForm";
import SettingsChangePasswordForm from "./settings/ChangePasswordForm";
import PlayerRanking from "./ranking/PlayerRanking";
import ChangeEmailForm from "./settings/ChangeEmailForm";

const components = {
    'registrationForm': RegistrationForm,
    'lostPasswordForm': LostPasswordForm,
    'loginForm': LoginForm,
    'changeLostPasswordForm': RecoveryChangePasswordForm,
    'settingsChangePasswordForm': SettingsChangePasswordForm,
    'playerRanking': PlayerRanking,
    'settingsChangeEmailForm': ChangeEmailForm
};

const loadComponent = (componentName, elem, options = {}) => {
    if(!components[componentName])
        throw new Error("Component "+componentName+" is not registered");
    ReactDOM.render(React.createElement(components[componentName], {options: options}, null), elem);
};

window.loadComponent = loadComponent;
