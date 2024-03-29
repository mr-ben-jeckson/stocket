import axiosClient from "../axios";

export function getUser({commit}) {
    return axiosClient.get('/user')
        .then(({data}) => {
            commit('setUser', data);
            return data;
        })
}

export function login({commit}, data) {
    return axiosClient.post('/login', data)
        .then(({data}) => {
            commit('setUser', data.user);
            commit('setToken', data.token);
            return data;
        });
}

export function logout({commit}) {
    return axiosClient.post('/logout')
        .then((response) => {
            commit('setToken', null);
            return response;
        });
}

export function getProducts({commit}, {url = null, search = '', perPage = 10, sort_field, sort_direction} = {}) {
    commit('setProducts', [true]);
    url = url || '/product'
    return axiosClient.get(url, {
        params: {
            search,
            sort_field,
            sort_direction,
            per_page: perPage
        }
    })
        .then(res => {
            commit('setProducts', [false, res.data]);
        })
        .catch(() => {
            commit('setProducts', [false]);
        })
}

export function createProduct({commit}, product) {
    if(product.image instanceof File) {
        const form = new FormData();
        form.append('title', product.title);
        form.append('image', Array.from(product.image));
        form.append('description', product.description);
        form.append('price', product.price);
        form.append('tag', Array.from(product.tag));
        form.append('category', Array.from(product.category));
        form.append('published', Array.from(product.published));
        product = form;
    }

    return axiosClient.post('/product', product, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
}

export function getProduct({}, id) {
    return axiosClient.get(`/product/${id}`);
}

export function updateProduct({commit}, product) {
    const id = product.id;
    if(product.image instanceof File) {
        const form = new FormData();
        form.append('title', product.title);
        form.append('image', Array.from(product.image));
        form.append('description', product.description);
        form.append('price', product.price);
        form.append('tag', Array.from(product.tag));
        form.append('category', Array.from(product.category));
        form.append('published', Array.from(product.published));
        form.append('_method', 'PUT');
        product = form;
    } else {
        product._method = 'PUT';
    }

    return axiosClient.post(`/product/${id}`, product, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
}

export function deleteSingleImageProduct({commit}, { id, index, url}) {
    return axiosClient.delete('product/gallery/remove/', {
        params: {
            id,
            index,
            url
        }
    });
}

export function deleteProduct({commit}, id) {
    return axiosClient.delete(`/product/${id}`);
}

export function getCategory({commit}) {
    commit('setCategories', [true])
    return axiosClient.get('/category')
                .then(res => {
                    commit('setCategories', [false, res.data]);
                })
                .catch(() => {
                    commit('setCategories', [false]);
                })
}

export function getCategoryLists({commit}) {
    commit('setCategoryLists', [true])
    return axiosClient.get('/category-lists')
                .then(res => {
                    commit('setCategoryLists', [false, res.data]);
                })
                .catch(() => {
                    commit('setCategoryLists', [false]);
                })
}

export function createCategory({commit}, category) {
    return axiosClient.post('/category', category);
}

export function updateCategory({commit}, category) {
    return axiosClient.put(`/category/${category.id}`, category);
}

export function deleteCategory({commit}, id) {
    return axiosClient.delete(`/category/${id}`);
}

export function getTag({commit}) {
    return axiosClient.get('/tag')
                .then(res => {
                    commit('setTags', [ false, res.data]);
                })
                .catch(() => {
                    commit('setTags', [false]);
                })
}

export function createStock({commit}, stock) {
    if(stock.image instanceof File) {
        const form = new FormData();
        form.append('product_id', stock.productId);
        form.append('size', stock.size);
        form.append('color', JSON.stringify(stock.color)); //Must be Object String
        form.append('image', stock.image);
        form.append('stock', stock.stock);
        form.append('plus', stock.plus);
        form.append('extra_plus', stock.extraPlus);
        stock = form;
    } else {
        stock.product_id = stock.productId; // Transform to Request Validated Format for Backend
        delete stock.productId;
        stock.extra_plus = stock.extraPlus; // Transform to Request Validated Format for Backend
        delete stock.extraPlus;
        stock.color = stock.color ? JSON.stringify(stock.color) : stock.color;  // Transform to Request Validated Format for Backend
    }
    return axiosClient.post('/inventory', stock);
}
