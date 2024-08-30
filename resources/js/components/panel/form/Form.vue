<template>
    <transition name="route" mode="out-in" appear>
        <section class="" style="text-align: justify">
            <div class="row " v-if="data.id">
                <div class="col-12 ">
                    <div class="row px-3 ">
                        <div class="col-12 mb-3 ">
                            <div class="d-inline-block mt-5">
                                <h3 class="mb-2 fw-bold d-block">{{ data.name }}</h3>
                            </div>
                            <router-link :to="'/panel/edit/form/'+data.id" class="text-dark">
                <span title="ویرایش مشتری"
                      class="mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class="bi bi-pencil p-0 edit-pen"></i>
                </span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 my-5 ">
                        <p><b>کد مشتری </b><router-link :to="'/panel/customer/'+data.customer.id">{{ data.customer.code }}</router-link></p>
                        <p><b>نام مشتری </b>{{ data.customer.name }}</p>
                        <p><b>کارشناس </b><router-link :to="'/panel/visitor/'+data.visitor.id">{{ data.visitor.name }}</router-link></p>
                        <p><b>تاریخ ثبت فرم </b><span class="d-lg-inline-block en">{{ data.created_at }}</span></p>
                    </div>
                </div>
                <div class="row">
                        <div  class="card rounded h-100">
                            <div class="card-body p-md-5 ">
                                <table class="table table-responsive rounded mb-0">
                                    <thead>
                                    <tr class="">
                                        <th class="" >sku</th>
                                        <th class="text-center" >تعداد در دیدرس</th>
                                        <th class="text-center" >شدت حضور</th>
                                        <th class="en">تاریخ انقضا</th>
                                        <th class="en" >قیمت بسته</th>
                                        <th class="en" >قیمت فروش</th>
                                        <th class="en" >قیمت پخش</th>
                                        <th class="en">فضای تبلیغاتی</th>
                                        <th class="text-center" >چیدمان</th>
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
                                        <td class="en text-nowrap">{{ section.space }}</td>
                                        <td class="text-center">{{ section.layout }}</td>
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

export default {
    components: {App},
    data: function () {
        return {
            data: {},
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
    }
}
</script>
<style scoped>
th, td {
    padding: 10px;
    min-width: 100px;
}
</style>
