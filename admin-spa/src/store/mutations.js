export function setUser(state, user) {
    state.user.data = user;
}

export function setToken(state, token) {
    state.user.token = token;
    if(token) {
        sessionStorage.setItem('TOKEN', token);
    } else {
        sessionStorage.removeItem('TOKEN');
    }
}

export function setProducts(state, [loading, response = null]) {
    if(response) {
        state.products = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.page
        }
    }
    state.products.loading = loading;
}

export function setCategories(state, [loading, response=null]) {
    if(response) {
        state.category.data = response.data;
    }
    state.category.loading = loading;
}

export function setCategoryLists(state, [loading, response=null]) {
    if(response) {
        state.categories.data = response.data;
        state.categories.primary = response.data.filter(item => item.nested === 0);
        state.categories.sub = response.data.filter(item => item.nested === 1);
        state.categories.child = response.data.filter(item => item.nested === 2);
    }
    state.categories.loading = loading;
}

export function setTags(state, [loading, response=null]) {
    if(response) {
        state.tag.data = response.data;
    }
    state.category.loading = loading;
}
