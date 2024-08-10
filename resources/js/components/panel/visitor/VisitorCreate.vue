<template>
    <transition name="route" mode="out-in" appear>
        <section>
            <h3 class="mb-5">ثبت کارشناس جدید</h3>

            <div class="row mt-3">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="editForm">
                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label for="name" class="form-label">نام</label>
                                        <input type="text" :class="{hasError: errors.name}" class="form-control"
                                               id="name" aria-describedby="nameHelp" required>
                                        <div id="nameHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.name">{{ e }}</p>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="mobile" class="form-label">موبایل</label>
                                        <input type="text" :class="{hasError: errors.mobile}" class="form-control"
                                               id="mobile" aria-describedby="mobileHelp" required>
                                        <div id="mobileHelp" class="form-address error"></div>
                                        <p class="form-address error m-0" v-for="e in errors.mobile">{{ e }}</p>
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
import App from '../App';
import BtnSubmit from "../../components/BtnSubmit";


export default {
    components: { BtnSubmit, App},
    data: function () {
        return {
            errors: [],

        }
    },
    mounted() {

    },
    methods: {

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
                await axios.post('/api/panel/visitor', {
                    name: document.getElementById('name').value,
                    mobile: document.getElementById('mobile').value,

                })
                    .then((response) => {
                        console.log(response.data)
                        if (response.status === 201 || response.status === 200) {
                            setTimeout(() => {
                                this.$router.push({path: '/panel/visitors'});
                            }, 1000);
                        }
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            let errorList = Array(error.response.data);
                            for (var i = 0; i < errorList.length; i++) {
                                this.errors=errorList[i];
                            }
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
