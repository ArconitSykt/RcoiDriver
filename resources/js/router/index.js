import Vue from 'vue'
import Router from 'vue-router'
import AddForm from '../components/AddForm'
import Excel from '../components/Excel'

Vue.use(Router)

export default new Router({

    routes: [
        {
            path: '/',
            name: 'AddForm',
            component: AddForm
        },
        {
            path: '/excel',
            name: 'Excel',
            component: Excel
        },
    ]
})
