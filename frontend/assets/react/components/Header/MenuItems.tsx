import React from 'react'
import {NavLink} from "react-router-dom";

export default ({className, id}) => {
    return (
        <ul className={className} id={id} style={{zIndex: "100000"}}>
            <li><NavLink to="/delivery">Доставка</NavLink></li>
            <li><NavLink to={"/pay"}>Оплата</NavLink></li>
            <li><NavLink to="/contacts">Контакты</NavLink></li>
        </ul>
    )
}