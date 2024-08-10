<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ویرایش محصول</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card" v-if="isDefined">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="name" class="form-label">نام</label>
                                        <input type="text" :class="{hasError: errors.name}" class="form-control"
                                               :value="data.name" id="name" aria-describedby="nameHelp" required>
                                        <div id="nameHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.name">{{ e }}</p>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="code" class="form-label">کد مشتری</label>
                                        <input type="text" :class="{hasError: errors.code}" class="en form-control"
                                               :value="data.code" id="code" aria-describedby="codeHelp" required>
                                        <div id="codeHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.code">{{ e }}</p>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="mobile" class="form-label">موبایل</label>
                                        <input type="text" :class="{hasError: errors.mobile}" class="form-control"
                                               :value="data.mobile" id="mobile" aria-describedby="mobileHelp" required>
                                        <div id="mobileHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.mobile">{{ e }}</p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="phone" class="form-label">تلفن</label>
                                        <input type="text" :class="{hasError: errors.phone}" class="form-control en"
                                               :value="data.phone" id="phone" aria-describedby="phoneHelp">
                                        <div id="phoneHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.phone">{{ e }}</p>
                                    </div>

                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="province" class="form-label">استان</label>
                                        <select class="form-select" id="province" aria-describedby="provinceHelp"
                                                aria-label="province" required>
                                            <option value=""></option>
                                            <option v-for="province in provinces" :key="province.id"
                                                    :value="province.id">
                                                {{ province.title }}
                                            </option>
                                        </select>
                                        <div id="provinceHelp" class="form-address error"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="city" class="form-label">شهر</label>
                                        <select class="form-select" id="city" aria-describedby="cityHelp"
                                                aria-label="city" required>
                                            <option value=""></option>
                                            <option :selected="data.city.id == city.id"
                                                    v-for="city in selectedProvince.cities" :key="city.id"
                                                    :value="city.id">
                                                {{ city.title }}
                                            </option>
                                        </select>
                                        <div id="cityHelp" class="form-address error"></div>
                                    </div>

                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="region" class="form-label">منطقه</label>
                                        <select class="form-select" id="region" aria-describedby="regionHelp"
                                                aria-label="region" required>
                                            <option value=""></option>
                                            <option :selected="data.region.id == region.id"
                                                    v-for="region in selectedCity.regions" :key="region.id"
                                                    :value="region.id">
                                                {{ region.title }}
                                            </option>
                                        </select>
                                        <div id="regionHelp" class="form-address error"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="sector" class="form-label">محله</label>
                                        <select class="form-select" id="sector" aria-describedby="sectorHelp"
                                                aria-label="sector" required>
                                            <option value=""></option>
                                            <option :selected="data.sector.id == sector.id"
                                                    v-for="sector in selectedRegion.sectors" :key="sector.id"
                                                    :value="sector.id">
                                                {{ sector.title }}
                                            </option>
                                        </select>
                                        <div id="sectorHelp" class="form-address error"></div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="address">آدرس</label>
                                        <textarea @input="watchTextAreas" :class="{hasError: errors.address}"
                                                  aria-describedby="addressHelp" class="form-control text-start"
                                                  id="address" required>{{ data.address }}</textarea>
                                        <div id="addressHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.address">{{ e }}</p>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit @click.prevent="updateInfo">
                                            ویرایش
                                        </BtnSubmit>
                                        <!--                                        <button id="submit" class="btn btn-primary d-flex justify-content-between" @click.prevent="updateInfo" type="submit">-->
                                        <!--                                             ویرایش <loader-sm class="loader-sm d-none" />-->
                                        <!--                                        </button>-->
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
import ImageCropper from '../../components/ImageCropper';
import App from '../App';
import BtnSubmit from "../../components/BtnSubmit";
import Multiselect from '@vueform/multiselect'


export default {
    components: {ImageCropper, App, BtnSubmit, Multiselect},
    data() {
        return {
            id: this.$route.params.id,
            data: {},
            provinces: [],
            selectedProvince: {},
            selectedCity: {},
            selectedRegion: {},
            selectedSector: {},
            errors: [],
            isDefined: false,
        }
    },

    created() {
        this.loadCustomer();
    },

    methods: {
        loadCustomer() {
            axios.get('/api/panel/customer/' + this.id)
                .then((response) => {
                    console.log(response.data);
                    this.data = response.data;
                })
                .then(() => {
                    this.isDefined = true;
                })
                .then(() => {
                    this.watchTextAreas();
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
                axios.post('/api/panel/customer/' + this.$route.params.id,
                    {
                        name: document.getElementById('name').value,
                        code: document.getElementById('code').value,
                        mobile: document.getElementById('mobile').value,
                        phone: document.getElementById('phone').value,
                        shop_name: document.getElementById('shop_name').value,
                        sector_id: document.getElementById('sector_id').value,
                        address: document.getElementById('address').value,
                    })
                    .then((response) => {
                        console.log('res', response);
                        if (response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/customer/' + this.id});
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
            this.data.name = document.getElementById('name').value,
                this.data.code = document.getElementById('code').value,
                this.data.mobile = document.getElementById('mobile').value,
                this.data.phone = document.getElementById('phone').value,
                this.data.shop_name = document.getElementById('shop_name').value,
                this.data.sector_id = document.getElementById('sector_id').value,
                this.data.address = document.getElementById('address').value
        },
        watchTextAreas() {
            let txt = document.querySelector("#text");
            txt.setAttribute("style", "height:" + (txt.scrollHeight + 20) + "px;overflow-y:hidden;");
            txt.addEventListener("input", changeHeight, false);

            function changeHeight() {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            }
        },
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

<style>
span i {
    cursor: pointer;
}

.en {
    direction: ltr !important;
    text-align: left !important;
}

.multiselect-tags-search {
    background-color: transparent !important;
}

.multiselect-tag {
    background-color: #0d6efd !important;
}

.multiselect.is-active {
    box-shadow: none !important;
}
</style>
