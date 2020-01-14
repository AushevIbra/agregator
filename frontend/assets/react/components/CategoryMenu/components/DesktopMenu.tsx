import React from 'react';

interface IDesktopMenuProps {
    items?: Array<object>,
    onClick: (e: any, slug: string) => void
}


const DesktopMenu: React.FC<IDesktopMenuProps> = ({items, onClick}) => {
    return (
        <ul className={"categories"}>
            {
                items && items.map((item: any, key) => {
                    return (
                        <li className={key === 0 ? 'active' : ''} key={key}>
                            <a onClick={(e: any) => onClick(e, item.slug)} href={`#${item.slug}`}>{item.name}</a>
                        </li>
                    )
                })
            }
        </ul>
    )
};

export default DesktopMenu