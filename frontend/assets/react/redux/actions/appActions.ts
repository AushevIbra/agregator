import {CategoriesApi} from '../../core/api/index'
import {categoriesActions} from './index'
import {AxiosResponse} from 'axios'

export default {
    init: () => {
        return (dispatch: any, getState: any) => {
            CategoriesApi.get().then((response: AxiosResponse) => {
                let categories: any = [];

                response.data.forEach((item: any) => {
                    categories.push({
                        id: item.id,
                        name: item.name,
                        icon: item.icon,
                    });
                })
                dispatch(categoriesActions.setCategories(categories));

                // console.log();
            })
        }
    }
}
