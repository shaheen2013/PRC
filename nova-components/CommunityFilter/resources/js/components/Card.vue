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
            <multiselect v-model="filterValues.rental" :options="salesStatusOptions" :multiple="true"
                         :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                         placeholder="Rental Sales Status" label="label" track-by="id"
                         :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="filterValues.vacant" :options="salesStatusOptions" :multiple="true"
                         :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                         placeholder="Vacant Sales Status" label="label" track-by="id"
                         :preselect-first="false" :show-labels="false"></multiselect>
        </div>
        <div class="px-3 py-3">
            <multiselect v-model="filterValues.foreclosure" :options="salesStatusOptions" :multiple="true"
                         :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                         placeholder="Foreclosure Sales Status" label="label" track-by="id"
                         :preselect-first="false" :show-labels="false"></multiselect>
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
                            1: false,
                            5: false,
                            6: false,
                            7: false,
                            11: false,
                            12: false,
                            14: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityVacantSalesStatus",
                        value: {
                            1: false,
                            5: false,
                            6: false,
                            7: false,
                            11: false,
                            12: false,
                            14: false
                        }
                    },
                    {
                        class: "App\\Nova\\Filters\\CommunityForeclosureSalesStatus",
                        value: {
                            1: false,
                            5: false,
                            6: false,
                            7: false,
                            11: false,
                            12: false,
                            14: false
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
                        value: ""
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
                    }
                ],
                filterValues: {
                    rental: [],
                    vacant: [],
                    foreclosure: [],
                    size: [],
                    state: [],
                    county: []
                },
                blankFilterValues: {
                    rental: [],
                    vacant: [],
                    foreclosure: [],
                    size: [],
                    state: [],
                    county: []
                },
                salesStatusOptions: [
                    {id: 1, label: 'No Activity'},
                    {id: 7, label: 'Generate'},
                    {id: 11, label: 'Guide'},
                    {id: 12, label: 'Propose'},
                    {id: 6, label: 'Onboard'},
                    {id: 5, label: 'Enhance'},
                ],
                sizeOptions: [
                    {id: 0, label: 'X-Small'},
                    {id: 1, label: 'Small'},
                    {id: 2, label: 'Medium'},
                    {id: 3, label: 'Large'},
                    {id: 4, label: 'X-Large'},
                ],
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
            'filterValues.rental': function (val) {
                this.clearRentalFilters();
                for (let filter of val) {
                    this.filters[0].value[filter.id] = true
                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.vacant': function (val) {
                this.clearVacantFilters();
                for (let filter of val) {
                    this.filters[1].value[filter.id] = true
                }
                this.$router.push({
                    path: '/resources/c-m-communities',
                    query: {'c-m-communities_filter': this.encodedFilter}
                })
            },
            'filterValues.foreclosure': function (val) {
                this.clearForeclosureFilters();
                for (let filter of val) {
                    this.filters[2].value[filter.id] = true
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
                    console.log('New Val: ' + val);
                    console.log('Old Value: ' + oldval);
                    this.filters[4].value = val ? val.id : null;
                    if (!val) {
                        this.filters[5].value = "";
                        this.countyOptions = [];
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
                    console.log(val);
                    this.filters[5].value = val ? val.id : null;
                    this.$router.push({
                        path: '/resources/c-m-communities',
                        query: {'c-m-communities_filter': this.encodedFilter}
                    })
                }

            },
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
                    console.log(response);
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
                        console.log(Object.values(response.data))
                        this.countyOptions = Object.values(response.data)
                        this.filterValues.county = {id: this.activeFilters.county, label: this.activeFilters.county};
                        this.disableWatch = false;
                    });
                }
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

                if (this.filtersAreApplied) {
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
                        for (let [key, value] of Object.entries(this.activeFilters.rental)) {
                            if (value === true) {
                                this.addOptionToMultiSelectValue('rental', parseInt(key), 'salesStatusOptions')
                            }
                        }
                        for (let [key, value] of Object.entries(this.activeFilters.vacant)) {
                            if (value === true) {
                                this.addOptionToMultiSelectValue('vacant', parseInt(key), 'salesStatusOptions')
                            }
                        }
                        for (let [key, value] of Object.entries(this.activeFilters.foreclosure)) {
                            if (value === true) {
                                this.addOptionToMultiSelectValue('foreclosure', parseInt(key), 'salesStatusOptions')
                            }
                        }
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
                this.filters[0].value[1] = false;
                this.filters[0].value[5] = false;
                this.filters[0].value[6] = false;
                this.filters[0].value[7] = false;
                this.filters[0].value[11] = false;
                this.filters[0].value[12] = false;
                this.filters[0].value[14] = false;
            },
            clearVacantFilters() {
                this.filters[1].value[1] = false;
                this.filters[1].value[5] = false;
                this.filters[1].value[6] = false;
                this.filters[1].value[7] = false;
                this.filters[1].value[11] = false;
                this.filters[1].value[12] = false;
                this.filters[1].value[14] = false;
            },
            clearForeclosureFilters() {
                this.filters[2].value[1] = false;
                this.filters[2].value[5] = false;
                this.filters[2].value[6] = false;
                this.filters[2].value[7] = false;
                this.filters[2].value[11] = false;
                this.filters[2].value[12] = false;
                this.filters[2].value[14] = false;
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
                    bulkId: (this.$store.getters[`${this.resourceName}/getFilter`]('Prochamps\\BulkId\\BulkId')).currentValue
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
        },

    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css">
</style>
