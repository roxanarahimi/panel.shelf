<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت مشتری جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">نام</label>
                                        <input type="text" :class="{hasError: errors.name}" class="form-control"
                                               id="name" aria-describedby="nameHelp" required>
                                        <div id="nameHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.name">{{ e }}</p>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="code" class="form-label">کد مشتری</label>
                                        <input type="text" :class="{hasError: errors.code}" class="en form-control"
                                               id="code" aria-describedby="codeHelp" required>
                                        <div id="codeHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.code">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="shop_name" class="form-label">نام فروشگاه</label>
                                        <input type="text" :class="{hasError: errors.shop_name}" class="form-control"
                                               id="shop_name" aria-describedby="shop_nameHelp" required>
                                        <div id="shop_nameHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.shop_name">{{ e }}</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mobile" class="form-label">موبایل</label>
                                        <input type="text" :class="{hasError: errors.mobile}" class="form-control"
                                               id="mobile" aria-describedby="mobileHelp" required>
                                        <div id="mobileHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.mobile">{{ e }}</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">تلفن</label>
                                        <input type="text" :class="{hasError: errors.phone}" class="form-control en"
                                               id="phone" aria-describedby="phoneHelp" >
                                        <div id="phoneHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.phone">{{ e }}</p>
                                    </div>

                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="province" class="form-label">استان</label>
                                        <select v-model="selectedProvince" class="form-select" id="province" aria-describedby="provinceHelp"
                                                aria-label="province" required>
                                            <option value=""></option>
                                            <option v-for="province in provinces" :key="province.id"
                                                    :value="province">
                                                {{ province.title }}
                                            </option>
                                        </select>
                                        <div id="provinceHelp" class="form-address error"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="city" class="form-label">شهر</label>
                                        <select v-model="selectedCity" class="form-select" id="city" aria-describedby="cityHelp"
                                                aria-label="city" required>
                                            <option value=""></option>
                                            <option v-for="city in selectedProvince.cities" :key="city.id"
                                                    :value="city">
                                                {{ city.title }}
                                            </option>
                                        </select>
                                        <div id="cityHelp" class="form-address error"></div>
                                    </div>

                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="region" class="form-label">منطقه</label>
                                        <select v-model="selectedRegion" class="form-select" id="region" aria-describedby="regionHelp"
                                                aria-label="region" required>
                                            <option value=""></option>
                                            <option v-for="region in selectedCity.regions" :key="region.id"
                                                    :value="region">
                                                {{ region.title }}
                                            </option>
                                        </select>
                                        <div id="regionHelp" class="form-address error"></div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="sector_id" class="form-label">محله</label>
                                        <select class="form-select" id="sector_id" aria-describedby="sector_idHelp"
                                                aria-label="sector_id" required>
                                            <option value=""></option>
                                            <option v-for="sector in selectedRegion.sectors" :key="sector.id"
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
                                                  id="address" required></textarea>
                                        <div id="addressHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.address">{{ e }}</p>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <BtnSubmit @click.prevent="createInfo">
                                            ثبت
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
import ImageCropper from '../../components/ImageCropper';
import App from '../App';
import BtnSubmit from "../../components/BtnSubmit";
import Multiselect from '@vueform/multiselect'


export default {
    components: {ImageCropper, BtnSubmit, App, Multiselect},
    data: function () {
        return {
            id: '',
            provinces: [],
            selectedProvince: {},
            selectedCity: {},
            selectedRegion: {},
            selectedSector: {},
            errors: [],
        }
    },
    mounted() {
        this.loadProvinces();
    },
    methods: {
        async loadProvinces() {
            await axios.get('/api/panel/province?page=1&perPage=100000')
                .then((response) => {
                    this.provinces = response.data.data;
                }).catch();
        },
        async createInfo() {
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
                await axios.post('/api/panel/customer', {
                    name: document.getElementById('name').value,
                    code: document.getElementById('code').value,
                    mobile: document.getElementById('mobile').value,
                    phone: document.getElementById('phone').value,
                    shop_name: document.getElementById('shop_name').value,
                    sector_id: document.getElementById('sector_id').value,
                    address: document.getElementById('address').value,
                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/customers'});
                            }, 1000);

                            console.log(response)
                        }
                    })
                    .catch((error) => {
                        // console.log(error);
                        // console.log(error.message);
                        // console.log(error.response.data);

                        if (error.status === 422) {
                            let errorList = Array(error.response.data);
                            // console.log(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                //  console.log('i',errorList[i]);
                                this.errors = errorList[i];
                            }
                            console.log(this.errors.toString());
                        } else if (error.status === 500) {
                            if (error.data.message.includes("SQLSTATE")) {
                                console.error('خطای پایگاه داده');

                                async function showAlertSql() {
                                    setTimeout(() => {
                                        alert(error.data.message);
                                    }, 200);
                                }

                                showAlertSql();
                            } else {
                                async function showAlert500() {
                                    setTimeout(() => {
                                        alert(error.message + ' '
                                            + error.data.message);
                                    }, 200);
                                }

                                showAlert500();
                            }
                        } else {

                            async function showAlert() {
                                setTimeout(() => {
                                    alert(error.message);
                                }, 200);
                            }

                            showAlert();
                        }

                    })
            }

            if (error && error.status && error.status === 401) {
                window.location = '/panel/login'
                App.methods.logout();
            }



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

.multiselect-tags-search{
    background-color: transparent !important;
}
.multiselect-tag{
    background-color: #0d6efd !important;
}
.multiselect.is-active
{
    box-shadow: none !important;
}
</style>
