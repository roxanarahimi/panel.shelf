<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ویرایش کارشناس</h3>

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
                                        <label for="mobile" class="form-label">موبایل</label>
                                        <input type="text" :class="{hasError: errors.mobile}" class="form-control"
                                               :value="data.mobile" id="mobile" aria-describedby="mobileHelp" required>
                                        <div id="mobileHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.mobile">{{ e }}</p>
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
            errors: [],
            isDefined: false,
            enableClick: true,

        }
    },

    created() {
        this.loadVisitor();
    },

    methods: {
        loadVisitor() {

            axios.get('/api/panel/visitor/' + this.id)
                .then((response) => {
                    console.log(response.data);
                    this.data = response.data;
                    if (this.data.sizes && this.data.sizes.length) {
                        this.sizes = this.data.sizes;
                    }
                    if (this.data.images) {
                        this.images = this.data.images;
                    }
                })
                .then(() => {
                    this.isDefined = true;
                })
                .then(() => {
                    this.value = this.data.related_visitors;
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
                axios.post('/api/panel/visitor/' + this.$route.params.id,
                    {
                        id: this.$route.params.id,
                        name: document.getElementById('name').value,
                        mobile: document.getElementById('mobile').value,
                    })
                    .then((response) => {
                        console.log('res', response);
                        if (response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/visitor/' + this.id});
                            }, 1000);
                        }
                    })
                    .catch((error) => {
                        document.querySelector('#submit').removeAttribute('disabled');
                        document.querySelector('.loader-sm').classList.add('d-none');

                        if (error.response.status === 422) {
                            let errorList = Array(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors= errorList[i] ;
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
            this.data.name = document.getElementById('name').value;
            this.data.mobile = document.getElementById('mobile').value;
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
