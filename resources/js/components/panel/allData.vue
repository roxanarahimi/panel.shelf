<template>
    <!--    <transition name="route" mode="out-in" appear>-->

    <all-data-container :model="model"
                        :title="title" :tooltip_new="tooltip_new">
        <h3 class="mb-5">{{ title }}
            <router-link v-if="tooltip_new" :to="'/panel/new/'+ model" class="text-dark">
                    <span :title="tooltip_new" class="px-3 d-inline-block align-middle"><i
                        class="bi bi-plus-circle-fill p-0 mt-2 m-0" style="font-size: 15px"></i></span>
            </router-link>
            <!--        <router-link v-if="this.$route.name == 'productAllData'" to="/panel/priority/products">-->
            <!--            <span  class=" d-inline-block align-middle bg-dark text-light rounded rounded-circle py-1 text-center"-->
            <!--                           style="width: 16px !important; height: 16px !important; overflow: hidden !important" title="اولویت">-->
            <!--            <i style="font-size: 10px !important; line-height: 10px; margin-top: -20px !important; " class="align-top bi bi-arrow-down-up m-0"></i>-->
            <!--        </span>-->
            <!--        </router-link>-->
        </h3>

        <loader/>

        <div v-if="this.$route.name !== 'formAllData'" class="mb-3 col-lg-6" :class="{'d-none': model === 'foodSlide'}">
            <label for="search" class="form-label">جستوجو</label>
            <input @input="loadData" type="text" class="form-control" id="search">
        </div>
        <div v-if="this.$route.name == 'formAllData'" class="mb-3 col-lg-6" :class="{'d-none': model === 'foodSlide'}">
            <label class="form-label" >بازه زمانی</label>
            <DatePicker v-model="dateRange" format="YYYY-MM-DD"/>
        </div>
        <div v-if="this.$route.name == 'formAllData'" class="mb-3 col-lg-6" :class="{'d-none': model === 'foodSlide'}">
            <label class="form-label" >  </label>
            <p class="mb-0" @click="downloadFile"><b>خروجی اکسل </b>
                <span style="cursor: pointer" title="دانلود"
                      class="mx-3 p-1 px-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                                <i class="bi bi-file-earmark-excel p-0 edit-pen"></i>
                            </span>
            </p>
        </div>
        <div class="col-12 mb-3" v-if="allData && allData.length">
            <Suspense>
                <component :is="model+'sTable'" :allData="allData" :page="page" :model="model" :loadData="loadData"/>
                <template #fallback>
                    <loader/>
                </template>
            </Suspense>
        </div>
        <pagination :page="page" :pages="pages" :total="total" :labels="labels" :load="loadData"/>

    </all-data-container>
    <!--    </transition>-->
</template>
<script>
import {ref, onMounted, onUpdated, onBeforeMount, watch} from 'vue';
import {useRoute} from "vue-router";

import Loader from "../components/Loader";
import AllDataContainer from "./AllDataContainer";
import Pagination from "../components/Pagination";

import productsTable from "./product/productsTable";
import usersTable from "./user/usersTable";
import adminsTable from "./admin/adminsTable";
import brandsTable from "./brand/brandsTable";
import visitorsTable from "./visitor/visitorsTable";

import provincesTable from "./province/provincesTable";
import citysTable from "./city/citysTable";
import regionsTable from "./region/regionsTable";
import sectorsTable from "./sector/sectorsTable";
import customersTable from "./customer/customersTable";
import skusTable from "./sku/skusTable";
import formsTable from "./form/formsTable";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import exportFromJSON from "export-from-json";

export default {
    components: {
        Loader, AllDataContainer, Pagination, productsTable, usersTable,
        adminsTable, brandsTable, visitorsTable,
        provincesTable, citysTable, regionsTable, sectorsTable, customersTable, skusTable,
        formsTable, DatePicker,
    },
    setup() {
        const model = ref();
        const title = ref('');
        const tooltip_new = ref('');
        const page = ref();
        const pages = ref();
        const total = ref();
        const labels = ref([]);
        const allData = ref([]);
        const dateRange = ref();

        const showDeleteModal = async (id) => {
            await AllDataContainer.setup().showDeleteModal(id);
        }
        const deleteInfo = async (model, id) => {
            await AllDataContainer.setup().deleteInfo(model, id);
            await loadData();
        };
        const activeToggle = async (model, id) => {
            await AllDataContainer.setup().activeToggle(model, id);
            await loadData(page.value);
        };
        const loadData = async (p) => {
            if (p === undefined) {
                page.value = 1;
            } else if (1 <= p && p <= pages.value) {
                page.value = p;
            }
            document.querySelector('#loader').classList.remove('d-none');

            let perPage = document.querySelector('#perPage')?.value || 100;
            let search = document.querySelector('#search')?.value || '';
            axios.get('/api/panel/' + model.value + '?page=' + page.value + '&perPage=' + perPage + '&search=' + search)
                .then((response) => {
                    // console.log(response)
                    allData.value = response.data.data;
                    pages.value = response.data.pages;
                    total.value = response.data.total;
                    labels.value = response.data.labels;
                    title.value = response.data.title;
                    tooltip_new.value = response.data.tooltip_new;
                    document.querySelector('#loader').classList.add('d-none');
                    if (pages.value > 1) {
                        document.querySelector('.paginate')?.classList.remove('d-none');
                    }
                    if (allData.value) {
                        document.querySelector('#loader').classList.add('d-none');
                        // setTimeout(() => {
                        //     document.querySelector('#msg').innerHTML = '<p class="fw-bold">موردی پیدا نشد</p>';
                        // }, 3000)
                    }
                }).catch();


            setTimeout(() => {
                document.querySelector('#loader')?.classList.add('d-none');
            }, 4000)
        };

        onUpdated(() => {
            model.value = useRoute().name.replace('AllData', '');
            allData.value = [];
            loadData();
            document.querySelector('.paginate')?.classList.add('d-none');
            // alert(model.value)
        });
        onBeforeMount(() => {
        });
        onMounted(() => {
            loadData();

        });

        const loadDataByDate= (p,per)=>{
                page.value = p;
            document.querySelector('#loader').classList.remove('d-none');
            let perPage = per;
            let search = document.querySelector('#search')?.value || '';
            axios.get('/api/panel/' + model.value + '?page=' + page.value + '&perPage=' + perPage + '&search=' + search + '&date=' + dateRange.value)
                .then((response) => {
                    // console.log(response)
                    allData.value = response.data.data;
                    pages.value = response.data.pages;
                    total.value = response.data.total;
                    labels.value = response.data.labels;
                    title.value = response.data.title;
                    tooltip_new.value = response.data.tooltip_new;
                    document.querySelector('#loader').classList.add('d-none');
                    if (pages.value > 1) {
                        document.querySelector('.paginate')?.classList.remove('d-none');
                    }
                    if (allData.value) {
                        document.querySelector('#loader').classList.add('d-none');
                        // setTimeout(() => {
                        //     document.querySelector('#msg').innerHTML = '<p class="fw-bold">موردی پیدا نشد</p>';
                        // }, 3000)
                    }
                }).catch();


            setTimeout(() => {
                document.querySelector('#loader')?.classList.add('d-none');
            }, 4000);
        }
        watch(dateRange, () => {
            loadDataByDate(1,document.querySelector('#perPage').value);
        }, { deep: true });

        const downloadFile=()=> {
            let list = [];
            if (allData.value){
                if (pages.value>1){
                        loadDataByDate(1,total.value);
                }
                allData.value.forEach((form)=>{
                    if (form) {
                        let i = 0;
                        form.sections.forEach((item) => {
                            let j = 0;
                            item.skus.forEach((sku) => {
                                let date = (i == 0 && j == 0) ? form.created_at : ''
                                let code = (i == 0 && j == 0) ? form.customer.code : ''
                                let name = (i == 0 && j == 0) ? form.customer.name : ''
                                let grade = (i == 0 && j == 0) ? form.customer.scores?.grade : ''
                                let visitor = (i == 0 && j == 0) ? form.visitor.name : ''
                                let space = j == 0 ? item.space : ''
                                let layout = j == 0 ? item.layout : ''
                                list.push({
                                    "تاریخ ثبت": date,
                                    "کد مشتری": code,
                                    "نام مشتری": name,
                                    "گرید": grade,
                                    "نام کارشناس": visitor,
                                    "sku": sku.sku.title,
                                    "تعداد در دیدرس": sku.face,
                                    " شدت حضور": sku.presence,
                                    "تاریخ انقضا": sku.expire_date,
                                    "قیمت بسته": sku.label_price,
                                    "قیمت فروش": sku.sale_price,
                                    "قیمت پخش": sku.distribute_price,
                                    "فضای تبلیغاتی": space,
                                    "چیدمان": layout,
                                });
                                j++;
                            })
                            i++;
                        })
                    }

                });

                const data = list;
                const fileName = 'report@'+dateRange.value;
                const exportType = exportFromJSON.types.xls;

                if (data) exportFromJSON({data, fileName, exportType});

            }
             }

        return {
            dateRange,loadDataByDate, downloadFile,
            model, title, tooltip_new, allData, page, pages, total, labels,
            loadData, showDeleteModal, deleteInfo, activeToggle
        };
    },

}
</script>
<style>
.date_cell {
    direction: ltr !important;
    text-align: right !important;
}

.text_cell {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 30ch;
}

.active_cell {
    width: 60px;
    text-align: center;
}


</style>
