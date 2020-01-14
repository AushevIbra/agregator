import React from 'react';
import './index.css';
import {CategoryMenu, RestaurantsMenu} from "../../components";


const HomePage = () => {
    return (
        <div>
            <CategoryMenu/>
            <RestaurantsMenu/>
        </div>
    )
}

export default HomePage;