<template>
    <card class="flex flex-row items-center justify-center">
        <div class="px-3 py-3">
            <button v-if="filtersAreApplied && !filterSaveButtonClicked && !sameFilters" @click="toggleFilterSaveButton"
                    class="btn bg-30 hover:bg-40 rounded p-3">
                Save
            </button>
            <input v-else-if="filtersAreApplied && !sameFilters && filterSaveButtonClicked" v-on:keyup.enter.once="saveCurrentFilter" v-model="savedFilterTitle"
                   class="border border-40 rounded w-full py-2 px-3 text-gray-700" id="filterName" type="text"
                   placeholder="Name of Filter" autofocus>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="chosenSavedFilter" :options="savedFilters" :multiple="false" :search="false"
                         :close-on-select="true" :clear-on-select="true" :preserve-search="false"
                         placeholder="Saved Filters" label="label" track-by="id"
                         :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="filterValues.partnerStat" :options="partnerStatOptions" :multiple="true" :close-on-select="false"
                         :clear-on-select="false" :preserve-search="true" placeholder="Partner Status" label="label"
                         track-by="id" :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3" style="text-align: center;">
            <multiselect v-model="filterValues.salesCycle" :options="salesCycleOptions" :multiple="false" :close-on-select="true"
                         :clear-on-select="false" :preserve-search="true" placeholder="Programm Updates" label="label"
                         track-by="id" :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="filterValues.size" :options="sizeOptions" :multiple="true" :close-on-select="false"
                         :clear-on-select="false" :preserve-search="true" placeholder="Community Size" label="label"
                         track-by="id" :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div v-if="stateOptions !== []" class="px-3 py-3">
            <multiselect v-model="filterValues.state" :options="stateOptions" :multiple="false" :close-on-select="true"
                         :clear-on-select="false" :preserve-search="true" placeholder="State" label="label"
                         track-by="id" :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="filterValues.county" :options="countyOptions" :multiple="false"
                         :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="County"
                         label="label" track-by="id" :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3" style="text-align: center;">
            <label class="switch">
                <input type="checkbox" v-model="filterValues.or">
                <span class="slider round"><span class="switchText switchTextR">And</span>
                <span class="switchText switchTextL" style="display:none">Or</span></span>
            </label>
        </div>
        <div class="flex flex-row items-center justify-center">
            <label for="bulkId"></label>
            <transition name="fade" mode="out-in">
                <button v-if="!bulkButtonClicked" @click="toggleBulkIdButton" class="btn bg-30 hover:bg-40 rounded p-3">
                    Bulk Id
                </button>
                <textarea v-else v-model.lazy="bulkIdText" name="bulkIdFilter" id="bulkId" cols="8"
                          rows="2" class="border border-40">
                </textarea>
            </transition>
        </div>
        <div class="px-3 py-3">
            <button @click="resetFilters" v-if="filtersAreApplied"
                    class="btn bg-30 hover:bg-40 rounded p-3">
                Reset
            </button>
        </div>
    </card>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import $ from '../../../../CommunitySummary/resources/static/js/jquery-2.2.4.min';

    export default {
        props: {
            card: {
                required: true,
            },
            resourceName: {
                type: String,
                required: true,
            }
        },
        components: {Multiselect},
        data: function () {
            return {
                chosenSavedFilter: [],
                savedFilters: [],
                savedFilterTitle: "",
                filterSaveButtonClicked: false,
                bulkButtonClicked: false,
                filters: [
                    {
                        class: "App\\Nova\\Filters\\CommunityRentalSalesStatus",
                        value: {
                            value: false,
                            orActive: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityVacantSalesStatus",
                        value: {
                            value: false,
                            orActive: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityForeclosureSalesStatus",
                        value: {
                            value: false,
                            orActive: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunitySize",
                        value: {
                            0: false,
                            1: false,
                            2: false,
                            3: false,
                            4: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityState",
                        value: {
                            value: "",
                            orActive: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityCounty",
                        value: ""
                    },
                    {
                        class: "App\\Nova\\Filters\\RelationshipManager",
                        value: ""
                    },
                    {
                        class: "Prochamps\\BulkId\\BulkId",
                        value: ""
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityOrFilter",
                        value: {
                            rental: false,
                            vacant: false,
                            foreclosure: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunitySalesCycle",
                        value: 0
                    }
                ],
                filterValues: {
                    rental: false,
                    vacant: false,
                    foreclosure: false,
                    size: [],
                    state: [],
                    county: [],
                    or: false,
                    partnerStat: [],
                    salesCycle: [],
                },
                blankFilterValues: {
                    rental:false,
                    vacant: false,
                    foreclosure: false,
                    size: [],
                    state: [],
                    county: [],
                    or: false,
                    partnerStat: [],
                    salesCycle: [],
                },
                sizeOptions: [
                    {id: 0, label: 'X-Small'},
                    {id: 1, label: 'Small'},
                    {id: 2, label: 'Medium'},
                    {id: 3, label: 'Large'},
                    {id: 4, label: 'X-Large'},
                ],
                partnerStatOptions: [
                    {id: 2, label: 'Foreclosure'},
                    {id: 1, label: 'Vacant'},
                    {id: 3, label: 'RT Rental:'},
                    {id: 4, label: 'ST Rental:'},
                ],
                salesCycleOptions: [],
                stateOptions: [],
                countyOptions: [],
                disableWatch: false,
                bulkIdText: ""
            }
        },
        watch: {
            'chosenSavedFilter': function (val) {
                window.open('/admin/resources/c-m-communities?c-m-communities_filter=' + val.filter);
            },
            'bulkIdText': function (val) {
                this.filters[7].value = val;
                if (val === "") {
                    this.bulkButtonClicked = false;
                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.salesCycle': function(val) {
                console.log('filterValues.salesCycle',val);
                if(val){
                    this.filters[9].value = val.id;
                }else{
                    this.filters[9].value = 0;
                }

                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.or': function (val) {
                if(val){
                    console.log('Here If');
                    $('.switchTextL').show('slow');
                    $('.switchTextR').hide('fast');

                    this.filters[8].value['rental'] = this.filters[0].value.value;
                    this.filters[8].value['vacant'] = this.filters[1].value.value;
                    this.filters[8].value['foreclosure'] = this.filters[2].value.value;
                    this.filters[0].value['orActive'] = true;
                    this.filters[1].value['orActive'] = true;
                    this.filters[2].value['orActive'] = true;

                    if(this.filters[4].value['value'] != ''){
                        this.filters[4].value['value'] = this.filters[4].value.value;
                        this.filters[4].value['orActive'] = true;
                    }
                }else{
                    console.log('Here else');
                    $('.switchTextL').hide('fast');
                    $('.switchTextR').show('slow');

                    this.filters[8].value['rental'] = false;
                    this.filters[8].value['vacant'] = false;
                    this.filters[8].value['foreclosure'] = false;
                    this.filters[0].value['orActive'] = false;
                    this.filters[1].value['orActive'] = false;
                    this.filters[2].value['orActive'] = false;
                    if(this.filters[5].value['value'] != ''){
                        this.filters[4].value['value'] = "";
                        this.filters[4].value['orActive'] = false;
                    }
                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.partnerStat': function (val, old) {
                if(Object.keys(val)){
                    const selIds = val.map(arr => arr.id);
                    if (selIds.includes(2)) {
                        this.filters[2].value.value = true;
                        this.filterValues.or = true;
                        
                        this.filters[8].value['rental'] = this.filters[0].value.value;
                        this.filters[8].value['vacant'] = this.filters[1].value.value;
                        this.filters[8].value['foreclosure'] = this.filters[2].value.value;

                        this.filters[0].value['orActive'] = true;
                        this.filters[1].value['orActive'] = true;
                        this.filters[2].value['orActive'] = true;
                    } else {
                        this.filters[2].value.value = false;
                        this.filterValues.or = true;

                        this.filters[8].value['foreclosure'] = false;
                        this.filters[2].value['orActive'] = true;
                    }
                    if (selIds.includes(1)) {
                        this.filters[1].value.value = true;
                        this.filterValues.or = true;

                        this.filters[8].value['rental'] = this.filters[0].value.value;
                        this.filters[8].value['vacant'] = this.filters[1].value.value;
                        this.filters[8].value['foreclosure'] = this.filters[2].value.value;

                        this.filters[0].value['orActive'] = true;
                        this.filters[1].value['orActive'] = true;
                        this.filters[2].value['orActive'] = true;
                    } else {
                        this.filters[1].value.value = false;
                        this.filterValues.or = true;

                        this.filters[8].value['vacant'] = false;
                        this.filters[1].value['orActive'] = true;
                    }
                    if (selIds.includes(3)) {
                        this.filters[0].value.value = true;
                        this.filterValues.or = true;

                        this.filters[8].value['rental'] = this.filters[0].value.value;
                        this.filters[8].value['vacant'] = this.filters[1].value.value;
                        this.filters[8].value['foreclosure'] = this.filters[2].value.value;

                        this.filters[0].value['orActive'] = true;
                        this.filters[1].value['orActive'] = true;
                        this.filters[2].value['orActive'] = true;
                    } else {
                        this.filters[0].value.value = false;
                        this.filterValues.or = true;

                        this.filters[8].value['rental'] = false;
                        this.filters[0].value['orActive'] = true;
                    }
                    // if(selIds.includes(4)){
                    //     this.filters[0].value.value = true;
                    //     this.filterValues.or = false
                    // }
                    // else{
                    //     this.filters[0].value.value = false;
                    //     this.filterValues.or = false
                    // }

                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.rental': function (val) {
                this.clearRentalFilters();
                if(val){
                    this.filters[0].value.value = true;
                    this.filterValues.or = false
                }
                else{
                    this.filters[0].value.value = false;
                    this.filterValues.or = false
                }

                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.vacant': function (val) {
                this.clearVacantFilters();
                if(val){
                    this.filters[1].value.value = true;
                    this.filterValues.or = false
                }
                else{
                    this.filters[1].value.value = false;
                    this.filterValues.or = false
                }

                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.foreclosure': function (val) {
                this.clearForeclosureFilters();
                if(val){
                    this.filters[2].value.value = true;
                    this.filterValues.or = false
                }
                else{
                    this.filters[2].value.value = false;
                    this.filterValues.or = false
                }

                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.size': function (val) {
                this.clearSizeFilters();
                for (let filter of val) {
                    this.filters[3].value[filter.id] = true
                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.state': function (val, oldval) {
                if (!this.disableWatch) {

                    this.filters[4].value['value'] = val ? val.id : null;
                    this.filters[4].value['orActive'] = true;
                    this.filterValues.or = true;
                    if (!val) {
                        this.filters[5].value.value = "";
                        this.countyOptions = [];

                        this.filters[4].value['value'] = '';
                        this.filters[4].value['orActive'] = false;
                        this.filterValues.or = false;
                    }
                    this.$router.push({
                        path: '/resources/c-m-communities',
                        query: {'c-m-communities_filter': this.encodedFilter}
                    })
                }

                this.loadCounties(val ? val.id : null);
            },
            'filterValues.county': function (val) {
                if (!this.disableWatch) {
                    this.filters[5].value = val ? val.id : null;
                    this.$router.push({
                        path: '/resources/c-m-communities',
                        query: {'c-m-communities_filter': this.encodedFilter}
                    })
                }

            }
        },
        methods: {
            resetFilters() {
                window.open('/admin/resources/c-m-communities', '_self');
            },
            saveCurrentFilter() {
                for (let savedFilter of this.savedFilters) {
                    if(this.savedFilterTitle === savedFilter.label) {
                        this.savedFilterTitle = this.savedFilterTitle + '(' + Math.floor(Math.random() * 100) + 1 + ')';
                    }
                }
                this.$nextTick(() => {
                    Nova.request().post('/nova-vendor/community-filter/saveFilter', {
                        filter: this.encodedFilter,
                        resourceId: 1,
                        title: this.savedFilterTitle
                    }).then(response => {
                        this.savedFilterTitle = "";
                        this.filterSaveButtonClicked = false;
                        this.loadSavedFilters();
                        this.$toasted.show('Filter Saved!!', {type: 'success'})
                    });
                });
            },
            loadSavedFilters() {
                Nova.request().get('/nova-vendor/community-filter/savedFilters').then(response => {
                    this.savedFilters = [];
                    for (let savedFilters of Object.values(response.data)) {
                        this.savedFilters.push(savedFilters)
                    }
                });
            },
            toggleFilterSaveButton() {
                this.filterSaveButtonClicked = !this.filterSaveButtonClicked;
            },
            toggleBulkIdButton() {
                this.bulkButtonClicked = !this.bulkButtonClicked;
            },
            loadCounties(state) {
                if (state) {
                    Nova.request().post('/nova-vendor/community-filter/counties', {
                        communityState: state
                    }).then(response => {
                        this.countyOptions = Object.values(response.data)
                        this.filterValues.county = {id: this.activeFilters.county, label: this.activeFilters.county};
                        this.disableWatch = false;
                    });
                }
            },
            loadSalesCycle() {
                Nova.request().post('/nova-vendor/community-filter/salesCycle').then(response => {
                    console.log('salesCycle Response', response);
                    console.log('this.activeFilters', this.activeFilters);
                    console.log('response.data', Object.values(response.data));
                    this.salesCycleOptions = Object.values(response.data);
                });
            },
            loadStates() {
                Nova.request().get('/nova-vendor/community-filter/states').then(response => {
                    for (let state of Object.values(response.data)) {
                        this.stateOptions.push(state)
                    }
                });
            },
            addOptionToMultiSelectValue(filter, id, options) {
                let option = this[options].find(element => {
                    return element.id === id
                });
                if (filter === 'state') {
                    this.filterValues.state.push(option);
                } else {
                    this.filterValues[filter].push(option)
                }
            },
            loadFilters() {
                this.disableWatch = true;
                console.log('loadFilters Id', this.activeFilters);
                if (this.filtersAreApplied) {
                    this.filterValues.rental = this.activeFilters.rental.value;
                    this.filterValues.vacant = this.activeFilters.vacant.value;
                    this.filterValues.foreclosure = this.activeFilters.foreclosure.value;
                    this.filterValues.state = this.activeFilters.state.value;

                    this.$set(this.filters[0], 'value', this.activeFilters.rental);
                    this.$set(this.filters[1], 'value', this.activeFilters.vacant);
                    this.$set(this.filters[2], 'value', this.activeFilters.foreclosure);
                    this.$set(this.filters[3], 'value', this.activeFilters.size);
                    this.$set(this.filters[4], 'value', this.activeFilters.state);
                    this.$set(this.filters[5], 'value', this.activeFilters.county);
                    this.$set(this.filters[7], 'value', this.activeFilters.bulkId);

                    this.bulkIdText = this.activeFilters.bulkId;
                    if (this.activeFilters.bulkId !== "") {
                        this.bulkButtonClicked = true
                    }
                    this.$nextTick(() => {
                        for (let [key, value] of Object.entries(this.activeFilters.size)) {
                            if (value === true) {
                                this.addOptionToMultiSelectValue('size', parseInt(key), 'sizeOptions')
                            }
                        }
                        if (this.activeFilters.state !== "") {
                            this.disableWatch = true;
                            Nova.request().get('/nova-vendor/community-filter/states').then(response => {
                                for (let state of Object.values(response.data)) {
                                    if (state.id === this.activeFilters.state) {
                                        this.filterValues.state.push(state);
                                        this.loadCounties(state.id)
                                    }
                                }
                            });
                        }
                    })

                }
                this.disableWatch = false;
            },
            clearRentalFilters() {
                this.filters[0].value.value = false;
            },
            clearVacantFilters() {
                this.filters[1].value.value = false;
            },
            clearForeclosureFilters() {
                this.filters[2].value.value = false;
            },
            clearSizeFilters() {
                this.filters[3].value[0] = false;
                this.filters[3].value[1] = false;
                this.filters[3].value[2] = false;
                this.filters[3].value[3] = false;
                this.filters[3].value[4] = false;
            },
            clearStateFilter() {
                this.filters[4].value = ""
            }
        },
        computed: {
            sameFilters() {
                for (let savedFilter of this.savedFilters) {
                    if(this.encodedFilter === savedFilter.filter) {
                        return true;
                    }
                }
                return false;
            },
            activeFilters() {
                return {
                    rental: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityRentalSalesStatus')).currentValue,
                    vacant: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityVacantSalesStatus')).currentValue,
                    foreclosure: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityForeclosureSalesStatus')).currentValue,
                    size: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunitySize')).currentValue,
                    rm: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\RelationshipManager')).currentValue,
                    state: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityState')).currentValue,
                    county: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityCounty')).currentValue,
                    bulkId: (this.$store.getters[`${this.resourceName}/getFilter`]('Prochamps\\BulkId\\BulkId')).currentValue,
                    SalesCycle: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunitySalesCycle')).currentValue,
                };
            },
            filtersAreApplied() {
                return this.$store.getters[`${this.resourceName}/filtersAreApplied`]
            },
            encodedFilter() {
                return Buffer.from(this.filterString, 'binary').toString('base64')
            },
            filterString() {
                return JSON.stringify(this.filters);
            },
            filterUrl() {
                return "/admin/resources/c-m-communities?c-m-communities_filter=" + this.encodedFilter
            }
        },
        created() {
            this.loadStates();
            this.loadSavedFilters();
        },
        mounted() {
            this.loadFilters();
            this.loadSalesCycle();
        },

    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 26px;
    }

    .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 7px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    .switchText{
        position: absolute;
        top: 6px;
        font-weight: 700;
        font-size: 13px;
        color: #007509;
    }
    .switchTextL{
        left: 5px;
        color: white;
    }
    .switchTextR{
        right: 4px;
    }
</style>
