<template>
    <card class="flex flex-col items-center justify-center">
        <div class="flex item-center justify-center flex-wrap w-full">
            <div class="text-grey-darker text-center px-4 py-2 m-2 content-center resultsBox hoverShadow "
                 v-for="(count, index) in counts"
            >
                <h2 class="mt-8">{{index | capitalize}}</h2>
                <br><br>
                <h1>
                    <animated-number
                            :value="count"
                            :formatValue="formatNumber"
                            :duration="resultsAnimationDuration"
                            :round="true"
                    />
                </h1>
            </div>
        </div>
    </card>
</template>

<script>
    import AnimatedNumber from "animated-number-vue";

    export default {
        filters: {
            capitalize: function (value) {
                if (!value) return '';
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        components: {
            AnimatedNumber
        },
        props: {
            card: {
                required: true,
            },
            resourceName: {
                type: String,
                required: true,
            }
        },
        data: () => ({
            resultsAnimationDuration: 700,
            counts: {
                communities: 0,
                households: 0,
                rental: 0,
                vacant: 0,
                foreclosure: 0
            }
        }),
        methods: {
            postCounts() {
                Nova.request().post('/nova-vendor/community-list-dashboard/count', {
                    filtersAreApplied: this.filtersAreApplied,
                    filters: this.filters
                }).then(response => {
                    this.counts = response.data;
                });
            },
            formatNumber: function (value) {
                let si = [
                    {value: 1, symbol: ""},
                    {value: 1E3, symbol: "K"},
                    {value: 1E6, symbol: "M"},
                ];
                let rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
                let i;
                for (i = si.length - 1; i > 0; i--) {
                    if (value >= si[i].value) {
                        break;
                    }
                }
                return (value / si[i].value).toFixed(1).replace(rx, "$1") + si[i].symbol;
            },
        },
        watch: {
            filters: {
                handler(val){
                    this.postCounts();
                },
                deep: true
            }
        },
        computed: {
            filters() {
                return {
                    rental: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityRentalSalesStatus')).currentValue,
                    vacant: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityVacantSalesStatus')).currentValue,
                    foreclosure: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityForeclosureSalesStatus')).currentValue,
                    size: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunitySize')).currentValue,
                    rm: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\RelationshipManager')).currentValue,
                    state: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityState')).currentValue,
                    county: (this.$store.getters[`${this.resourceName}/getFilter`]('App\\Nova\\Filters\\CommunityCounty')).currentValue,
                    bulkId: (this.$store.getters[`${this.resourceName}/getFilter`]('Prochamps\\BulkId\\BulkId')).currentValue,
                };
            },
            filtersAreApplied() {
                return this.$store.getters[`${this.resourceName}/filtersAreApplied`]
            }
        },
        mounted() {
            this.postCounts();
        },
    }
</script>

<style scoped>
    .resultsBox {
        border: 1px solid #7F888F;
        border-radius: 5px;
        height: 200px;
        width: 200px;
    }
    .hoverShadow:hover {
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, .11), 0 5px 15px 0 rgba(0, 0, 0, .08);
    }
    .hoverShadow:focus {
        box-shadow: 0 0 0 0;
    }
</style>
