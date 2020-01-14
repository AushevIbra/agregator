const initialState = "";

export default function (state = initialState, {type, payload}) {
    if (type === "FOODS:SET_SEARCH_VALUE") {
        return payload;
    }

    return state;
}