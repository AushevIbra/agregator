interface ICategories {
    setFoods(items: object[] | null): any;

    setSearchFoodsRedux(searchValue?: string ): any
}

const foodActions: ICategories = {
    setFoods: (items: object[] | null) => ({
        type: "FOODS:SET_ITEMS",
        payload: items
    }),

    setSearchFoodsRedux: (searchValue?: string) => ({
        type: "FOODS:SET_SEARCH_VALUE",
        payload: searchValue
    })
};

export default foodActions;