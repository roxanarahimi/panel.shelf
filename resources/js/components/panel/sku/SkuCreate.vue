<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت sku جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label for="title" class="form-label">عنوان</label>
                                        <input type="text" :class="{hasError: errors.title}" class="form-control"
                                               id="title" aria-describedby="titleHelp" required>
                                        <div id="titleHelp" class="form-text error"></div>
                                        <p class="form-text error m-0" v-for="e in errors.title">{{ e }}</p>

                                    </div>
                                    <div class="col-md-4 col-lg-4 mb-3">
                                        <label for="category" class="form-label">دسته</label>
                                        <select class="form-select" id="category" aria-describedby="categoryHelp"
                                                aria-label="category" required>
                                            <option value=""></option>
                                            <option v-for="category in categories" :key="category.id"
                                                    :value="category.id">
                                                {{ category.title }}
                                            </option>
                                        </select>
                                        <div id="categoryHelp" class="form-text error"></div>

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
            categories: [],
            errors: [],
        }
    },
    mounted() {
        this.loadCategories();
    },
    methods: {
        async loadCategories() {

            await axios.get('/api/panel/category/sku?page=1&perPage=100000')
                .then((response) => {
                    this.categories = response.data.data;
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
                await axios.post('/api/panel/sku', {
                    title: document.getElementById('title').value,
                    sku_category_id: document.getElementById('category').value,
                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/skus'});
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
