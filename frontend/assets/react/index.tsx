import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';

import {Provider} from "react-redux";
import store from "./redux/store";

if (null === localStorage.getItem('token')) {
    localStorage.setItem('token', Math.random().toString(36))
}


ReactDOM.render(
    <Provider store={store}>
        <App/>
    </Provider>, document.getElementById('root'));
