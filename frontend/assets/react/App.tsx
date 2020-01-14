import React from 'react';
import './app.css';

import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';

import {HomePage} from './pages'

// actions 
import {connect} from "react-redux";
import {Header} from "./components";
import {appActions} from "./redux/actions";

const App: React.FC = (props: any) => {
    props.init();

    return (
        <div className="App">
            <Router>
                <Header/>
                <Switch>
                    <Route exact path={"/"} component={HomePage}/>
                </Switch>
            </Router>


        </div>
    );
}

const mapStateProps = (state: any) => {
    return {
        preloader: state.preloaderReducer
    }
}

export default connect(mapStateProps, {...appActions})(App);
