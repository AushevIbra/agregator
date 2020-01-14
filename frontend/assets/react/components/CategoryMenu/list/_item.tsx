import React from 'react';

export default ({id, name, icon}) => (
    <li className={"MobileCatalogPageFilters_filter"}>
        <span>
            <i className={"MobileCatalogPageFilters_filterIcon lazyload"} data-src={icon}></i>
        </span>
        <a href={'#'} className={"MobileCatalogPageFilters_filterName"}>{name}</a>
    </li>
)