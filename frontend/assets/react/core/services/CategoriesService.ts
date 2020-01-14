import {cartActions, categoriesActions, foodActions} from "../../redux/actions";
import {CategoriesApi} from "../api";
import {AxiosError, AxiosResponse} from "axios";
import preloaderAction from "../../redux/actions/preloaderAction";
import cartApi from "../api/cartApi";


interface ICategoriesService {
    save(store: any): void;

    byName(name?: string): any;
}

const CategoriesService: ICategoriesService = {

    save: (store: any) => {
        CategoriesApi.get()
            .then((response: AxiosResponse) => {
                let categories: any = [];

                response.data.data.forEach((item: any) => {
                    categories.push({
                        id: item.id,
                        name: item.name,
                        icon: item.icon,
                        slug: item.slug
                    });
                })
                store.dispatch(categoriesActions.setCategories(categories));
                store.dispatch(foodActions.setFoods(response.data.data));
                store.dispatch(preloaderAction.setPreloaderStatus(false));
                cartApi.getCart().then((response: AxiosResponse) => {
                    store.dispatch(cartActions.setCart(response.data.cart));
                })
            })
            .catch((error: AxiosError) => {
                console.log(error)
                store.dispatch(categoriesActions.setCategories([]));
            })

    },

    byName(name?: string): any {
        return CategoriesApi.get({name})
    }
};

export default CategoriesService;