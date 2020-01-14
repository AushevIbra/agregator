import React, {useEffect} from 'react';
import './index.css'
import logo from '../../static/img/logo.png';
import MenuItems from './MenuItems';
import {NavLink} from "react-router-dom";

declare global {
    interface Window { sidenav: any; }
}

const Header = () => {
    useEffect(() => {
        window.sidenav();
    });
    return (
        <div id="nav" style={{minHeight: "100px"}}>
            <nav className={"pushpin"} data-target="nav">
                <div className="container nav-wrapper">
                    <NavLink to="/" className="brand-logo">
                        <img src={logo} alt={"Gussi"} title={"Gussi"}/>
                    </NavLink>
                    <a href="#menu" data-target="mobile-demo" className="sidenav-trigger"><i
                        className="material-icons">menu</i></a>
                    <MenuItems className={"right hide-on-med-and-down"} id={""}/>
                </div>
            </nav>

            <MenuItems className="sidenav" id="mobile-demo"/>
        </div>

    )
}

export default Header;