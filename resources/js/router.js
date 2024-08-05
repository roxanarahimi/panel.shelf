import {createRouter, createWebHistory} from 'vue-router'


const routes = [
    //panel
    {
        path: "/panel",
        // name: "Home",
        component: () => import(/* webpackChunkName: "home" */ '../js/components/panel/Home'),
    },
    {
        path: "/panel/categories",
        //     component: () => import(/* webpackChunkName: "test" */ '../js/components/panel/product/Categories'),
        // name: "Categories",
        component: () => import(/* webpackChunkName: "Categories" */ '../js/components/panel/Categories'),
        props: true,
        params: true
    },
    {
        path: "/panel/priority/products",
        component: () => import(/* webpackChunkName: "productPriority" */  './components/panel/product/ProductsPriority'),
        name: "productPriority",
        params: true,
        props: true,
    },
    {
        path: "/panel/products",
        component: () => import(/* webpackChunkName: "productAllData" */  './components/panel/allData'),
        name: "productAllData",
        params: true,
        props: true,
    },
    {
        path: "/panel/new/product",
        name: "ProductCreate",
        component: () => import(/* webpackChunkName: "ProductCreate" */ '../js/components/panel/product/ProductCreate'),
        // component: ProductCreate,
        params: true
    },
    {
        path: "/panel/edit/product/:id",
        name: "ProductEdit",
        component: () => import(/* webpackChunkName: "ProductEdit" */ '../js/components/panel/product/ProductEdit'),
        params: true
    },
    {
        path: "/panel/product/:id",
        name: "Product",
        component: () => import(/* webpackChunkName: "Product" */ '../js/components/panel/product/Product'),
        params: true
    },
    {
        path: "/panel/skus",
        component: () => import(/* webpackChunkName: "skuAllData" */  './components/panel/allData'),
        name: "skuAllData",
        params: true,
        props: true,
    },
    {
        path: "/panel/new/sku",
        name: "SkuCreate",
        component: () => import(/* webpackChunkName: "SkuCreate" */ '../js/components/panel/sku/SkuCreate'),
        // component: ProductCreate,
        params: true
    },
    {
        path: "/panel/edit/sku/:id",
        name: "SkuEdit",
        component: () => import(/* webpackChunkName: "SkuEdit" */ '../js/components/panel/sku/SkuEdit'),
        params: true
    },
    {
        path: "/panel/sku/:id",
        name: "Sku",
        component: () => import(/* webpackChunkName: "Sku" */ '../js/components/panel/sku/Sku'),
        params: true
    },
    {
        path: "/panel/brands",
        component: () => import(/* webpackChunkName: "brandAllData" */ './components/panel/allData'),
        name: "brandAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/brand",
        name: "BrandCreate",
        component: () => import(/* webpackChunkName: "BrandCreate" */ '../js/components/panel/brand/BrandCreate'),
        params: true
    },
    {
        path: "/panel/edit/brand/:id",
        name: "BrandEdit",
        component: () => import(/* webpackChunkName: "BrandEdit" */ '../js/components/panel/brand/BrandEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/brand/:id",
        name: "Brand",
        component: () => import(/* webpackChunkName: "Brand" */ '../js/components/panel/brand/Brand'),
        params: true,
        props: true

    },

    {
        path: "/panel/provinces",
        component: () => import(/* webpackChunkName: "provinceAllData" */ './components/panel/allData'),
        name: "provinceAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/province",
        name: "ProvinceCreate",
        component: () => import(/* webpackChunkName: "ProvinceCreate" */ '../js/components/panel/province/ProvinceCreate'),
        params: true
    },
    {
        path: "/panel/edit/province/:id",
        name: "ProvinceEdit",
        component: () => import(/* webpackChunkName: "ProvinceEdit" */ '../js/components/panel/province/ProvinceEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/province/:id",
        name: "Province",
        component: () => import(/* webpackChunkName: "Province" */ '../js/components/panel/province/Province'),
        params: true,
        props: true

    },

    {
        path: "/panel/cities",
        component: () => import(/* webpackChunkName: "cityAllData" */ './components/panel/allData'),
        name: "cityAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/city",
        name: "CityCreate",
        component: () => import(/* webpackChunkName: "CityCreate" */ '../js/components/panel/city/CityCreate'),
        params: true
    },
    {
        path: "/panel/edit/city/:id",
        name: "CityEdit",
        component: () => import(/* webpackChunkName: "CityEdit" */ '../js/components/panel/city/CityEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/city/:id",
        name: "City",
        component: () => import(/* webpackChunkName: "City" */ '../js/components/panel/city/City'),
        params: true,
        props: true

    },

    {
        path: "/panel/regions",
        component: () => import(/* webpackChunkName: "regionAllData" */ './components/panel/allData'),
        name: "regionAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/region",
        name: "RegionCreate",
        component: () => import(/* webpackChunkName: "RegionCreate" */ '../js/components/panel/region/RegionCreate'),
        params: true
    },
    {
        path: "/panel/edit/region/:id",
        name: "RegionEdit",
        component: () => import(/* webpackChunkName: "RegionEdit" */ '../js/components/panel/region/RegionEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/region/:id",
        name: "Region",
        component: () => import(/* webpackChunkName: "Region" */ '../js/components/panel/region/Region'),
        params: true,
        props: true

    },
    {
        path: "/panel/sectors",
        component: () => import(/* webpackChunkName: "sectorAllData" */ './components/panel/allData'),
        name: "sectorAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/sector",
        name: "SectorCreate",
        component: () => import(/* webpackChunkName: "SectorCreate" */ '../js/components/panel/sector/SectorCreate'),
        params: true
    },
    {
        path: "/panel/edit/sector/:id",
        name: "SectorEdit",
        component: () => import(/* webpackChunkName: "SectorEdit" */ '../js/components/panel/sector/SectorEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/sector/:id",
        name: "Sector",
        component: () => import(/* webpackChunkName: "Sector" */ '../js/components/panel/sector/Sector'),
        params: true,
        props: true

    },
    {
        path: "/panel/customers",
        component: () => import(/* webpackChunkName: "customerAllData" */ './components/panel/allData'),
        name: "customerAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/customer",
        name: "CustomerCreate",
        component: () => import(/* webpackChunkName: "CustomerCreate" */ '../js/components/panel/customer/CustomerCreate'),
        params: true
    },
    {
        path: "/panel/edit/customer/:id",
        name: "CustomerEdit",
        component: () => import(/* webpackChunkName: "CustomerEdit" */ '../js/components/panel/customer/CustomerEdit'),
        props: true,
        params: true
    },
    {
        path: "/panel/customer/:id",
        name: "Customer",
        component: () => import(/* webpackChunkName: "Customer" */ '../js/components/panel/customer/Customer'),
        params: true,
        props: true

    },
    {
        path: "/panel/visitors",
        component: () => import(/* webpackChunkName: "visitorAllData" */ './components/panel/allData'),
        name: "visitorAllData",
        params: true,
        props: true
    },
    {
        path: "/panel/new/visitor",
        name: "VisitorCreate",
        component: () => import(/* webpackChunkName: "VisitorCreate" */ '../js/components/panel/visitor/VisitorCreate'),
        params: true
    },
    {
        path: "/panel/edit/visitor/:id",
        name: "VisitorEdit",
        component: () => import(/* webpackChunkName: "VisitorEdit" */ '../js/components/panel/visitor/VisitorEdit'),

        params: true
    },
    {
        path: "/panel/visitor/:id",
        name: "Visitor",
        component: () => import(/* webpackChunkName: "Visitor" */ '../js/components/panel/visitor/Visitor'),
        params: true
    },


    {
        path: "/panel/user/:id",
        name: "User",
        component: () => import(/* webpackChunkName: "User" */ '../js/components/panel/user/User'),
    },
    {
        path: "/panel/users",
        component: () => import(/* webpackChunkName: "userAllData" */  './components/panel/allData'),
        name: 'userAllData',
        params: true,
        props: true,

    },
    {
        path: "/panel/edit/user/:id",
        name: "UserEdit",
        component: () => import(/* webpackChunkName: "UserEdit" */ '../js/components/panel/user/UserEdit'),
        params: true
    },
    // {
    //     path: "/",
    //     name: 'Login0',
    //     component: Login,
    // },
    {
        path: "/panel/login",
        name: "Login",
        component: () => import(/* webpackChunkName: "Login" */ './components/panel/admin/Login'),
    },
    {
        path: "/panel/profile",
        name: "Profile",
        component: () => import(/* webpackChunkName: "Profile" */ './components/panel/admin/Profile'),

    },


    {
        path: "/panel/admins",
        component: () => import(/* webpackChunkName: "adminAllData" */  './components/panel/allData'),
        name: "adminAllData",
        params: true,
        props: true

    },


    {
        path: "/:catchAll(.*)",
        name: "Error404",
        component: () => import(/* webpackChunkName: "Error404" */  './components/panel/error/Error404'),

    } ,

];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router
