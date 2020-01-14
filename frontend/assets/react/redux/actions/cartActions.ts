interface ICategories {
    setCart(cart: object | null): any;

}

const cartActions: ICategories = {
    setCart: (cart: object | null) => ({
        type: "CART:SET_CART",
        payload: cart
    }),
};

export default cartActions;