<template>
    <div class="my-3 px-3">
        <div v-if="pages>1" class="paginate text-center" dir="rtl">

            <nav v-if="labels.length < 11" class="d-flex justify-content-center ">
                <span class="paginate-btn" @click="nextPage()" :class="{'text-muted': currentPage >= pages, 'fw-bold pointer': currentPage < pages}">بعدی</span>
                <br class="d-md-none">
                <div>
                    <span :class="{'text-primary': item == currentPage}" :id="'page_'+item " v-for="item in labels" :key="item" @click="goToPage(item)" class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">
                        {{ item }}
                    </span>
                </div>
                <br class="d-md-none">
                <span class="paginate-btn" @click="prevPage()" :class="{'text-muted': (currentPage <= 1 ),  'fw-bold pointer': currentPage > 1}">قبلی</span>
            </nav>
            <nav v-else class="d-flex justify-content-center ">
                <span class="paginate-btn" @click="prevPage()" :class="{'text-muted': (currentPage <= 1 ),  'fw-bold pointer': currentPage > 1}">قبلی</span>
                <br class="d-md-none">
                <div>
                     <span :class="{'text-primary': currentPage == 1 }" :id="'page_1' "
                           @click="goToPage(1)"
                           class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">{{ 1 }}</span>

                    <!--                     <span  :class="{'text-primary': item == currentPage}" :id="'page_'+item "-->
                    <!--                            v-for="item in labels" :key="item" @click="goToPage(item)"-->
                    <!--                            class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">{{ item }}</span>-->


                    <span class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">...</span>

                    <span v-if="currentPage!=1 && currentPage != labels.length"
                          :class="{'text-primary': currentPage == currentPage }" :id="'page_'+currentPage "
                          @click="goToPage(currentPage)"
                          class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">{{ currentPage }}</span>


                    <span v-if="currentPage!=1 && currentPage != labels.length"
                          class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">...</span>


                    <span :class="{'text-primary': currentPage == labels.length }" :id="'page_'+labels.length "
                          @click="goToPage(labels.length)"
                          class="paginate-btn pointer fs-6 fw-bold page_number mx-3 ">{{ labels.length }}</span>
                </div>
                <br class="d-md-none">
                <span class="paginate-btn" @click="nextPage()" :class="{'text-muted': currentPage >= pages, 'fw-bold pointer': currentPage < pages}">بعدی</span>
            </nav>

            <!--        <p class="text-black-50 mt-2">{{ 'page ' + currentPage+'of' + pages}}</p>-->

        </div>

        <div class="d-flex justify-content-between">
            <div v-if="total != undefined" class="w-50 d-flex justify-content-start">
                <span class="float-lg-start text-black-50 mt-2">{{ 'نمایش ' }}</span>
                <select @change="load" id="perPage" style="width: 60px" class="form-select-sm mt-1 mx-2">
                    <!--                   <option value="5">5</option>-->
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option selected value="100">100</option>
                </select>
                <span class="text-black-50 mt-2">        {{ 'مورد از ' + total }}</span>
            </div>
            <div v-if="pages> 1" class="w-50 d-flex justify-content-end">
                <span class="text-black-50 mt-2">{{ 'صفحه ' + currentPage + ' از ' + pages }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import {onUpdated, ref} from "vue";

export default {
    props: ['page', 'pages', 'total', 'labels', 'load'],
    name: "Pagination",
    setup(props) {
        const currentPage = ref(1);
        const total_pages = ref(1);


        const goToPage = (i) => {
            if (0 < i <= total_pages.value) {
                currentPage.value = i;
                props.load(currentPage.value);
            }
        };
        const prevPage = () => {
            if (currentPage.value > 1) {
                currentPage.value -= 1;
                props.load(currentPage.value);


            }
        };
        const nextPage = () => {
            // console.log('props',props.pages);
            if (currentPage.value < props.pages) {
                currentPage.value += 1;
                props.load(currentPage.value);


            }
        };
        return {
            currentPage, total_pages, goToPage, prevPage, nextPage,
        }
    }
}
</script>

<style scoped>
.pointer {
    cursor: pointer !important;
}
</style>
