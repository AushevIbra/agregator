import {combineReducers} from "redux";

const reducers = ["categoryReducer", "cartReducer", "foodReducer", "filterReducer", "preloaderReducer"];

export default combineReducers(
    reducers.reduce((initial, name) => {
        initial[name] = require(`./${name}`).default;
        return initial;
    }, {})
);