import React from 'react';
import CategoryMenuItem from "../list/_item";

interface IMobileMenuProps {
    items?: Array<object>
}

const MobileMenu: React.FC<IMobileMenuProps> = ({items}) => {
    return (
        <ul className={"MobileCatalogPageFilters_filters"}>
            {items && items.map((item: any, key: number) => {
                return <CategoryMenuItem name={item.name} icon={"https://dostavka-gussi.com/storage/categories/tNYa0jJHZPT3Yn4M86dB4yVERm4JaP38jISC5Kp4.png"} id={item.id} key={key}/>
            })}

        </ul>
    )
}

export default MobileMenu