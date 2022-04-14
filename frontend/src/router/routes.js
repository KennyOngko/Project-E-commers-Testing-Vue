/* eslint-disable */
import MainLayout from "layouts/MainLayout";
import AdminLayout from "layouts/AdminLayout";
const register = () => import('pages/register.vue')
const login = () => import('pages/login.vue')
const landingPage = () => import('pages/landingPage.vue')
const addCategory = () => import('pages/addCategory.vue')
const manageProduct = () => import('pages/manageProduct.vue')
const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { 
        path: '/register', 
        component: register,
        meta: {
          title: 'register'
        }
      },      
      { 
        path: '/login', 
        component: login,
        meta: {
          title: 'login'
        }
      },
      { 
        path: '', 
        component: landingPage,
        meta: {
          title: 'landingPage'
        }
      },
    ]
  },
//admin
  {
    path: '/',
    component: AdminLayout,
    children: [    
      { 
        path: '/admin/AddCategory', 
        component: addCategory,
        meta: {
          title: 'addCategory'
        }
      },
      { 
        path: '/admin/manageProduct', 
        component: manageProduct,
        meta: {
          title: 'manageProduct'
        }
      },
      { 
        path: '/login', 
        component: login,
        meta: {
          title: 'login'
        }
      },
      { 
        path: '', 
        component: landingPage,
        meta: {
          title: 'landingPage'
        }
      },
    ]
  },


  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
