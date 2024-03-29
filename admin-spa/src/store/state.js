const state = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        data: {}
    },
    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },
    category: {
        loading: false,
        data: []
    },
    categories: {
        loading: false,
        data: [],
        primary: [],
        sub: [],
        child: [],
    },
    tag: {
        loading: false,
        data: []
    }
}

export default state
