const initialState = {
    cart: null,
    items: [],
};

export default (state = initialState, {type, payload}) => {
    switch (type) {
        case "CART:SET_CART":
            return {
                ...state,
                cart: payload
            };


        case "CART:SET_ITEMS":
            return {
                ...state,
                items: payload
            };

        default:
            return state;
    }
};