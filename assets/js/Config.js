export default class Config {

    static getOptionsForComponent(componentId) {
        if(window.reactConfig[componentId]){
            return window.reactConfig[componentId];
        }
        return {};
    }
}