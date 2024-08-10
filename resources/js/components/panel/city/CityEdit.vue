<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ویرایش شهر</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card" v-if="isDefined">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input @input="updateData" type="text" :class="{hasError: errors.title}"
                                               class="form-control"
                                               id="title" :value="data.title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="province_id" class="form-label">استان</label>
                                        <select @change="updateData" class="form-select" id="province_id"
                                                aria-describedby="provinceHelp"
                                                aria-label="province" >
                                            <option value=""></option>
                                            <option :selected="data.province.id == province.id"
                                                    v-for="province in provinces" :key="province.id"
                                                    :value="province.id">
                                                {{ province.title }}
                                            </option>
                                        </select>
                                        <div id="provinceHelp" class="form-text error"></div>
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
            provinces: [],
            errors: [],
            isDefined: false,

        }
    },

    created() {
        this.loadProvinces();
        this.loadCity();
    },

    methods: {
        loadCity() {

            axios.get('/api/panel/city/' + this.id)
                .then((response) => {
                    console.log(response.data);
                    this.data = response.data;
                })
                .then(() => {
                    this.isDefined = true;
                })

                .catch();
        },
        loadProvinces() {
            axios.get('/api/panel/province?page=1&perPage=100000')
                .then((response) => {
                    this.provinces = response.data.data;
                })
                .catch();
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
                // let features = [];
                // for (let i = 0; i < document.getElementsByName('featureLabel').length; i++) {
                //     features.push('{"label": "' + document.getElementsByName('featureLabel')[i].value + '",' + ' "value": "' + document.getElementsByName('featureValue')[i].value + '", "unit": "' + document.getElementsByName('featureUnit')[i].value + '"}');
                // }
                // if (document.getElementsByName('featureLabel').length === 0) {
                //     features = '[]';
                // } else {
                //     features = '[' + features.toString() + ']';
                // }
                let selectedProducts = [];
                    this.value.forEach((element)=>{
                        selectedProducts.push(element.value)
                    });

                axios.post('/api/panel/city/' + this.$route.params.id,
                    {
                        id: this.$route.params.id,
                        title: document.getElementById('title').value,
                        province_id: document.getElementById('province_id').value,
                    })
                    .then((response) => {
                        console.log('res', response);
                        if (response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/city/' + this.id});
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
            this.data.province_id = document.getElementById('province_id').value;
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
