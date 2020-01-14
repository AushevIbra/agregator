interface ICategories {
    setCategories(items: object[] | null) : any,
}

const Categories: ICategories = {
    setCategories: (items: object[] | null) => ({
        type: "CATEGORIES:SET_ITEMS",
        payload: items
    })
}

export default Categories;