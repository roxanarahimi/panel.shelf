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
                        <p><b>کد مشتری </b>{{ data.customer.code }}</p>
                        <p><b>کارشناس </b>{{ data.visitor.name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div v-for="item in data.sections" class="col-6 col-md-4">
                        <div  class="card rounded h-100">
                            <div class="card-body p-md-5 ">
                              <div class="d-flex justify-content-between">
                                  <p><b>نوع محصول </b>{{ item.skuCategory.title }}</p>
                                  <p><b>برند </b>{{ item.brand.title }}</p>
                              </div>
                              <div class="d-flex justify-content-between">
                                  <p><b>فضای تبلیغاتی </b>{{ item.space }}</p>
                                  <p><b>چیدمان </b>{{ item.layout }}</p>
                              </div>
                                <p><b>sku های موجود </b></p>
                                <ul>
                                    <li v-for="sku in item.skus">{{ sku.sku.title }}</li>
                                </ul>

                                <div class="">
                                    <p><b>تعداد در دیدرس </b>{{ item.face }}</p>
                                    <p><b>شدت حضور </b>{{ item.presence }}</p>
                                    <p><b>تاریخ انقضا </b><span class="d-inline-block en">{{ item.expire_date }}</span></p>
                                    <p><b> قیمت بسته بندی</b>{{ item.label_price }}</p>
                                    <p><b> قیمت فروش </b>{{ item.sale_price }}</p>
                                    <p><b>قیمت پخش </b>{{ item.distribute_price }}</p>
                                </div>
                            </div>


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
