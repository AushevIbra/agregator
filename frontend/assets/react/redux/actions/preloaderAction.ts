interface IPreloaderAction {
    setPreloaderStatus(status: boolean): any;
}

const preloaderAction: IPreloaderAction = {
    setPreloaderStatus: (status: boolean) => ({
        type: "PRELOADER:SET_VALUE",
        payload: status
    }),
};

export default preloaderAction;