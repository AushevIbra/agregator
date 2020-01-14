const initialState = true;

export default function (state = initialState, {type, payload}) {
    if (type === "PRELOADER:SET_VALUE") {
        return payload;
    }

    return state;
}