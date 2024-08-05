<template>
    <transition name="route" mode="out-in" appear>
        <section class="" style="text-align: justify">
            <div class="row " v-if="data.id">
                <div class="col-12 ">
                    <div class="row px-3 ">
                        <div class="col-12 mb-3 ">
                            <div class="d-inline-block mt-5">
                                <h3 class="mb-2 fw-bold d-block">{{ 'شهر '+data.title }}</h3>
                            </div>
                            <router-link :to="'/panel/edit/city/'+data.id" class="text-dark">
                <span title="ویرایش شهر"
                      class="mx-3 p-2 d-inline-block align-middle bg-dark text-light rounded-circle">
                    <i class="bi bi-pencil p-0 edit-pen"></i>
                </span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 mb-5 ">
                        <b class="mb-2 fw-bold d-block">{{ 'استان: '+data.province.title }}</b>
                        <b class="d-block mt-4">منطقه ها</b>
                        <ul>
                            <li v-for="item in data.regions"><router-link :to="'/panel/region/'+item.id">{{ item.title }}</router-link></li>
                        </ul>

                    </div>
                </div>

            </div>
            <div v-else><p class="fw-bold">این شهر موجود نیست</p></div>

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
        this.loadProvince();
    },
    methods: {
        async loadProvince() {

            await axios.get('/api/panel/city/' + this.id)
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
