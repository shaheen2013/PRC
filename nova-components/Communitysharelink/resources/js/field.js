Nova.booting((Vue, router, store) => {
    Vue.component('index-communitysharelink', require('./components/IndexField'))
    Vue.component('detail-communitysharelink', require('./components/DetailField'))
    Vue.component('form-communitysharelink', require('./components/FormField'))
})
