<template>
    <transition name="route" mode="out-in" appear>
        <section class="" style="text-align: justify">
            <div class="row " v-if="data.id">
                <div class="col-12 ">
                    <div class="row px-3 ">
                        <div class="col-12 mb-3 ">

                            <!--                            <div class="d-inline-block mt-5">-->
                            <!--                                <h3 class="mb-2 fw-bold d-block">{{ data.name }}</h3>-->
                            <!--                            </div>-->
                            <!--                            <router-link :to="'/panel/edit/form/'+data.id" class="text-dark">-->
                            <!--                <span title="ویرایش"-->
                            <!--                      class="mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">-->
                            <!--                    <i class="bi bi-pencil p-0 edit-pen"></i>-->
                            <!--                </span>-->
                            <!--                            </router-link>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 my-5 ">
                        <p><b>کد مشتری </b>
                            <router-link :to="'/panel/customer/'+data.customer.id">{{
                                    data.customer.code
                                }}
                            </router-link>
                        </p>
                        <p><b>نام مشتری </b>{{ data.customer.name }}</p>
                        <p><b>کارشناس </b>
                            <router-link :to="'/panel/visitor/'+data.visitor.id">{{ data.visitor.name }}</router-link>
                        </p>
                        <p><b>تاریخ ثبت فرم </b><span class="d-lg-inline-block en">{{ data.created_at }}</span></p>
                        <p class="mb-0" @click="downloadFile"><b>خروجی اکسل </b>
                            <span style="cursor: pointer" title="دانلود"
                                  class="mx-3 p-1 px-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                                <i class="bi bi-file-earmark-excel p-0 edit-pen"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="card rounded h-100">
                        <div class="card-body p-md-5 ">
                            <table class="table table-responsive rounded mb-0">
                                <thead>
                                <tr class="">
                                    <th class="">sku</th>
                                    <th class="text-center">تعداد در دیدرس</th>
                                    <th class="text-center">شدت حضور</th>
                                    <th class="en">تاریخ انقضا</th>
                                    <th class="en">قیمت بسته</th>
                                    <th class="en">قیمت فروش</th>
                                    <th class="en">قیمت پخش</th>
                                    <th class="en">فضای تبلیغاتی</th>
                                    <th class="text-center">چیدمان</th>
                                    <!--                                        <th class="text-center" >تصویر چیدمان</th>-->
                                </tr>
                                </thead>
                                <tbody class="border-bottom" v-for="(section,index) in data.sections" :key="index">
                                <tr v-for="(item,i) in section.skus" :key="i">
                                    <td class="text-nowrap">{{ item.sku.title }}</td>
                                    <td class="text-center text-nowrap">{{ item.face }}</td>
                                    <td class="text-center text-nowrap">{{ item.presence }}</td>
                                    <td class="en text-nowrap">{{ item.expire_date }}</td>
                                    <td class="en text-nowrap">{{ item.label_price }}</td>
                                    <td class="en text-nowrap">{{ item.sale_price }}</td>
                                    <td class="en text-nowrap">{{ item.distribute_price }}</td>
                                    <td class="text-center align-middle text-nowrap" v-if="i==0"
                                        :rowspan="section.skus.length">{{ section.space }}
                                    </td>
                                    <td class="text-center align-middle text-nowrap" v-if="i==0"
                                        :rowspan="section.skus.length">{{ section.layout }}
                                    </td>
                                    <!--                                        <td class="text-center align-middle text-nowrap" v-if="i===0" :rowspan="section.skus.length">-->
                                    <!--                                            <img v-if="section.image" :src="'https://webagent.ir/projects/ShelfMonitoring/panel.shelf/storage/app'+section.image" width="80px">-->
                                    <!--                                        </td>-->
                                </tr>
                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>

            </div>
            <div v-else><p class="fw-bold">این فرم موجود نیست</p></div>

        </section>

    </transition>

</template>

<script>
import App from '../App';
import exportFromJSON from "export-from-json";

export default {
    components: {App},
    data: function () {
        return {
            data: {},
            list: [],
            id: this.$route.params.id,
        }
    },
    mounted() {
        this.loadRegion();
    },
    methods: {
        async loadRegion() {

            await axios.get('/api/panel/form/' + this.id)
                .then((response) => {
                    this.data = response.data;
                });

        },
        downloadFile() {
            if (this.data) {
                let i = 0;
                this.data.sections.forEach((item) => {
                    let j = 0;
                    item.skus.forEach((sku) => {
                        let date = (i == 0 && j == 0) ? this.data.created_at : ''
                        let code = (i == 0 && j == 0) ? this.data.customer.code : ''
                        let name = (i == 0 && j == 0) ? this.data.customer.name : ''
                        let grade = (i == 0 && j == 0) ? this.data.customer.scores?.grade : ''
                        let visitor = (i == 0 && j == 0) ? this.data.visitor.name : ''
                        let space = j == 0 ? item.space : ''
                        let layout = j == 0 ? item.layout : ''
                        this.list.push({
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
            const data = this.list;
            const fileName = this.data.customer.code + '@' + this.data.created_at;
            const exportType = exportFromJSON.types.xls;

            if (data) exportFromJSON({data, fileName, exportType});
        }
    }
}
</script>
<style scoped>
th, td {
    padding: 10px;
    min-width: 100px;
}
</style>
