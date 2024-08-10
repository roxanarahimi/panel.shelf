<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ویرایش منطقه</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card" v-if="isDefined">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input @input="updateData" type="text" :class="{hasError: errors.title}"
                                               class="form-control"
                                               id="title" :value="data.title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="province" class="form-label">استان</label>
                                        <select  @change="updateData" class="form-select" id="province"
                                                aria-describedby="provinceHelp"
                                                aria-label="province" required>
                                            <option value=""></option>
                                            <option :selected="data.city.province_id == province.id"
                                                    v-for="province in provinces" :key="province.id"
                                                    :value="province">
                                                {{ province.title }}
                                            </option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="city_id" class="form-label">شهر</label>
                                        <select  @change="updateData" class="form-select" id="city_id"
                                                aria-describedby="city_idHelp"
                                                aria-label="city_id" required>
                                            <option value=""></option>
                                            <option :selected="data.city.id == city.id"
                                                    v-for="city in cities" :key="city.id"
                                                    :value="city.id">
                                                {{ city.title }}
                                            </option>
                                        </select>
                                        <div id="city_idHelp" class="form-text error"></div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit @click.prevent="updateInfo">
                                            ویرایش
                                        </BtnSubmit>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </transition>
</template>

<script>
import App from '../App';
import BtnSubmit from "../../components/BtnSubmit";


export default {
    components: {App, BtnSubmit},
    data() {
        return {
            id: this.$route.params.id,
            data: {},
            cities: [],
            provinces: [],
            selectedProvince: [],
            errors: [],
            isDefined: false,

        }
    },

    created() {
        this.loadProvinces();
        this.loadRegion();
    },

    methods: {
        loadRegion() {

            axios.get('/api/panel/region/' + this.id)
                .then((response) => {
                    this.data = response.data;
                    this.cities = response.data.province.cities;
                    console.log(this.cities)

                })
                .then(() => {
                    this.isDefined = true;
                })
                .catch();
        },
        loadProvinces() {
            axios.get('/api/panel/province?page=1&perPage=1000&search=')
                .then((response) => {
                    this.provinces = response.data.data;
                })
                .catch()
        },
        updateInfo() {


            this.errors = [];
            let emptyFieldsCount = 0;

            let req = document.querySelectorAll('[required]');
            req.forEach((element) => {
                if (element.value === "") {
                    element.classList.add('hasError');
                    element.nextSibling.innerHTML = "فیلد اجباری";
                    emptyFieldsCount++;
                } else {
                    element.classList.remove('hasError');
                    element.nextSibling.innerHTML = "";
                }
            });

            if (emptyFieldsCount === 0) {
                axios.post('/api/panel/region/' + this.$route.params.id,
                    {
                        id: this.$route.params.id,
                        title: document.getElementById('title').value,
                        city_id: document.getElementById('city_id').value,
                    })
                    .then((response) => {
                        console.log('res', response);
                        if (response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/region/' + this.id});
                            }, 1000);
                        }
                    })
                    .catch((error) => {
                        document.querySelector('#submit').removeAttribute('disabled');
                        document.querySelector('.loader-sm').classList.add('d-none');

                        if (error.response.status === 422) {
                            let errorList = Array(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors = errorList[i];
                            }

                        } else if (error.response.status === 500) {
                            if (error.response.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.response.data.message);
                                    }, 200);
                                }

                                showAlertSql();
                            } else {
                                function showAlert500() {
                                    setTimeout(() => {
                                        alert(error.message + ' '
                                            + error.response.data.message);
                                    }, 200);
                                }

                                showAlert500();
                            }

                        } else {
                            function showAlert() {
                                setTimeout(() => {
                                    alert(error.message);
                                }, 200);
                            }

                            showAlert();

                        }
                    });
            }
        },

        updateData() {
            this.data.title = document.getElementById('title').value;
            this.data.city_id = document.getElementById('city_id').value;
        },

    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

<style>
span i {
    cursor: pointer;
}

</style>
