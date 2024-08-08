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
                            <router-link :to="'/panel/edit/customer/'+data.id" class="text-dark">
                <span title="ویرایش مشتری" class="mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class="bi bi-pencil p-0 edit-pen"></i>
                </span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 my-5 ">
                        <p><b>نام </b>{{ data.name }}</p>
                        <p><b>کد مشتری </b>{{ data.code }}</p>
                        <p><b>موبایل </b>{{ data.mobile }}</p>
                        <p><b>تلفن </b>{{ data.phone }}</p>

                        <p><b>ادرس </b>{{ data.address }}</p>
                        <p><b>منطقه </b>{{ data.region?.title }}</p>
                        <p><b>نام مسیر </b>{{ data.path }}</p>
                        <p><b>کد مسیر </b>{{ data.path_code }}</p>
                        <p><b>توصیحات مسیر </b>{{ data.path_description }}</p>
                        <p><b>محله </b>{{ data.sector?.title }}</p>
                        <p><b>شهر </b>{{ data.city?.title }}</p>
                        <p><b>استان </b>{{ data.province?.title }}</p>
                    </div>
                </div>

            </div>
            <div v-else><p class="fw-bold">این مشتری موجود نیست</p></div>

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

            await axios.get('/api/panel/customer/' + this.id)
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
