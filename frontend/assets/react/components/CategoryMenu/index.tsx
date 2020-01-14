import React, {useEffect} from 'react';
import {connect} from "react-redux";

// ========= Компоненты
import MobileMenu from './components/MobileMenu';
// import DesktopMenu from './components/DesktopMenu';

// =========== Стили
import './index.css';


interface ICategoryMenuItemProps {
    id: number;
    name: string;
    slug: string;
    icon?: string;
}

interface ICategoryMenuProps {
    categories?: Array<ICategoryMenuItemProps>
}

const mapStateToProps = (state: any) => {
    return {
        categories: state.categoryReducer.items
    }
};

const handleClick = (e: any, slug: string): void => {
    const activeElement = document.querySelector('.categories .active');
    if (null !== activeElement) {
        activeElement.classList.remove('active');
    }
    e.target.parentNode.classList.add('active');
};

const CategoryMenu: React.FC<ICategoryMenuProps> = ({categories}) => {


    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        return (
            <div className={"w-100 MobileCatalogPageFilters_container pushpin"} data-target="categories">
                <MobileMenu items={categories}/>
            </div>
        )
    }

    return <div className={"w-100 MobileCatalogPageFilters_container"} id={"nav-categories"}
                data-target="categories">
        <MobileMenu items={categories}/>
    </div>
}

export default connect(mapStateToProps)(CategoryMenu);
